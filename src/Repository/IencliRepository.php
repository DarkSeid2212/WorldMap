<?php

namespace App\Repository;

use App\Entity\Iencli;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\QueryBuilder;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Iencli|null find($id, $lockMode = null, $lockVersion = null)
 * @method Iencli|null findOneBy(array $criteria, array $orderBy = null)
 * @method Iencli[]    findAll()
 * @method Iencli[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class IencliRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Iencli::class);
    }

    /**
     * @return Iencli[]
     */
    public function findAllVisible(): array
    {
      return  $this->findVisibleQuery()
            ->getQuery()
            ->getResult();
    }

    public function findLatest():array
    {
        return $this->findVisibleQuery()
            ->setMaxResults(4)
            ->getQuery()
            ->getResult();
    }





    private function findVisibleQuery() : QueryBuilder
    {
        return $this->createQueryBuilder('p')
            ->where('p.sold = false');
    }

    // /**
    //  * @return Iencli[] Returns an array of Iencli objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('i')
            ->andWhere('i.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('i.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Iencli
    {
        return $this->createQueryBuilder('i')
            ->andWhere('i.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
