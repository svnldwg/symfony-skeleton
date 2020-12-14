<?php

namespace App\Controller;

use App\Service\NumberGenerator;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class LuckyController extends AbstractController
{
    /**
     * @Route("/lucky/{max}")
     */
    public function number(int $max, NumberGenerator $numberGenerator): Response
    {
        $number = $numberGenerator->random(0, $max);

        return $this->render('lucky/number.html.twig', [
            'number' => $number,
        ]);
    }
}
