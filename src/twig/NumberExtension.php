<?php

namespace App\Twig;

use App\Service\NombreEnLettresService;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

class NombreExtension extends AbstractExtension
{
    public function __construct(private NombreEnLettresService $service)
    {
    }

    public function getFilters(): array
    {
        return [
            new TwigFilter('lettres', [$this, 'enLettres']),
        ];
    }

    public function enLettres(float $nombre): string
    {
        return $this->service->convertir($nombre);
    }
}