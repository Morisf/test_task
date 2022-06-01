<?php

namespace App\Repository;

use App\Entity\LocationEquipment;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<LocationEquipment>
 *
 * @method LocationEquipment|null find($id, $lockMode = null, $lockVersion = null)
 * @method LocationEquipment|null findOneBy(array $criteria, array $orderBy = null)
 * @method LocationEquipment[]    findAll()
 * @method LocationEquipment[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class LocationEquipmentRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, LocationEquipment::class);
    }

    public function add(LocationEquipment $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(LocationEquipment $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }
}
