<?php

namespace App\MessageHandler;

use App\Message\PurchaseConfirmationNotification;
use Mpdf\Mpdf;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;
use Symfony\Component\Mime\Email;


#[AsMessageHandler]
class PurchaseConfirmationNotificationHandler
{

    public function __construct(private MailerInterface $mailer)
    {
    }

    public function __invoke(PurchaseConfirmationNotification $notification): Void
    {
        // 1. Create a PDF contract note
        $mpdf = new Mpdf();
        $content = "<h1>Content Note For Order {$notification->getOrder()->getId()}</h1>";
        $content .= '<p>Total: <b>Rs1000.15</b></p>';

        $mpdf->writeHtml($content);
        $contractNotePdf = $mpdf->output('', 'S');

        // 2. Email the contract note to buyer
//        echo 'Emailing contract note to...' . $notification->getOrder()->getBuyer()->getEmail() . '<br>';

        $email = (new Email())
            ->from('sales@stocksapp.com')
            ->to($notification->getOrder()->getBuyer()->getEmail())
            ->subject('Contract note for order' .$notification->getOrder()->getId())
            ->text('Here is your contract note')
            ->attach($contractNotePdf, 'contract-note.pdf');

        $this->mailer->send($email);

    }
}