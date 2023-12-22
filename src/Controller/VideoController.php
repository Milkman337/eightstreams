<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Video;
use App\Repository\VideoRepository;
use App\Service\PaginationService;
use App\Service\VideoService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\CurrentUser;

class VideoController extends AbstractController
{
    public function __construct(
        private readonly VideoRepository   $videoRepository,
        private readonly VideoService      $videoService,
        private readonly PaginationService $paginationService,
    )
    {
    }

    #[Route('/videos/{page?}', name: 'app_video')]
    public function index(#[CurrentUser] User $user, ?string $page): Response
    {
        $pagination = $this->paginationService->createPagination($page, $this->videoRepository);

        return $this->render('video/index.html.twig', [
            'videos' => $pagination->getItems(),
            'page' => $pagination->getPage(),
            'num_pages' => $pagination->getNumPages(),
            'user' => $user,
        ]);
    }

    #[Route('/video/{id}', name: 'app_video_details')]
    public function video(#[CurrentUser] User $user, Video $video): Response
    {
        $this->videoService->addVideoWatch($video, $user);
        $this->videoService->addView($video);

        return $this->render('video/detail.html.twig', [
            'video' => $video,
            'user' => $user,
        ]);
    }

    #[Route('/servevideo/{id}', name: 'app_serve_video')]
    public function serve(#[CurrentUser] User $user, Video $video): BinaryFileResponse
    {
        //dd($this->getParameter('kernel.project_dir').'/uploads/'.$video->getOwner()->getId().'/videos/'.$video->getFilename());
        return $this->videoService->getVideoFile($video, $this->getParameter('kernel.project_dir'));
    }


}
