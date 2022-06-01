<?php

namespace App\Normolizers;

use App\Entity\Order;
use Symfony\Component\Serializer\Exception\ExceptionInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

class OrderNormalizer implements NormalizerInterface
{
    /**
     * @param Order $order
     * @param string|null $format
     * @param array $context
     * @return array
     * @throws ExceptionInterface
     */
    public function normalize($order, string $format = null, array $context = []): array
    {
        return [
            'id' => $order->getId(),
            'startDate' => $order->getStartDate()->format('Y-m-d'),
            'endDate' => $order->getEndDate()->format('Y-m-d'),
            'startLocation' => $order->getStartLocation()->getCity(),
            'endLocation' => $order->getEndLocation()->getCity(),
            'orderStatus' => $order->getOrderStatus(),
        ];
    }

    public function supportsNormalization($data, string $format = null, array $context = []): bool
    {
        return $data instanceof Order;
    }
}
