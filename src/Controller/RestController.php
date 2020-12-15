<?php

namespace App\Controller;

use App\Repository\NumberStoreRepository;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

class RestController
{
    private NumberStoreRepository $numberStoreRepository;
    private SerializerInterface $serializer;

    public function __construct(
        NumberStoreRepository $numberStoreRepository,
        SerializerInterface $serializer
    ) {
        $this->numberStoreRepository = $numberStoreRepository;
        $this->serializer = $serializer;
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
            'limit'   => $limit,
            'numbers' => $numbers,
        ];

        $jsonData = $this->serializer->serialize($data, 'json');

        return new JsonResponse($jsonData, Response::HTTP_OK, [], true);
    }
}
