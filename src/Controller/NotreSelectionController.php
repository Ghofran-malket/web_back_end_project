<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class NotreSelectionController extends AbstractController
{
    public function __construct(private ProductController $productController) {
    }

    
    #[Route('/notre_selection', name: 'gephora_notre_selection')]
    public function index(): Response
    {
        $products_notre_selection = $this->productController->showByCategory('Notre Selection');
        return $this->render('pages/notre_selection.html.twig', [
            'products_notre_selection' => $products_notre_selection,
        ]);
    }
}
