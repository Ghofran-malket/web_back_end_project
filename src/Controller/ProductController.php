<?php

namespace App\Controller;

use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\product;

#[Route('/product', name: 'gephora_product_')]
class ProductController extends AbstractController
{
    public function __construct(private ProductRepository $repository)
    {
    }

    #[Route('/', name: 'show', methods:'GET')]
    public function show(): Response
    {
        $product = $this->repository->findAll();
        if($product == null){
            return $this->json(
                ['message' => "No Content found"],
                Response::HTTP_NO_CONTENT
            );
        }
        foreach ($product as $x) {
            echo "A Product was, found : {$x->getTitle()} for {$x->getId()} id";
        }
        return $this->json(['message' => "the number of products, found :" . count($product)]);
    }

}
