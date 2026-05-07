<?php

namespace App\Controller;

use App\Repository\LigneVersementAgentVersRegisseurRepository;
use App\Repository\LigneVersementRegisseurVersTresorRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class EtatPeriodiqueController extends AbstractController
{
    #[Route('/etat/periodique', name: 'app_etat_periodique')]
    public function etatAgent(
        Request $request,
        LigneVersementAgentVersRegisseurRepository $repo
    ): Response {

        $month = $request->query->get('month');
        $year = $request->query->get('year');

        // 📅 période
        if ($month && $year) {
            $start = new \DateTime("$year-$month-01");
            $end = (clone $start)->modify('+1 month');
        } elseif ($year) {
            $start = new \DateTime("$year-01-01");
            $end = new \DateTime(($year + 1) . "-01-01");
        } else {
            $start = new \DateTime('first day of this month');
            $end = new \DateTime('first day of next month');
        }

        // 📊 données
        $data = $repo->getEtatAgents($start, $end);
        // 📈 chart
        $labels = array_column($data, 'agent');
        $values = array_map(fn($d) => (float)$d['total'], $data);
         return $this->render('etat_periodique/etat_agent.html.twig', [
            'controller_name' => 'EtatPeriodiqueController',
            'data' => $data,
            'labels' => $labels,
            'values' => $values,
        ]);
    }

    #[Route('/etat/regisseurs', name: 'app_etat_regisseurs')]
    public function etatRegisseurs(
        Request $request,
        LigneVersementRegisseurVersTresorRepository $repo
    ): Response {

        $month = $request->query->get('month');
        $year = $request->query->get('year');

        // 📅 période
        if ($month && $year) {
            $start = new \DateTime("$year-$month-01");
            $end = (clone $start)->modify('+1 month');
        } elseif ($year) {
            $start = new \DateTime("$year-01-01");
            $end = new \DateTime(($year + 1) . "-01-01");
        } else {
            $start = new \DateTime('first day of this month');
            $end = new \DateTime('first day of next month');
        }

        // 📊 données
        $data = $repo->getEtatRegisseurs($start, $end);

        // 📈 chart
        $labels = array_column($data, 'regisseur');
        $values = array_map(fn($d) => (float)$d['total'], $data);

        return $this->render('etat_periodique/etat_regisseur.html.twig', [
            'data' => $data,
            'labels' => $labels,
            'values' => $values,
        ]);
    }
}
