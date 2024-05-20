<?php

namespace App\MessageHandler\Event;


use App\Message\Event\OrderSavedEvent;
use Mpdf\Mpdf;
use Mpdf\MpdfException;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

#[AsMessageHandler]
class OrderSavedEventHandler
{
    public function __construct(private MailerInterface $mailer)
    {
    }


    /**
     * @throws MpdfException
     * @throws TransportExceptionInterface
     */
    public function __invoke(OrderSavedEvent $event): Void
    {
        // 1. Create a PDF contract note
        $mpdf = new Mpdf();
        $content = "<h1>Content Note For Order {$event->getOrderId()}</h1>";
        $content .= '<p>Total: <b>Rs1000.15</b></p>';

        $mpdf->WriteHTML($content);
        $contractNotePdf = $mpdf->Output('', 'S');

        // 2. Email the contract note to buyer
        echo 'Emailing contract note to...' . $event->getOrderId() . '<br>';

        $email = (new Email())
            ->from('umanrai58@gmail.com')
            ->to('sachinkiranti@gmail.com')
            ->subject('Contract note for order' . $event->getOrderId())
            ->text('Here is your contract note')
            ->attach($contractNotePdf, 'contract-note.pdf')
        ;

        $this->mailer->send($email);

    }

}