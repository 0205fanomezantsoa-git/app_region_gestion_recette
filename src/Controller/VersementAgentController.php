<?php

namespace App\Controller;

use App\Entity\LigneVersementAgentVersRegisseur;
use App\Form\VersementAgentType;
use App\Repository\LigneVersementAgentVersRegisseurRepository;
use Doctrine\ORM\EntityManagerInterface;
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
    public function new(Request $request, EntityManagerInterface $em): Response
    {
        
        $versementAgent = new LigneVersementAgentVersRegisseur;
        $form = $this->createForm(VersementAgentType::class, $versementAgent);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // 💰 Récupération des données
            $agent = $versementAgent->getAgent();
            $regisseur = $versementAgent->getRegisseur();
            $montant = $versementAgent->getMontant();

            // 🔻 Déduction sur agent
            $agent->setPortefeuille(
                $agent->getPortefeuille() - $montant
            );

            // 🔺 Ajout sur régisseur
            $regisseur->setPortefeuille(
                $regisseur->getPortefeuille() + $montant
            );
            $em->persist($versementAgent);
            $em->flush();

            $this->addFlash('success', 'Versement enregistré avec succès');

            return $this->redirectToRoute('app_versement_detail', [
                'id' => $versementAgent->getId()
            ]);
        }
        return $this->render('versement_agent/new.html.twig', [
            'controller_name' => 'VersementAgentController',
            'form' => $form
        ]);
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
}
