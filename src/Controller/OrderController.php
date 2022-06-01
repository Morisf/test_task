<?php

namespace App\Controller;

use App\Exceptions\EquipmentNotFoundException;
use App\Exceptions\KeyNotFoundException;
use App\Exceptions\NotEnoughEquipmentException;
use App\Exceptions\StationNotFoundException;
use App\Service\OrderService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

#[Route(path: '/api')]
class OrderController extends AbstractController
{
    private OrderService $orderService;

    private NormalizerInterface $serializer;

    public function __construct(OrderService $orderService, NormalizerInterface $serializer)
    {
        $this->orderService = $orderService;
        $this->serializer = $serializer;
    }

    /**
     * @param Request $request
     * @return JsonResponse
     * @throws EquipmentNotFoundException
     * @throws NotEnoughEquipmentException
     * @throws StationNotFoundException
     * @throws KeyNotFoundException
     */
    #[Route('/order', name: 'app_order', methods: Request::METHOD_POST)]
    public function index(Request $request): JsonResponse
    {
        return $this->json(
            $this->orderService->createOrder($request->toArray())
        );
    }
}
