<?php

namespace App\Service;

use App\Entity\Delivery;
use Doctrine\ORM\EntityManagerInterface;

class PriceService extends BaseService
{

    public function __construct(EntityManagerInterface $em)
    {
        parent::__construct($em);
    }

    /**
     * @param \DateTime $date
     * @param \DateTime $startDay
     * @return array
     */
    public function getInfo(\DateTime $date, \DateTime $startDay): array
    {
        $date->setTime(0,0);
        $startDay->setTime(0,0);
        $days = (int)(date_diff($date, $startDay)->days);
        $fibo = $this->getFibo($days - 1);
        $deliveries = [];
        $remains = 0;
        for ($i = 0; $i < $days; $i++) {
            $deliveriesByDate = $this->em->getRepository(Delivery::class)->findByDate($startDay);
            $startDay->add(new \DateInterval('P1D'));

            foreach ($deliveriesByDate as $deliveryByDate) {
                $deliveries[] = $deliveryByDate;
            }

            /** @var Delivery $delivery */
            foreach ($deliveries as $delivery) {
                $balance = $delivery->getBalance();
                $remains = $balance - $fibo[$i] - abs($remains);
                if ($remains > 0) {
                    $delivery->setBalance($remains);
                    $remains = 0;
                    break;
                }
                unset($delivery);
            }
        }

        return $this->getPrice($deliveries);
    }

    private function getPrice(array $deliveries): array
    {
        $count = 0;
        $sumPrice = 0;
        /** @var Delivery $delivery */
        foreach ($deliveries as $delivery) {
            $count += $delivery->getBalance();
            $sumPrice = $sumPrice + ($delivery->getBalance() * $delivery->getCost());
        }

        return [
            'balance' => $count,
            'price' => ($sumPrice == 0 || $count == 0) ? 0 : $sumPrice / $count,
        ];
    }

    /**
     * First Fibonachi's number index is 0
     * @param int $index
     * @return array|int[]
     */
    public function getFibo(int $index): array
    {
        $one = 0;
        $two = 1;
        $fibo = [$one, $two];

        if ($index < 0) {
            return [];
        } elseif ($index === 0) {
            return [$one];
        } elseif ($index === 1) {
            return [$one, $two];
        }

        $index = $index - 2;
        for ($i = 0; $i <= $index; $i++) {
            $current = $one + $two;
            $one = $two;
            $two = $current;
            $fibo[] = $current;
        }

        return $fibo;
    }
}