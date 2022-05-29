<?php

namespace App\Repository;

use App\Entity\OrderEquipment;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<OrderEquipment>
 *
 * @method OrderEquipment|null find($id, $lockMode = null, $lockVersion = null)
 * @method OrderEquipment|null findOneBy(array $criteria, array $orderBy = null)
 * @method OrderEquipment[]    findAll()
 * @method OrderEquipment[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class OrderEquipmentRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, OrderEquipment::class);
    }

    public function add(OrderEquipment $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(OrderEquipment $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }
}
