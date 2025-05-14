<?php

namespace App\Controller;

use App\Entity\File;
use App\Form\FileType;
use App\Form\SearchType;
use App\Repository\FileRepository;
use App\Controller\DateTimeImmutable;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Component\Finder\Finder;



#[Route('/dashboard/file')]
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
    public function new(Request $request, FileRepository $fileRepository,  SluggerInterface $slugger, EntityManagerInterface $entityManager): Response
    {
        $file = new File();
        $form = $this->createForm(FileType::class, $file);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

             /** @var UploadedFile $file */
             $doc = $form->get('file')->getData();
             $folderName = $form->get('folder')->getData();
             
             if ($doc) {
                 // On garde le nom original
                 $originalFilename = pathinfo($doc->getClientOriginalName(), PATHINFO_FILENAME);
                 $extension = $doc->guessExtension();
 
                 // Pour éviter les conflits, on peut ajouter un identifiant unique si nécessaire
                 $safeFilename = $slugger->slug($originalFilename);
                 $newFilename = $originalFilename . '.' . $extension;
 
                 // Déplacement dans le dossier voulu (par exemple /public/uploads)
                 $doc->move(
                     $this->getParameter('uploads_directory').$folderName->getName(),
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

        $files = $fileRepository->findAll();

        $groupedFiles = [];
        foreach ($files as $file) {
            $folderEntity = $file->getFolder(); // Si c’est une entité
            $folderName = $folderEntity ? $folderEntity->getName() : 'Sans dossier';
            
            $groupedFiles[$folderName][] = $file;
        }

        return $this->render('file/new.html.twig', [
            'file' => $file,
            'form' => $form,
        ]);

    }

   #[Route('/deleted_files', name:'app_file_deleted', methods:['GET'])]
   public function deletedFiles(FileRepository $fileRepository): Response
   {
    $files = $fileRepository->findDeletedFiles();
    return $this ->render('file/index.html.twig',  [
        'files' => $files,
    ]);
   }

   #[Route('/recent_files', name:'app_file_recent', methods:['GET'])]
   public function recent(FileRepository $fileRepository): Response
   {
    $files =$fileRepository->findRecentFiles();
    return $this ->render('file/index.html.twig', [
        'files' => $files,   
    ]);
   }

   #[Route('/uploaded_imageFiles', name:'app_file_uploaded_image', methods: ['GET'])]
   public function imageFiles(FileRepository $fileRepository): Response
   {

    $files = $fileRepository->findByFileExtension('jpg');
    return $this ->render('file/index.html.twig', [
        'files' =>$files,
]);
}

    #[Route('/uploaded_videoFiles', name:'app_file_uploaded_video', methods: ['GET'])]
    public function videoFiles(FileRepository $fileRepository): Response
    {

        $files = $fileRepository->findByFileExtension('mp4','webm', 'ogg');
        return $this ->render('file/index.html.twig', [
            'files' =>$files,
    ]);
    } 

    #[Route('/uploaded_zipFiles', name:'app_file_uploaded_zip', methods: ['GET'])]
    public function zipFiles(FileRepository $fileRepository): Response
    {

        $files = $fileRepository->findByZipExtension('ZIP');
        return $this ->render('file/index.html.twig', [
            'files' =>$files,
    ]);
    } 

    #[Route('/search', name: 'app_file_search',)]
    public function search(Request $request, FileRepository $fileRepository): Response
    {
        $form =$this->createForm(SearchType::class);
        $form -> handleRequest($request);
            $files =[];
             if ($form -> isSubmitted() && $form -> isValid())
             {
                $keyword =$form->get('keyword')->getData();
                $files = $fileRepository->findByKeyword($keyword);
             }

        return $this->render('search.html.twig', [
            'form' => $form->createView(), // this is required
            'files' => $files,
        ]);
    }


    #[Route('/show/{id}', name: 'app_file_show', methods: ['GET'])]
    public function show(File $file): Response
    {
        return $this->render('file/show.html.twig', [
            'file' => $file,
     ]);
    }

     #[Route('/file', name: 'file_all')]
    public function implement(FileRepository $fileRepository): Response
    {
        $file = $fileRepository->findAll();

        return $this->render('file/all.html.twig', [
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

    #[Route('file/{id}/delete', name: 'app_file_delete', methods: ['POST'])]
    public function delete(Request $request, File $file, FileRepository $fileRepository, EntityManagerInterface $entityManager): Response
    {
       //Verifier si le user est admin ou utilisateur
       if($this->isGranted('ROLE_ADMIN') || $file->getUser() == $this->getUser()){
        // Marquer le document comme supprimé
        $file->setDeletedAt(new \DateTimeImmutable('now'));

        // Enregistrer les changements dans la base de données
        $entityManager->flush();
        return $this->redirectToRoute('app_file_index');
        return $this->redirectToRoute('file_list');
        }

        // Si le user est utilisateur
        throw $this->createAccessDeniedException();

         // Vérifiez si l'utilisateur est un administrateur
         if ($this->isGranted('ROLE_ADMIN')) {
            // Logique de suppression pour un administrateur
            $fileRepository->remove($file);
            $this->addFlash('success', 'Document supprimé avec succès !');
            return $this->redirectToRoute('file_list');
        }
        
        // Si l'utilisateur est un simple utilisateur, vérifiez s'il est autorisé à supprimer
        if ($this->isGranted('ROLE_USER') && $file->getUser() === $this->getUser()) {
            // Logique de suppression pour un utilisateur (l'utilisateur peut supprimer ses propres documents)
            $file->setDeletedAt(new \DateTimeImmutable('now'));
            $this->addFlash('success', 'Votre document a été supprimé avec succès.');
            return $this->redirectToRoute('file_list');
        }

        // Si l'utilisateur n'a pas les droits nécessaires
        throw new AccessDeniedException("Vous n'êtes pas autorisé à effectuer cette action.");
    }


    public function upload(Request $request, EntityManagerInterface $entityManager, SluggerInterface $slugger): Response
    {
        $file = new file();
        $form = $this->createForm(FileType::class, $file);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var UploadedFile $file */
            $file = $form->get('file')->getData();
            $folderName = $form->get('folder')->getData();
            if ($file) {
                // On garde le nom original
                $originalFilename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
                $extension = $file->guessExtension();

                // Pour éviter les conflits, on peut ajouter un identifiant unique si nécessaire
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $originalFilename . '.' . $extension;

                // Déplacement dans le dossier voulu (par exemple /public/uploads)
                $file->move(
                    $this->getParameter('uploads_directory').$folderName->getName(),
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

        
