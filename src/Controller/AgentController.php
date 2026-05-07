<?php

namespace App\Controller;

use App\Entity\Agent;
use App\Form\QuittanceType;
use App\Repository\AgentRepository;
use App\Repository\CarnetQuittanceRepository;
use App\Service\QuittanceService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class AgentController extends AbstractController
{
    #[Route('SGRM/agent', name: 'app_agent')]
    public function index(AgentRepository $agentRepository): Response
    {
        $agents = $agentRepository->findAll();
        return $this->render('agent/index.html.twig', [
            'controller_name' => 'AgentController',
            'agents' => $agents
        ]);
    }

   #[Route('SGRM/agent/quittance/new/{id}', name: 'app_quittance_new')]
    public function new(
    Agent $agent,
    Request $request,
    QuittanceService $service,
    CarnetQuittanceRepository $carnetRepo
    ): Response {

        $carnet = $carnetRepo->findOneBy([
            'agent' => $agent,
            'statut' => 'En cours'
        ]);

        if (!$carnet) {
            throw $this->createNotFoundException("Aucun carnet en cours");
        }

        $form = $this->createForm(QuittanceType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $quittances = $form->get('quittances')->getData();

            $service->creerQuittances($agent, $quittances);

            return $this->redirectToRoute('app_agent');
        }

        return $this->render('agent/quittance/new.html.twig', [
            'form' => $form->createView(),
            'agent' => $agent,
            'carnet' => $carnet
        ]);
    }
}
