<?php

namespace App\Repository;

use App\Entity\LocationEquipment;
use App\Entity\Order;
use App\Exceptions\WrongOrderStatusException;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Order>
 *
 * @method Order|null find($id, $lockMode = null, $lockVersion = null)
 * @method Order|null findOneBy(array $criteria, array $orderBy = null)
 * @method Order[]    findAll()
 * @method Order[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class OrderRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Order::class);
    }

    public function add(Order $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Order $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    /**
     * @throws WrongOrderStatusException
     */
    public function finishOpenOrders(): void
    {
        $query = $this->createQueryBuilder('o')
            ->where('o.endDate = :endDate')
            ->setParameter('endDate', (new \DateTime())->format('Y-m-d'));

        $orders = $query->getQuery()->getResult();

        if (empty($orders)) {
            return;
        }

        /** @var $order Order */
        foreach ($orders as $order) {
            foreach ($order->getOrderedEquipment() as $equipment) {
                $orderedItems = $equipment->getOrderedEquipmentQty();
                $locationEquipmentRepo = $this->getEntityManager()->getRepository(LocationEquipment::class);
                $locationEquipment = $locationEquipmentRepo->findOneBy([
                    'location' => $order->getEndLocation(),
                    'equipment' => $equipment
                ]);
                $locationEquipment->setQuantity($locationEquipment->getQuantity() + $orderedItems);
                $this->getEntityManager()->persist($locationEquipment);
            }
            $order->setOrderStatus(Order::STATUS_DONE);
        }
        $this->getEntityManager()->flush();
    }
}
