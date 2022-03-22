<?php

namespace App\Service;

use Doctrine\ORM\EntityManagerInterface;

abstract class BaseService
{
    protected EntityManagerInterface $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    protected function saveObject(object $object)
    {
        $this->em->persist($object);
        $this->em->flush();
    }
}