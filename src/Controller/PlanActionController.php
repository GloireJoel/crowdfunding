<?php

namespace App\Controller;

use App\Entity\PlanAction;
use App\Form\PlanActionType;
use App\Repository\PlanActionRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/plan/action')]
class PlanActionController extends AbstractController
{
    #[Route('/', name: 'app_plan_action_index', methods: ['GET'])]
    public function index(PlanActionRepository $planActionRepository): Response
    {
        return $this->render('plan_action/index.html.twig', [
            'plan_actions' => $planActionRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_plan_action_new', methods: ['GET', 'POST'])]
    public function new(Request $request, PlanActionRepository $planActionRepository): Response
    {
        $planAction = new PlanAction();
        $form = $this->createForm(PlanActionType::class, $planAction);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $planActionRepository->save($planAction, true);

            return $this->redirectToRoute('app_plan_action_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('plan_action/new.html.twig', [
            'plan_action' => $planAction,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_plan_action_show', methods: ['GET'])]
    public function show(PlanAction $planAction): Response
    {
        return $this->render('plan_action/show.html.twig', [
            'plan_action' => $planAction,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_plan_action_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, PlanAction $planAction, PlanActionRepository $planActionRepository): Response
    {
        $form = $this->createForm(PlanActionType::class, $planAction);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $planActionRepository->save($planAction, true);

            return $this->redirectToRoute('app_plan_action_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('plan_action/edit.html.twig', [
            'plan_action' => $planAction,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_plan_action_delete', methods: ['POST'])]
    public function delete(Request $request, PlanAction $planAction, PlanActionRepository $planActionRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$planAction->getId(), $request->request->get('_token'))) {
            $planActionRepository->remove($planAction, true);
        }

        return $this->redirectToRoute('app_plan_action_index', [], Response::HTTP_SEE_OTHER);
    }
}
