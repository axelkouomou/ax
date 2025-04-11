<?php

namespace App\Controller;

use App\Entity\File;
use App\Form\FileType;
use App\Repository\FileRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\String\Slugger\SluggerInterface;


#[Route('/file')]
final class FileController extends AbstractController
{
    #[Route(name: 'app_file_index', methods: ['GET'])]
    public function index(FileRepository $fileRepository): Response
    {
        $files = $fileRepository->findBy(['deletedAt'=>null]);

        return $this->render('file/index.html.twig', [
            'files' => $files,
        ]);
    }

    #[Route('/new', name: 'app_file_new', methods: ['GET', 'POST'])]
    public function new(Request $request, SluggerInterface $slugger, EntityManagerInterface $entityManager): Response
    {
        $file = new File();
        $form = $this->createForm(FileType::class, $file);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

             /** @var UploadedFile $file */
             $doc = $form->get('file')->getData();

             if ($doc) {
                 // On garde le nom original
                 $originalFilename = pathinfo($doc->getClientOriginalName(), PATHINFO_FILENAME);
                 $extension = $doc->guessExtension();
 
                 // Pour éviter les conflits, on peut ajouter un identifiant unique si nécessaire
                 $safeFilename = $slugger->slug($originalFilename);
                 $newFilename = $originalFilename . '.' . $extension;
 
                 // Déplacement dans le dossier voulu (par exemple /public/uploads)
                 $doc->move(
                     $this->getParameter('uploads_directory'),
                     $newFilename
                 );
 
                 // Optionnel : on stocke le nom du fichier dans l’entité
                 $file->setFilename($newFilename);
             }
            $file->setUser($this->getUser());
            $entityManager->persist($file);
            $entityManager->flush();

            return $this->redirectToRoute('app_file_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('file/new.html.twig', [
            'file' => $file,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_file_show', methods: ['GET'])]
    public function show(File $file): Response
    {
        return $this->render('file/show.html.twig', [
            'file' => $file,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_file_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, File $file, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(FileType::class, $file);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_file_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('file/edit.html.twig', [
            'file' => $file,
            'form' => $form,
        ]);
    }

    #[Route('/{id}/delete', name: 'app_file_delete', methods: ['POST'])]
    public function delete(Request $request, File $file, EntityManagerInterface $entityManager): Response
    {
       //Verifier si le user est admin ou utilisateur
       if($this->isGranted('ROLE_ADMIN') || $file->getUser() == $this->getUser()){
        // Marquer le document comme supprimé
        $file->setDeletedAt(new \DateTimeImmutable('now'));


        // Enregistrer les changements dans la base de données
        $entityManager->flush();
        return $this->redirectToRoute('app_file_index');
        }

        // Si le user est utilisateur
        throw $this->createAccessDeniedException();
    }

    public function upload(Request $request, EntityManagerInterface $entityManager, SluggerInterface $slugger): Response
    {
        $file = new file();
        $form = $this->createForm(FileType::class, $file);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var UploadedFile $file */
            $file = $form->get('file')->getData();

            if ($file) {
                // On garde le nom original
                $originalFilename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
                $extension = $file->guessExtension();

                // Pour éviter les conflits, on peut ajouter un identifiant unique si nécessaire
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $originalFilename . '.' . $extension;

                // Déplacement dans le dossier voulu (par exemple /public/uploads)
                $file->move(
                    $this->getParameter('uploads_directory'),
                    $newFilename
                );

                // Optionnel : on stocke le nom du fichier dans l’entité
                $file->setFilename($newFilename);

                // Sauvegarde en base si tu veux
                $entityManager->persist($file);
                $entityManager->flush();

                $this->addFlash('success', 'Fichier uploadé avec succès !');
                return $this->redirectToRoute('document_list');
            }
        }

        return $this->render('document/upload.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}

        
