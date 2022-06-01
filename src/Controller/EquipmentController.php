<?php

namespace App\Controller;

use App\Exceptions\StationNotFoundException;
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

    #[Route(path: '/equipment/forTomorrow/{stationId}', name: 'app_equipment_filter', methods: [Request::METHOD_GET])]
    public function getEquipmentByDay(int $stationId): Response
    {
        $result = $this->equipmentService->getEquipmentForTomorrow($stationId);

        return $this->json($result);
    }
}
