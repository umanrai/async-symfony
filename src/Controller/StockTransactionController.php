<?php

namespace App\Controller;

use App\Message\Command\SaveOrder;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Annotation\Route;

class StockTransactionController extends AbstractController
{
    // buy
    #[Route('/buy', name: 'buy_stock')]
    public function buy(MessageBusInterface $bus): Response
    {

        // $notification->getOrder()->getBuyer()->getEmail()
//         anonymous class
//        $order = new class {
//
//            public function getId()
//            {
//                return 1;
//            }
//            public function getBuyer(): object
//            {
//                return new class {
//                    public function getEmail(): string
//                    {
//                        return 'email@example.tech';
//                    }
//                };
//            }
//        };

        // 1. Dispatch confirmation message
        $bus->dispatch(new SaveOrder());

        // 2. Display confirmation to the user
        return $this->render('stocks/example.html.twig');
    }

    // sell
}
