<?php

namespace App\MessageHandler;

use App\Message\PurchaseConfirmationNotification;
use Mpdf\Mpdf;
use Mpdf\MpdfException;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;
use Symfony\Component\Mime\Email;


#[AsMessageHandler]
class PurchaseConfirmationNotificationHandler
{

    public function __construct(private MailerInterface $mailer)
    {
    }

    /**
     * @throws MpdfException
     * @throws TransportExceptionInterface
     */
    public function __invoke(PurchaseConfirmationNotification $notification): Void
    {
        // 1. Create a PDF contract note
        $mpdf = new Mpdf();
        $content = "<h1>Content Note For Order {$notification->getOrderId()}</h1>";
        $content .= '<p>Total: <b>Rs1000.15</b></p>';

        $mpdf->WriteHTML($content);
        $contractNotePdf = $mpdf->Output('', 'S');

        // 2. Email the contract note to buyer
        echo 'Emailing contract note to...' . $notification->getOrderId() . '<br>';

        $email = (new Email())
            ->from('umanrai58@gmail.com')
            ->to('sachinkiranti@gmail.com')
            ->subject('Contract note for order' .$notification->getOrderId())
            ->text('Here is your contract note')
            ->attach($contractNotePdf, 'contract-note.pdf')
        ;

        $this->mailer->send($email);

    }
}