<?php

namespace App\Controller;

use App\Entity\PlanFinancier;
use App\Form\PlanFinancierType;
use App\Repository\PlanFinancierRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/plan/financier')]
class PlanFinancierController extends AbstractController
{
    #[Route('/', name: 'app_plan_financier_index', methods: ['GET'])]
    public function index(PlanFinancierRepository $planFinancierRepository): Response
    {
        return $this->render('plan_financier/index.html.twig', [
            'plan_financiers' => $planFinancierRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_plan_financier_new', methods: ['GET', 'POST'])]
    public function new(Request $request, PlanFinancierRepository $planFinancierRepository): Response
    {
        $planFinancier = new PlanFinancier();
        $form = $this->createForm(PlanFinancierType::class, $planFinancier);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $planFinancierRepository->save($planFinancier, true);

            return $this->redirectToRoute('app_plan_financier_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('plan_financier/new.html.twig', [
            'plan_financier' => $planFinancier,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_plan_financier_show', methods: ['GET'])]
    public function show(PlanFinancier $planFinancier): Response
    {
        return $this->render('plan_financier/show.html.twig', [
            'plan_financier' => $planFinancier,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_plan_financier_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, PlanFinancier $planFinancier, PlanFinancierRepository $planFinancierRepository): Response
    {
        $form = $this->createForm(PlanFinancierType::class, $planFinancier);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $planFinancierRepository->save($planFinancier, true);

            return $this->redirectToRoute('app_plan_financier_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('plan_financier/edit.html.twig', [
            'plan_financier' => $planFinancier,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_plan_financier_delete', methods: ['POST'])]
    public function delete(Request $request, PlanFinancier $planFinancier, PlanFinancierRepository $planFinancierRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$planFinancier->getId(), $request->request->get('_token'))) {
            $planFinancierRepository->remove($planFinancier, true);
        }

        return $this->redirectToRoute('app_plan_financier_index', [], Response::HTTP_SEE_OTHER);
    }
}
