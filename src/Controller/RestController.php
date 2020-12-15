<?php

namespace App\Controller;

use App\Repository\NumberStoreRepository;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;

class RestController
{
    private NumberStoreRepository $numberStoreRepository;

    public function __construct(NumberStoreRepository $numberStoreRepository)
    {
        $this->numberStoreRepository = $numberStoreRepository;
    }

    /**
     * @Route("/rest/add", name="add_number", methods={"POST"})
     */
    public function add(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        $number = $data['number'] ?? null;

        if ($number === null) {
            throw new NotFoundHttpException('Expecting mandatory parameter "number"!');
        }

        $this->numberStoreRepository->save($number);

        return new JsonResponse(['status' => 'Number persisted!'], Response::HTTP_CREATED);
    }

    /**
     * @Route("/rest/latest/{limit<\d+>?10}", name="latest_numbers", methods={"GET"})
     */
    public function latest(int $limit): JsonResponse
    {
        $numbers = $this->numberStoreRepository->findLatest($limit);

        $data = [
            'limit' => $limit,
            'numbers' => $numbers,
        ];

        return new JsonResponse($data, Response::HTTP_OK);
    }
}
