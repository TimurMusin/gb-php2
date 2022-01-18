<?php

namespace App\Controller;

use App\Entity\Product;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\RedirectResponse;

class ProductController extends AbstractController
{

    /**
     * @Route("/product", name="product")
     */
    public function index(ManagerRegistry $doctrine): Response
    {
        $manager = $doctrine->getManager();
        $repository = $manager->getRepository(Product::class);
        $products = $repository->findAll();
        return $this->render('product/index.html.twig', [
            'products' => $products,
        ]);
    }

    /**
     * @Route("/product/{id}", name="product_id")
     */
    public function productId(ManagerRegistry $doctrine, $id): Response
    {
        $manager = $doctrine->getManager();
        $repository = $manager->getRepository(Product::class);
        $product = $repository->find($id);
        return $this->render('product/index.html.twig', [
            'product' => $product,
        ]);
    }

    /**
     * @Route("/product/create", name="create_product")
     */
    public function createProduct(ManagerRegistry $doctrine): RedirectResponse
    {
        $manager = $doctrine->getManager();
        $product = new Product();
        $product->setTitle('Title ' . random_int(0, 100));
        $product->setPrice(random_int(0, 1000));
        $product->setDescription('Some description');
        $manager->persist($product);
        $manager->flush();
        return $this->redirectToRoute('product');
    }
}
