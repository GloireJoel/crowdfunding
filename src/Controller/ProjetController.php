<?php

namespace App\Controller;

use App\Entity\Projet;
use App\Entity\User;
use App\Form\ProjetType;
use App\Repository\PlanFinancierRepository;
use App\Repository\ProjetRepository;
use App\Service\NotificationService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Twilio\Exceptions\ConfigurationException;
use Twilio\Exceptions\TwilioException;

#[Route('/projet')]
class ProjetController extends AbstractController
{
    #[Route('/', name: 'app_projet_index', methods: ['GET'])]
    public function index(ProjetRepository $projetRepository): Response
    {
        return $this->render('projet/index.html.twig', [
            'projets' => $projetRepository->findAll(),
        ]);
    }

    #[Route('/projects', name: 'app_projects', methods: ['GET'])]
    public function projects(ProjetRepository $projetRepository): Response
    {
        /** @var User $user */
        $user = $this->getUser();
        $projects = $projetRepository->findByUser($user);
       return $this->render('projet/projects.html.twig', compact('projects'));
    }

    /**
     * @throws ConfigurationException
     * @throws TwilioException
     */
    #[Route('/new', name: 'app_projet_new', methods: ['GET', 'POST'])]
    public function new(Request $request, ProjetRepository $projetRepository): Response
    {
        /** @var User $user */
        $user = $this->getUser();
        $projet = new Projet();
        $form = $this->createForm(ProjetType::class, $projet);
        $form->handleRequest($request);

        $message = 'M/Mme'.$user->getPrenom().', votre projet a bien été enregistré et vous serez notifié par mail dès qu\'il sera validé.';

        if ($form->isSubmitted() && $form->isValid()) {
            $projet->setUser($user);
            $projetRepository->save($projet, true);
            NotificationService::sendSMS($user->getTelephone(), $message);
            return $this->redirectToRoute('app_projet_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('projet/new.html.twig', [
            'projet' => $projet,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_projet_show', methods: ['GET'])]
    public function show(Projet $projet, PlanFinancierRepository $planFinancierRepository): Response
    {
        $somme = $planFinancierRepository->somme($projet);

        return $this->render('projet/show.html.twig', [
            'projet' => $projet,
            'somme' => $somme
        ]);
    }

    #[Route('/{id}/edit', name: 'app_projet_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Projet $projet, ProjetRepository $projetRepository): Response
    {
        $form = $this->createForm(ProjetType::class, $projet);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $projetRepository->save($projet, true);

            return $this->redirectToRoute('app_projet_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('projet/edit.html.twig', [
            'projet' => $projet,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_projet_delete', methods: ['POST'])]
    public function delete(Request $request, Projet $projet, ProjetRepository $projetRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$projet->getId(), $request->request->get('_token'))) {
            $projetRepository->remove($projet, true);
        }

        return $this->redirectToRoute('app_projet_index', [], Response::HTTP_SEE_OTHER);
    }
}
