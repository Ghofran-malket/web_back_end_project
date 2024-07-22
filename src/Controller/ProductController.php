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
    public function show()
    {
        $products = $this->repository->findBy(
            array(),
            array('id' => 'ASC'),
            4,
            0
        );
        if($products == null){
            return null;
        }
        return $products;
    }

    #[Route('/', name: 'show_by_category', methods:'GET')]
    public function showByCategory(String $category)
    {
        $products = $this->repository->findByCategoryTitle($category);
        if($products == null){
            return null;
        }
        return $products;
    }

    #[Route('/{id}', name:'edit', methods:'PUT')]
    public function edit(int $id): Response{
        $product = $this->repository->findOneBy(['id'=>$id]);
        if(!$product){
            throw $this->createNotFoundException("No Product found for {$id} id");
        }
        $product->setTitle('Product 1');
        $this->manager->flush();

        return $this->redirectToRoute('product_show');
    }

    #[Route('/{id}', name:'delete', methods:'DELETE')]
    public function delete(int $id): Response{
        $product = $this->repository->findOneBy(['id'=>$id]);
        if(!$product){
            throw $this->createNotFoundException("No Product found for {$id} id");
        }
        $this->manager->remove($product);
        $this->manager->flush();

        return $this->json(['message' => "Product resource deleted"], Response::HTTP_NO_CONTENT);
    }
}
