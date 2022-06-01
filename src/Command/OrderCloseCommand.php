<?php

namespace App\Command;

use App\Entity\Order;
use App\Service\OrderService;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'app:order-close',
    description: 'Add a short description for your command',
)]
class OrderCloseCommand extends Command
{
    private OrderService $orderService;

    public function __construct(OrderService $orderService, string $name = null)
    {
        parent::__construct($name);
        $this->orderService = $orderService;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $this->orderService->finishOpenOrders();
        $io->success(sprintf(
            "All orders with status %s for today was closed",
            Order::STATUS_IN_PROGRESS
        ));

        return Command::SUCCESS;
    }
}
