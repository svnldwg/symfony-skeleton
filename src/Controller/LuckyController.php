<?php

namespace App\Controller;

use App\Entity\NumberStore;
use App\Repository\NumberStoreRepository;
use App\Service\NumberGenerator;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class LuckyController extends AbstractController
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @Route("/lucky/{max<\d+>}")
     */
    public function number(int $max, NumberGenerator $numberGenerator): Response
    {
        $number = $numberGenerator->random(0, $max);

        $numberEntity = new NumberStore($number);
        $this->entityManager->persist($numberEntity);
        $this->entityManager->flush();

        return $this->render('lucky/number.html.twig', [
            'number' => $number,
        ]);
    }

    /**
     * @Route("/lucky/history")
     */
    public function numberHistory(NumberStoreRepository $numberStoreRepository): Response
    {
        $numbers = $numberStoreRepository->findAll();

        return $this->render('lucky/history.html.twig', [
            'numbers' => $numbers,
        ]);
    }
}
