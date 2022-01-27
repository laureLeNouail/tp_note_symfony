<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\ProductRepository;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Product;
use App\Entity\Command;
use App\Form\CommandType;

class CartController extends AbstractController
{
    /**
     * @Route("/cart", name="cart")
     */
    public function index(SessionInterface $session, ProductRepository $productRepository): Response
    {
        $cart = $session->get('panier', []);
        $products = [];
        foreach($cart as $id => $quantity)
        {
            $products[] = $productRepository->find($id);
        }

        $command=new Command();
        $commandForm=$this->createForm(CommandType::class, $command);
        
        return $this->render('cart/index.html.twig', [
            'product' => $products,
            'commandForm' => $commandForm->createView()
        ]);
        

        
    }

    /**
     * @Route("/cart/add/{id}", name="cart.add")
     */
    public function add(ProductRepository $productRepository, SessionInterface $session, Request $request)
    {
        $id = $request->attributes->get('id');
        $product=$productRepository->find($id);
        if (!$product){
            return $this->json([
                'message' => 'nok'
            ], 404);
        }
        $cart = $session->get('panier', []);
        $cart[$id] = 1;
        $session->set('panier', $cart);

        return $this->json([
            'message' => "ok"
        ], 200);
    }

    /**
     * @Route("/cart/delete/{id}", name="cart.delete")
     */
    public function delete($id, ProductRepository $productRepository, SessionInterface $session, Request $request)
    {
        $cartProducts = $session->get('panier', []);

        $cart = $session->get('panier', []);
        if(!isset($cart[$id])){
            $this->addFlash('alert-error', "Le produit n'est pas présent dans le panier");
            return $this->redirectToRoute('cart');
        }

        unset($cart[$id]);
        
        $session->set('panier', $cart);
        $this->addFlash('success', "Le produit à été supprimer du panier");
        return $this->redirectToRoute('cart');
    }

    
}
