<?php

namespace App\Controller;

use App\Entity\PlanCommunication;
use App\Form\PlanCommunicationType;
use App\Repository\PlanCommunicationRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/plan/communication')]
class PlanCommunicationController extends AbstractController
{
    #[Route('/', name: 'app_plan_communication_index', methods: ['GET'])]
    public function index(PlanCommunicationRepository $planCommunicationRepository): Response
    {
        return $this->render('plan_communication/index.html.twig', [
            'plan_communications' => $planCommunicationRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_plan_communication_new', methods: ['GET', 'POST'])]
    public function new(Request $request, PlanCommunicationRepository $planCommunicationRepository): Response
    {
        $planCommunication = new PlanCommunication();
        $form = $this->createForm(PlanCommunicationType::class, $planCommunication);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $planCommunicationRepository->save($planCommunication, true);

            return $this->redirectToRoute('app_plan_communication_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('plan_communication/new.html.twig', [
            'plan_communication' => $planCommunication,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_plan_communication_show', methods: ['GET'])]
    public function show(PlanCommunication $planCommunication): Response
    {
        return $this->render('plan_communication/show.html.twig', [
            'plan_communication' => $planCommunication,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_plan_communication_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, PlanCommunication $planCommunication, PlanCommunicationRepository $planCommunicationRepository): Response
    {
        $form = $this->createForm(PlanCommunicationType::class, $planCommunication);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $planCommunicationRepository->save($planCommunication, true);

            return $this->redirectToRoute('app_plan_communication_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('plan_communication/edit.html.twig', [
            'plan_communication' => $planCommunication,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_plan_communication_delete', methods: ['POST'])]
    public function delete(Request $request, PlanCommunication $planCommunication, PlanCommunicationRepository $planCommunicationRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$planCommunication->getId(), $request->request->get('_token'))) {
            $planCommunicationRepository->remove($planCommunication, true);
        }

        return $this->redirectToRoute('app_plan_communication_index', [], Response::HTTP_SEE_OTHER);
    }
}
