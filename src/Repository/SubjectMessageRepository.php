<?php

namespace App\Repository;

use App\Entity\SubjectMessage;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<SubjectMessage>
 *
 * @method SubjectMessage|null find($id, $lockMode = null, $lockVersion = null)
 * @method SubjectMessage|null findOneBy(array $criteria, array $orderBy = null)
 * @method SubjectMessage[]    findAll()
 * @method SubjectMessage[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SubjectMessageRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, SubjectMessage::class);
    }

    public function save(SubjectMessage $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(SubjectMessage $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return SubjectMessage[] Returns an array of SubjectMessage objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('s')
//            ->andWhere('s.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('s.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?SubjectMessage
//    {
//        return $this->createQueryBuilder('s')
//            ->andWhere('s.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
