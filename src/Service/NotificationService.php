<?php

namespace App\Service;

use App\Entity\User;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Address;
use Twilio\Exceptions\ConfigurationException;
use Twilio\Exceptions\TwilioException;
use Twilio\Rest\Client;

class NotificationService
{
    /**
     * @throws TransportExceptionInterface
     */
    public static function notify(MailerInterface $mailer, User $user, $subject, $template, $context): void
    {
        $email = (new TemplatedEmail())
            ->from(new Address('admin@admin.com', 'Admin'))
            ->to(new Address($user->getEmail(), $user->getPrenom()))
            ->subject($subject)
            ->htmlTemplate($template)
            ->context($context);

        $mailer->send($email);
    }

    /**
     * @throws ConfigurationException
     * @throws TwilioException
     */
    public static function sendSMS(string $phone, string $texto)
    {
        // Send an SMS using Twilio's REST API and PHP
        $sid = "AC1fa1c725eeb0298813b52baa8540fc1e"; // Your Account SID from www.twilio.com/console
        $token = "e88311d6b30a79d1507f3c52ec1bebff"; // Your Auth Token from www.twilio.com/console
        $client = new Client($sid, $token);
        $message = $client->messages->create(
            $phone, // Text this number
            [
                'from' => "+12542847074", // From a valid Twilio number
                'body' => $texto
            ]
        );

        print $message->sid;
    }
}