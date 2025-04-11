<?php

namespace App\Controller;

use App\Entity\File;
use App\Entity\Folder;
use App\Entity\UserAction;
use App\Repository\FileRepository;
use App\Repository\FolderRepository;
use App\Repository\UserActionRepository;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

#[Route('/dashboard')]
#[IsGranted('ROLE_USER')]
class DashboardController extends AbstractController
{
    #[Route('/dashboard', name: 'app_dashboard')]
    public function index(): Response
    {
        return $this->render('dashboard/index.html.twig')["controller_name' => 'DashboardController"];
    }

    #[Route('/archives', name: 'dashboard_archives', methods: ['GET'])]
    public function viewArchived(Request $request, FileRepository $fileRepo): Response
    {
        $date = $request->query->get('date');
        $archivedFiles = $fileRepo->findArchivedByDate(new \DateTime($date));

        return $this->render('dashboard/archives.html.twig', [
            'files' => $archivedFiles
        ]);
    }

    #[Route('/{id}/delete', name: 'dashboard_file_delete', methods: ['POST'])]
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

        $log = new UserAction();
        $log->setUser($this->getUser());
        $log->setActionType('DELETE');
        $log->setTargetEntity('File: ' . $file->getName());
        $log->setDate(new \DateTime());

        $em->persist($log);
        $em->flush();

        return $this->json(['success' => 'Fichier supprimé']);
    }

    #[Route('/deleted', name: 'dashboard_deleted_files', methods: ['GET'])]
    #[IsGranted('ROLE_ADMIN')]
    public function viewDeleted(FileRepository $fileRepo): Response
    {
        $deletedFiles = $fileRepo->findBy(['isDeleted' => true]);

        return $this->render('dashboard/deleted.html.twig', [
            'files' => $deletedFiles
        ]);
    }
}