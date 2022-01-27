<?php

namespace App\Repository;

use App\Entity\Product;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Product|null find($id, $lockMode = null, $lockVersion = null)
 * @method Product|null findOneBy(array $criteria, array $orderBy = null)
 * @method Product[]    findAll()
 * @method Product[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProductRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Product::class);
    }


    public function findMostCheapest($values)
    {
        return $this->createQueryBuilder('p')
            ->orderBy('p.price', 'ASC')
            ->setMaxResults($values)
            ->getQuery()
            ->getResult()
        ;
    }

   
    public function findMostRecent($values)
    {
        return $this->createQueryBuilder('p')
        ->orderBy('p.createdAt', 'DESC')
        ->setMaxResults($values)
        ->getQuery()
        ->getResult()
        ;
    }
  
}
