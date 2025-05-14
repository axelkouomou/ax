<?php

namespace App\Controller;

use App\Entity\File;
use App\Entity\Folder;
use App\Repository\FileRepository;
use App\Repository\FolderRepository;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Component\HttpFoundation\Response;

#[Route('/dashboard')]
#[IsGranted('ROLE_USER')]
class DashboardController extends AbstractController
{
    #[Route('/dashboard', name: 'app_dashboard')]
    public function index( FileRepository $fileRepository, FolderRepository $folderRepository): Response
    {
        $files =$fileRepository->findRecentFiles();
        return $this ->render('dashboard/index.html.twig', [
            'files' => $files,
        ]);
    }

    public function folders(FolderRepository $folderRepository): Response
    {
        $folder = $folderRepository->find(1);
        return $this->render('folder_tree.html.twig',['folder' => $folder]);
    }    

}