<?php
// src/Controller/DashboardController.php
namespace App\Controller;

use App\Repository\AgentRepository;
use App\Repository\RegisseurRepository;
use App\Repository\CarnetQuittanceRepository;
use App\Repository\LigneVersementAgentVersRegisseurRepository;
use App\Repository\LigneVersementRegisseurVersTresorRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends AbstractController
{
    #[Route('/', name: 'app_default')]
    public function index(
        AgentRepository $agentRepo,
        RegisseurRepository $regRepo,
        CarnetQuittanceRepository $carnetRepo,
        LigneVersementAgentVersRegisseurRepository $varRepo,
        LigneVersementRegisseurVersTresorRepository $vrtRepo
    ): Response {

        // 📊 INDICATEURS
        $nbAgents = $agentRepo->count([]);
        $nbRegisseurs = $regRepo->count([]);

        $nbCarnets = $carnetRepo->count(['statut' => 'En cours']);

        $totalAgent = $agentRepo->getTotalPortefeuille();
        $totalRegisseur = $regRepo->getTotalPortefeuille();

        $totalGeneral = $totalAgent + $totalRegisseur;

        // 💸 FLUX
        $totalVAR = $varRepo->getTotalToday();
        $totalVRT = $vrtRepo->getTotalToday();

        // 📈 GRAPHIQUE (7 jours)
        $stats = $varRepo->getStatsLast7Days();

        return $this->render('default/index.html.twig', [
            'nbAgents' => $nbAgents,
            'nbRegisseurs' => $nbRegisseurs,
            'nbCarnets' => $nbCarnets,
            'totalGeneral' => $totalGeneral,
            'totalVAR' => $totalVAR,
            'totalVRT' => $totalVRT,
            'stats' => $stats
        ]);
    }
}