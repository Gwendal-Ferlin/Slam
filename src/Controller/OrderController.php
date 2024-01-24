<?php

declare(strict_types=1);

namespace MyApp\Controller;

use MyApp\Service\DependencyContainer;
use Twig\Environment;

class OrderController
{
    private $twig;

    public function __construct(Environment $twig, DependencyContainer $dependencyContainer)
    {
        $this->twig = $twig;
    }
    public function orders()
{
    echo $this->twig->render('defaultController/order.html.twig', []);
}
}