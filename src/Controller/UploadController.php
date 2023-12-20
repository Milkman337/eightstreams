<?php

namespace App\Controller;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\CurrentUser;

class UploadController extends AbstractController
{
    public function __construct(
        private readonly 
    )
    {
    }

    #[Route('/upload', name: 'app_upload')]
    public function index(Request $request, #[CurrentUser] User $user): Response
    {

        /** @var UploadedFile $uploadedFile */
        $uploadedFile = $request->files->get('upload');

        $destination = $this->getParameter('kernel.project_dir').'/uploads/'.$user->getId().'/videos';

        $filename = uniqid() . sha1(time());
        $uploadedFile->move($destination, $filename);

        return $this->render('upload/index.html.twig', [
            'controller_name' => 'UploadController',
        ]);
    }
}
