<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\CommandRepository;

class ListeCommandesController extends AbstractController
{
    /**
     * @Route("/liste_commandes", name="liste_commandes")
     */
    public function index(CommandRepository $command): Response
    {

        $commandes=$command->findAll();

        return $this->render('liste_commandes/index.html.twig', [
            'controller_name' => 'ListeCommandesController',
            'commandes'=>$commandes
        ]);
    }

    /**
     * @Route("/commande/{id}", name="commande.show")
     */
    public function afficheCommande($id, CommandRepository $command): Response
    {

        $commande = $command->find($id);
        $products=$commande->getProducts()->toArray();
        
        $total=0;

        foreach($products as $product){
            $total+=$product->getPrice();
        }

        return $this->render('liste_commandes/show.html.twig', [
            'controller_name' => 'ListeCommandesController',
            'total'=>$total,
            'products'=>$products
        ]);
    }
}
