<?php

namespace App\Repository;

use App\Entity\Delivery;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class DeliveryRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Delivery::class);
    }

    public function findByDate(\DateTime $date) {
        $date->setTime(0,0);
        $dateEnd = (clone $date)->setTime(23,59,59,59);
        return $this->createQueryBuilder('d')
            ->where('d.date BETWEEN :date AND :dateEnd')
            ->setParameter('date', $date)
            ->setParameter('dateEnd', $dateEnd)
            ->getQuery()
            ->getResult()
        ;
    }
}