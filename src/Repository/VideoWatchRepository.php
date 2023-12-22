<?php

namespace App\Repository;

use App\Entity\VideoWatch;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<VideoWatch>
 *
 * @method VideoWatch|null find($id, $lockMode = null, $lockVersion = null)
 * @method VideoWatch|null findOneBy(array $criteria, array $orderBy = null)
 * @method VideoWatch[]    findAll()
 * @method VideoWatch[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class VideoWatchRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, VideoWatch::class);
    }

//    /**
//     * @return VideoWatch[] Returns an array of VideoWatch objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('v')
//            ->andWhere('v.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('v.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?VideoWatch
//    {
//        return $this->createQueryBuilder('v')
//            ->andWhere('v.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
