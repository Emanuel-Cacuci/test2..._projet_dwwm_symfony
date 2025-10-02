<?php

namespace App\Repository;

use App\Entity\Produit;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
// use Symfony\Component\ExpressionLanguage\ExpressionFunctionProviderInterface;

/**
 * @extends ServiceEntityRepository<Produit>
 */
class ProduitRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Produit::class);
    }

    public function findTotalStock()
    {
        return $this->createQueryBuilder('p')
        ->select('SUM(p.stock) as total')
        ->getQuery()
        ->getResult();   
    }


    /**
     * @param int $stock
     * @return Produit[]
     */
    public function findByStock(int $stock): array
    {
        return $this->createQuerybuilder('p')
            ->where('p.stock < :stock')
            ->setParameter('stock', $stock)
            ->orderBy('p.stock', 'ASC')
            ->setMaxResults(5)
            ->getQuery()
            ->getResult()

        ;
    }

    //    /**
    //     * @return Produit[] Returns an array of Produit objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('p')
    //            ->andWhere('p.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('p.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ; 
    //    }

    //    public function findOneBySomeField($value): ?Produit
    //    {
    //        return $this->createQueryBuilder('p')
    //            ->andWhere('p.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
