<?php

namespace App\Controller;

use App\Entity\Projet;
use App\Repository\ProjetRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'home', methods: ['GET'])]
    public function index(ProjetRepository $repository): Response
    {
        $projects = $repository->findAll();
        return $this->render('home.html.twig', compact("projects"));
    }

    #[Route('/front/show/{id}', name: 'front_projet_show', methods: ['GET'])]
    public function show(Projet $projet, ProjetRepository $repository): Response
    {
        $project = $repository->find($projet);
        return $this->render('frontend/show.html.twig', compact("project"));
    }
}