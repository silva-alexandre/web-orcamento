<?php

namespace App\Repository;

use App\Entity\Orcamento;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Orcamento>
 *
 * @method Orcamento|null find($id, $lockMode = null, $lockVersion = null)
 * @method Orcamento|null findOneBy(array $criteria, array $orderBy = null)
 * @method Orcamento[]    findAll()
 * @method Orcamento[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class OrcamentoRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Orcamento::class);
    }

//    /**
//     * @return Orcamento[] Returns an array of Orcamento objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('o')
//            ->andWhere('o.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('o.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Orcamento
//    {
//        return $this->createQueryBuilder('o')
//            ->andWhere('o.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
