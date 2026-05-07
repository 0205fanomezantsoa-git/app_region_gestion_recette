<?php

namespace App\Controller;

use App\Entity\LigneVersementAgentVersRegisseur;
use App\Form\VersementAgentType;
use App\Repository\LigneVersementAgentVersRegisseurRepository;
use App\Service\VersementAgentService;
use Knp\Snappy\Pdf;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class VersementAgentController extends AbstractController
{
    #[Route('SGRM/versement/agent', name: 'app_versement_agent')]
    public function index(LigneVersementAgentVersRegisseurRepository $repository): Response
    {
        $data = $repository->findJournalAgentRegisseur();

        return $this->render('versement_agent/index.html.twig', [
            'data' => $data
        ]);
    }

    #[Route('SGRM/versement/agent/new', name: 'app_versement_agent_new')]
        #[Route('/SGRM/versement/agent/new', name: 'app_versement_agent_new')]
        public function new(
        Request $request,
        VersementAgentService $service
    ): Response {
        $versement = new LigneVersementAgentVersRegisseur();
        $versement->setDate(new \DateTime());
        $form = $this->createForm(
            VersementAgentType::class,
            $versement
        );
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $service->effectuerVersement($versement);
                $this->addFlash(
                    'success',
                    'Versement effectué avec succès'
                );
                return $this->redirectToRoute(
                    'app_versement_agent_detail',
                    [
                        'id' => $versement->getId()
                    ]
                );
            } catch (\Exception $e) {
                $this->addFlash(
                    'danger',
                    $e->getMessage()
                );
            }
        }
        return $this->render(
            'versement_agent/new.html.twig',
            [
                'form' => $form->createView()
            ]
        );
    }

    #[Route('SGRM/versement/agent/{id}', name: 'app_versement_agent_detail')]
    public function detail(LigneVersementAgentVersRegisseur $versement): Response
    {
        return $this->render('versement_agent/detail.html.twig', [
            'versement' => $versement,
            'agent' => $versement->getAgent(),
            'regisseur' => $versement->getRegisseur(),
        ]);
    }

    #[Route('SGRM/versement/agent/{id}/pdf', name: 'app_versement_agent_pdf')]
    public function pdf(LigneVersementAgentVersRegisseur $versement, Pdf $snappy): Response
    {
        $html = $this->renderView('versement_agent/pdf.html.twig', [
            'versement' => $versement,
            'agent' => $versement->getAgent(),
            'regisseur' => $versement->getRegisseur(),
        ]);

        $pdf = $snappy->getOutputFromHtml($html);

        return new Response(
            $pdf,
            200,
            [
                'Content-Type' => 'application/pdf',
                 'Content-Disposition' => 'inline; filename="salaire_'.$versement->getId().'.pdf"',
            ]
        );
    }
}
