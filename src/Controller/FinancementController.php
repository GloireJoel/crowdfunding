<?php

namespace App\Controller;

use App\Entity\Financement;
use App\Form\FinancementType;
use App\Repository\FinancementRepository;
use App\Service\NotificationService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Twilio\Exceptions\ConfigurationException;
use Twilio\Exceptions\TwilioException;

#[Route('/financement')]
class FinancementController extends AbstractController
{
    #[Route('/', name: 'app_financement_index', methods: ['GET'])]
    public function index(FinancementRepository $financementRepository): Response
    {
        return $this->render('financement/index.html.twig', [
            'financements' => $financementRepository->findAll(),
        ]);
    }

    /**
     * @throws ConfigurationException
     * @throws TwilioException
     */
    #[Route('/new', name: 'app_financement_new', methods: ['GET', 'POST'])]
    public function new(Request $request, FinancementRepository $financementRepository): Response
    {
        $financement = new Financement();
        $form = $this->createForm(FinancementType::class, $financement);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $financementRepository->save($financement, true);
            NotificationService::sendSMS('+243810952606', "Votre projet a  plan financier a été financé avec" . $financement->getMontant() . "Merci de votre confiance.");

            return $this->redirectToRoute('app_financement_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('financement/new.html.twig', [
            'financement' => $financement,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_financement_show', methods: ['GET'])]
    public function show(Financement $financement): Response
    {
        return $this->render('financement/show.html.twig', [
            'financement' => $financement,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_financement_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Financement $financement, FinancementRepository $financementRepository): Response
    {
        $form = $this->createForm(FinancementType::class, $financement);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $financementRepository->save($financement, true);

            return $this->redirectToRoute('app_financement_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('financement/edit.html.twig', [
            'financement' => $financement,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_financement_delete', methods: ['POST'])]
    public function delete(Request $request, Financement $financement, FinancementRepository $financementRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$financement->getId(), $request->request->get('_token'))) {
            $financementRepository->remove($financement, true);
        }

        return $this->redirectToRoute('app_financement_index', [], Response::HTTP_SEE_OTHER);
    }
}
