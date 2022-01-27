<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\ProductRepository;
use App\Entity\Product;

class ProductController extends AbstractController
{
    /**
     * @Route("/product", name="product")
     */
    public function index(ProductRepository $productsrep): Response
    {
        $products= $productsrep->findall();
        return $this->render('product/index.html.twig', [
            'products' => $products,
        ]);
    }
    /**
     * @Route("/product/{id}", name="product.show")
     */
    public function show($id): Response{

        $productRepository = $this->getDoctrine()->getRepository(Product::class);
        
        $product = $productRepository->find($id);

        if (!$product)
            {
                throw $this->createNotFoundException('The product does not exist');
            }


        return $this->render('product/show.html.twig', [
            'controller_name' => 'ProductController',
            'product'=> $product,
        ]);
    }
}
