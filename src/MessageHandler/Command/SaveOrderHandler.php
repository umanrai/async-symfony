<?php

namespace App\MessageHandler\Command;

use App\Message\Command\SaveOrder;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
class SaveOrderHandler
{
    public function __invoke(SaveOrder $saveOrder):void
    {
        // Save an order to the database
        $orderId = 123;

        echo 'Order being saved' . PHP_EOL;

        // Dispatch an event message on an event bus

    }
}