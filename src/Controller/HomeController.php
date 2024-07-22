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
        $products = $this->productController->show();
        return $this->render('home/index.html.twig', [
            'products' => $products,
        ]);
    }
}
