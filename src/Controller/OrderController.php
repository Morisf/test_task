<?php

namespace App\Controller;

use App\Exceptions\EquipmentNotFoundException;
use App\Exceptions\NotEnoughEquipmentException;
use App\Exceptions\StationNotFoundException;
use App\Service\OrderService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

#[Route(path: '/api')]
class OrderController extends AbstractController
{

    private OrderService $orderService;

    public function __construct(OrderService $orderService)
    {
        $this->orderService = $orderService;
    }

    /**
     * @throws EquipmentNotFoundException
     * @throws StationNotFoundException
     * @throws NotEnoughEquipmentException
     */
    #[Route('/order', name: 'app_order', methods: Request::METHOD_POST)]
    public function index(Request $request): JsonResponse
    {
        return $this->json(
            $this->orderService->createOrder($request->toArray())
        );
    }
}
