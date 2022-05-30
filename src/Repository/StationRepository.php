<?php

namespace App\Repository;

use App\Entity\Station;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Station>
 *
 * @method Station|null find($id, $lockMode = null, $lockVersion = null)
 * @method Station|null findOneBy(array $criteria, array $orderBy = null)
 * @method Station[]    findAll()
 * @method Station[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class StationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Station::class);
    }

    public function add(Station $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Station $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function getAvailableStationEquipment(int $stationId)
    {
        $query = $this->createQueryBuilder('station');

        return $query->select(
            'equipment.id, equipment.title, equipment.price, equipment.oneTimePayment, local_equipment.quantity'
        )
            ->join('station.localEquipment', 'local_equipment')
            ->join('local_equipment.equipment', 'equipment')
            ->where('station.id = :stationId')
            ->setParameter('stationId', $stationId)
            ->getQuery()
            ->getResult();
    }
}
