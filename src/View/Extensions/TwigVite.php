<?php

namespace Expressionengine\Coilpack\View\Extensions;

use Illuminate\Foundation\Vite;
use Twig\Extension\AbstractExtension;
use Twig\Markup;
use Twig\TwigFunction;

class TwigVite extends AbstractExtension
{
    public function getFunctions(): array
    {
        return [
            new TwigFunction('vite', [$this, 'vite']),
        ];
    }

    public function vite(string $resource): string
    {
        return new Markup((new Vite)->__invoke($resource), 'UTF-8');
    }
}
