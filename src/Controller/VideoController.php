<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Video;
use App\Repository\VideoRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\CurrentUser;

class VideoController extends AbstractController
{
    public function __construct(
        private readonly VideoRepository $videoRepository
    )
    {
    }

    #[Route('/videos/{page?}', name: 'app_video')]
    public function index(#[CurrentUser] User $user, ?string $page): Response
    {
        $page = (int)$page === 0 ? 1 : (int)$page;

        $itemsPerPage = 9;
        $videos = $this->videoRepository->findBy([], [], $itemsPerPage, $itemsPerPage * ($page - 1));

        return $this->render('video/index.html.twig', [
            'videos' => $videos,
            'page' => $page,
            'num_pages' => ceil($this->videoRepository->count([]) / $itemsPerPage),
            'user' => $user,
        ]);
    }

    #[Route('/video/{id}', name: 'app_video_details')]
    public function video(#[CurrentUser] User $user, Video $video): Response
    {
        return $this->render('video/detail.html.twig', [
            'video' => $video,
            'user' => $user,
        ]);
    }

    #[Route('/servevideo/{id}', name: 'app_serve_video')]
    public function serve(#[CurrentUser] User $user, Video $video)
    {
        //dd($this->getParameter('kernel.project_dir').'/uploads/'.$video->getOwner()->getId().'/videos/'.$video->getFilename());
        $response = new BinaryFileResponse($this->getParameter('kernel.project_dir').'/uploads/'.$video->getOwner()->getId().'/videos/'.$video->getFilename());


        return $response;
    }
}
