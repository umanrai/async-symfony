<?php

namespace App\MessageHandler;

use App\Message\PurchaseConfirmationNotification;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;


#[AsMessageHandler]
class PurchaseConfirmationNotificationHandler
{
    public function __invoke(PurchaseConfirmationNotification $notification): Void
    {
        // 1. Create a PDF contract note
        echo 'Creating a PDF contract note...<br>';

        // 2. Email the contract note to buyer
        echo 'Emailing the contract note...' . $notification->getOrder()->getBuyer()->getEmail() . '<br>';
    }
}