<?php

namespace App\Service;

use App\Entity\Agent;
use App\Entity\Quittance;
use App\Repository\CarnetQuittanceRepository;
use Doctrine\ORM\EntityManagerInterface;

class QuittanceService
{
    public function __construct(
        private CarnetQuittanceRepository $carnetRepo,
        private EntityManagerInterface $em
    ) {}

    public function creerQuittances(Agent $agent, iterable $quittances): void
    {
        $carnet = $this->carnetRepo->findOneBy([
            'agent' => $agent,
            'statut' => 'En cours'
        ]);

        if (!$carnet) {
            throw new \Exception("Aucun carnet en cours");
        }

        $quittances = iterator_to_array($quittances);

        // 🔥 validation stock AVANT
        if ($carnet->getNbQuittanceRestant() < count($quittances)) {
            throw new \Exception("Stock insuffisant");
        }

        $this->em->beginTransaction();

        try {
            $count = 0;
            $totalMontant = 0;

            foreach ($quittances as $quittance) {

                if (!$quittance instanceof Quittance) {
                    continue;
                }

                $montant = (float) $quittance->getMontantTotal();

                if ($montant < 0) {
                    throw new \Exception("Montant invalide");
                }

                $quittance->setCarnetQuittance($carnet);

                $this->em->persist($quittance);

                $totalMontant += $montant;
                $count++;
            }

            // 📉 stock
            $stock = $carnet->getNbQuittanceRestant() - $count;

            $carnet->setNbQuittanceRestant($stock);

            if ($stock === 0) {
                $carnet->setStatut("Epuiser");
            }

            // 💰 portefeuille
            $agent->setPortefeuille(
                $agent->getPortefeuille() + $totalMontant
            );

            $this->em->persist($carnet);
            $this->em->persist($agent);

            $this->em->flush();
            $this->em->commit();

        } catch (\Throwable $e) {
            $this->em->rollback();
            throw $e;
        }
    }
}