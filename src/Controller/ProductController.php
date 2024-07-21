<?php

namespace App\Controller;

use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\product;
use DateTimeImmutable;
use Doctrine\ORM\EntityManagerInterface;

#[Route('/product', name: 'gephora_product_')]
class ProductController extends AbstractController
{
    public function __construct(private ProductRepository $repository, private EntityManagerInterface $manager)
    {
    }

    #[Route('/', name:'create', methods:'POST')]
    public function create(): Response{
        $product = new Product();
        $product->setTitle('Product 1');
        $product->setDescription('description');
        $product->setPrice('30');
        $product->setImage('image');

        $product->setCreatedAt(new DateTimeImmutable());
        $this->manager->persist($product);
        $this->manager->flush();

        return $this->json(['message' => "create product"], Response::HTTP_CREATED);
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

    #[Route('/{id}', name:'edit', methods:'PUT')]
    public function edit(): Response{
        return $this->json(['message' => "edit product"]);
    }

    #[Route('/{id}', name:'delete', methods:'DELETE')]
    public function delete(): Response{
        return $this->json(['message' => "delete product"]);
    }
}
