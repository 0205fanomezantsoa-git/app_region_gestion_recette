<?php

namespace App\Controller;

use App\Entity\LigneVersementRegisseurVersTresor;
use App\Form\LigneVersementRegisseurType;
use App\Repository\LigneVersementRegisseurVersTresorRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Snappy\Pdf;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class VersementRegisseurController extends AbstractController
{
    #[Route('SGRM/versement/regisseur', name: 'app_versement_regisseur')]
    public function index(LigneVersementRegisseurVersTresorRepository $repo): Response
    {
        $data = $repo->findJournalRegisseurTresor();

        return $this->render('versement_regisseur/index.html.twig', [
            'data' => $data
        ]);
    }

     #[Route('SGRM/versement/regisseur/new', name: 'app_versement_regisseur_new')]
    public function new(Request $request, EntityManagerInterface $em): Response
    {
        $versementRegisseur = new LigneVersementRegisseurVersTresor();

        $form = $this->createForm(LigneVersementRegisseurType::class, $versementRegisseur);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $regisseur = $versementRegisseur->getRegisseur();
            $tresor = $versementRegisseur->getTresor();
            $montant = $versementRegisseur->getMontant();

            // 📊 valeur avant opération (audit)
            $ancienSolde = $regisseur->getPortefeuille();

            // 🔻 mise à jour
            $regisseur->setPortefeuille($ancienSolde - $montant);
            $tresor->setPortefeuille($tresor->getPortefeuille() + $montant);

            $ecart = ($ancienSolde - $montant);

            $versementRegisseur->setEcart($ecart);

            $em->persist($versementRegisseur);
            $em->flush();

            $this->addFlash('success', 'Versement enregistré avec succès');

            return $this->redirectToRoute('app_versement_regisseur_detail', [
                'id' => $versementRegisseur->getId()
            ]);
        }

        return $this->render('versement_regisseur/new.html.twig', [
            'form' => $form
        ]);
    }

    #[Route('SGRM/versement/regisseur/{id}', name: 'app_versement_regisseur_detail')]
    public function detail(LigneVersementRegisseurVersTresor $versement): Response
    {
        return $this->render('versement_regisseur/detail.html.twig', [
            'versement' => $versement,
            'regisseur' => $versement->getRegisseur(),
            'tresor' => $versement->getTresor(),
        ]);
    }

    #[Route('/versement/regisseur/{id}/pdf', name: 'app_versement_regisseur_pdf')]
public function pdf(
    LigneVersementRegisseurVersTresor $versement,
    Pdf $snappy
): Response {

    $html = $this->renderView(
        'versement_regisseur/pdf.html.twig',
        [
            'versement' => $versement,
            'regisseur' => $versement->getRegisseur(),
            'tresor' => $versement->getTresor(),
        ]
    );

    $pdf = $snappy->getOutputFromHtml(
        $html,
        [
            'enable-local-file-access' => true,
        ]
    );

    return new Response(
        $pdf,
        200,
        [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="versement.pdf"',
        ]
    );
}
}
