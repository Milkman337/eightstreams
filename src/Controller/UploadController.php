<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Video;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\CurrentUser;

class UploadController extends AbstractController
{
    public function __construct(
        private readonly EntityManagerInterface $entityManager
    )
    {
    }

    #[Route('/upload', name: 'app_upload')]
    public function index(Request $request, #[CurrentUser] User $user): Response
    {

        /** @var UploadedFile $uploadedFile */
        $uploadedFile = $request->files->get('upload');

        if ($uploadedFile?->getMimeType() == 'video/mp4') {
            $destination = $this->getParameter('kernel.project_dir') . '/uploads/' . $user->getId() . '/videos';

            $filename = uniqid() . sha1(time());
            $uploadedFile->move($destination, $filename);

            $video = new Video();
            $video
                ->setOwner($user)
                ->setFilename($filename)
                ->setTitle($request->request->get('title'))
                ->setViews(0);

            $this->entityManager->persist($video);
            $this->entityManager->flush();
        }

        return $this->render('upload/index.html.twig', [
            'controller_name' => 'UploadController',
        ]);
    }
}
