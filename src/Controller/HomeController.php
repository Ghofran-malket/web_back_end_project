<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    public function __construct(private ProductController $productController) {
    }

    #[Route('/home', name: 'gephora_home')]
    public function index(): Response
    {
        $products_notre_selection = $this->productController->showByCategory('Notre Selection');
        $products_tendane = $this->productController->showByCategory('Tendance');
        $products_offre = $this->productController->showByCategory('Offre');
        return $this->render('home/index.html.twig', [
            'products_notre_selection' => $products_notre_selection,
            'products_tendane' => $products_tendane,
            'products_offre' => $products_offre
        ]);
    }
}
