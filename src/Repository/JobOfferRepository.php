<?php

namespace App\Repository;

use App\Entity\JobOffer;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Collections\Criteria;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method JobOffer|null find($id, $lockMode = null, $lockVersion = null)
 * @method JobOffer|null findOneBy(array $criteria, array $orderBy = null)
 * @method JobOffer[]    findAll()
 * @method JobOffer[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class JobOfferRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, JobOffer::class);
    }

    public static function createNonDeletedCriteria() : Criteria
    {
        return Criteria::create()
            ->andWhere(Criteria::expr()->eq('isDeleted', false))
            ->orderBy(['createdAt' => 'DESC']);
    }

    /**
     * 
     *
     * @param string|null $term
     * @return JobOffer[]
     */
    public function findAllWithSearch(?string $term)
    {
        $qb = $this->createQueryBuilder('j');

        if($term){
            $qb->andWhere('j.title LIKE :term OR j.author LIKE :term')
                ->setParameter('term', '%'.$term. '%')
                ;
        }

        return $qb
            ->leftJoin('j.tags', 't')
            ->addSelect('t')
            ->orderBy('j.createdAt', 'DESC')
            ->getQuery()
            ->getResult();
    }
    // /**
    //  * @return JobOffer[] Returns an array of JobOffer objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('j')
            ->andWhere('j.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('j.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?JobOffer
    {
        return $this->createQueryBuilder('j')
            ->andWhere('j.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
