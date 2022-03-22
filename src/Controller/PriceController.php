<?php

namespace App\Controller;

use App\Form\PriceType;
use App\Service\PriceService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class PriceController extends AbstractController
{
    private const DATE_START = '2021-01-13';
    public function price(Request $request, PriceService $service): Response
    {
        $stat = [
            'balance' => 0,
            'price' => 0
        ];

        $form = $this->createForm(PriceType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $date = $data['date'];
            if ($date instanceof \DateTime) {
                $startDay = new \DateTime(self::DATE_START);
                if ($date > $startDay) {
                    $stat = $service->getInfo($date, $startDay);
                }
            }
        }

        return $this->render('price.html.twig', [
            'form' => $form->createView(),
            'stat' => $stat,
        ]);
    }
}