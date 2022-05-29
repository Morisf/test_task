<?php

namespace App\Controller;

use App\Service\EquipmentService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route(path: '/api')]
class EquipmentController extends AbstractController
{
    private EquipmentService $equipmentService;

    public function __construct(EquipmentService $equipmentService)
    {
        $this->equipmentService = $equipmentService;
    }

    #[Route(path: '/equipment/byDay', name: 'app_equipment_filter', methods: [Request::METHOD_POST])]
    public function getEquipmentByDay(Request $request): Response
    {
        $requestBody = $request->toArray();
        $result = $this->equipmentService->getEquipmentByDay($requestBody['date'], $requestBody['station']);

        return $this->json($result);
    }
}
