<?php

namespace App\Controller;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\CurrentUser;

class HomeController extends AbstractController
{
    #[Route('/home', name: 'app_home')]
    public function index(#[CurrentUser] User $user): Response
    {
        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
            'user' => $user,
        ]);
    }
}
