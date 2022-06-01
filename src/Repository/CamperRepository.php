<?php

namespace App\Repository;

use App\Entity\Camper;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Camper>
 *
 * @method Camper|null find($id, $lockMode = null, $lockVersion = null)
 * @method Camper|null findOneBy(array $criteria, array $orderBy = null)
 * @method Camper[]    findAll()
 * @method Camper[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CamperRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Camper::class);
    }

    public function add(Camper $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Camper $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

}
