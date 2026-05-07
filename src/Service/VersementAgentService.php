<?php
// src/Service/VersementAgentService.php

namespace App\Service;

use App\Entity\LigneVersementAgentVersRegisseur;
use App\Repository\QuittanceRepository;
use Doctrine\ORM\EntityManagerInterface;

class VersementAgentService
{
    public function __construct(
        private EntityManagerInterface $em,
        private QuittanceRepository $quittanceRepository
    ) {}

    public function effectuerVersement(
        LigneVersementAgentVersRegisseur $versement
    ): void {
         
        $connexion = $this->em->getConnection();
        $connexion->beginTransaction();

        try {

            $agent = $versement->getAgent();
            $regisseur = $versement->getRegisseur();
            // 🔍 récupérer quittances non versées
            $quittances = $this->quittanceRepository->findNonVerseByAgent($agent->getId());
            if (count($quittances) === 0) {
                throw new \Exception("Aucune quittance non versée.");
            }

            // 💰 calcul montant réel
            $montantReel = 0;

            foreach ($quittances as $quittance) {

                $montantReel += $quittance->getMontantTotal();

                // liaison versement
                $quittance->setVersement($versement);

                // changement statut
                $quittance->setStatut('versé');

                // ajout relation inverse
                $versement->addQuittance($quittance);
            }

            // 💰 montant saisi
            $montantSaisi = $versement->getMontant();

            // 📊 calcul écart
            $ecart = $montantSaisi - $montantReel;

            $versement->setEcart($ecart);

            // 🔻 portefeuille agent
            $agent->setPortefeuille(
                $agent->getPortefeuille() - $montantSaisi
            );

            // 🔺 portefeuille régisseur
            $regisseur->setPortefeuille(
                $regisseur->getPortefeuille() + $montantSaisi
            );

            $this->em->persist($versement);

            $this->em->flush();

            $connexion->commit();

        } catch (\Exception $e) {

            $connexion->rollBack();

            throw $e;
        }
    }
}