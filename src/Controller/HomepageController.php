<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\ProductRepository;

class HomepageController extends AbstractController
{
    /**
     * @Route("/homepage", name="homepage")
     */
    public function index(ProductRepository $ProductRepository)
{
    return $this->render('homepage/index.html.twig', [
        'mostCheapestProduct' => $ProductRepository->findMostCheapest(5),
        'mostRecentProduct' => $ProductRepository->findMostRecent(5)
    ]);
}
}
