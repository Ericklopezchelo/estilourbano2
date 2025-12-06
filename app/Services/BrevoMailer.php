<?php

namespace App\Services;

use SendinBlue\Client\Api\TransactionalEmailsApi;
use SendinBlue\Client\Configuration;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;

class BrevoMailer
{
    public static function sendEmail($to, $subject, $htmlContent)
    {
        // 1. OBTENER LA CLAVE API DESDE EL ENTORNO (Mejor práctica)
        // Usamos env('MAIL_PASSWORD') ya que Brevo usa la misma clave para SMTP/API
        $apiKey = env('MAIL_PASSWORD'); 
        
        // 2. OBTENER REMITENTE DESDE EL ENTORNO
        $fromAddress = config('mail.from.address');
        $fromName = config('mail.from.name');

        $config = Configuration::getDefaultConfiguration()->setApiKey('api-key', $apiKey);
        $apiInstance = new TransactionalEmailsApi(new Client(), $config);

        $sendSmtpEmail = new \SendinBlue\Client\Model\SendSmtpEmail([
            'to' => [['email' => $to]],
            
            // 3. USAR EL REMITENTE DEL ENTORNO
            'sender' => ['email' => $fromAddress, 'name' => $fromName], 
            
            'subject' => $subject,
            'htmlContent' => $htmlContent
        ]);

        try {
            $apiInstance->sendTransacEmail($sendSmtpEmail);
        } catch (\Exception $e) {
            // USAR LOG DE LARAVEL EN LUGAR DE 'echo'
            Log::error('Fallo de API Brevo: ' . $e->getMessage()); 
        }
    }
}