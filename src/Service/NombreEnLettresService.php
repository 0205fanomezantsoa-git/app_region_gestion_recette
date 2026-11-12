<?php

namespace App\Service;

class NombreEnLettresService
{
    public function convertir(float $montant): string
    {
        $formatter = new \NumberFormatter('fr', \NumberFormatter::SPELLOUT);

        $entier = floor($montant);
        $decimal = round(($montant - $entier) * 100);

        $resultat = ucfirst($formatter->format($entier));

        if ($decimal > 0) {
            $resultat .= ' et ' . $formatter->format($decimal);
        }

        return $resultat;
    }
}