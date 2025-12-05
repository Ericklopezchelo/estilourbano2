<?php

namespace App\Services;

use SendinBlue\Client\Api\TransactionalEmailsApi;
use SendinBlue\Client\Configuration;
use GuzzleHttp\Client;

class BrevoMailer
{
    public static function sendEmail($to, $subject, $htmlContent)
    {
        $config = Configuration::getDefaultConfiguration()->setApiKey('api-key', 'pgjyVHM8UnL9EWzt');
        $apiInstance = new TransactionalEmailsApi(new Client(), $config);

        $sendSmtpEmail = new \SendinBlue\Client\Model\SendSmtpEmail([
            'to' => [['email' => $to]],
            'sender' => ['email' => 'barberia@estilourbano.com', 'name' => 'Barberia Estilo Urbano'],
            'subject' => $subject,
            'htmlContent' => $htmlContent
        ]);

        try {
            $apiInstance->sendTransacEmail($sendSmtpEmail);
        } catch (\Exception $e) {
            echo 'Exception when sending email: ', $e->getMessage(), PHP_EOL;
        }
    }
}
