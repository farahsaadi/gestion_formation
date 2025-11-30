<?php
namespace App\Classe;

use Mailjet\Client;
use Mailjet\Resources;

class Mail
{
    private $api_key = "7d10c24ae4c58e7d22516016f7d4a82c";
    private $api_key_secret = "f497c6800cb520ada172813a1ad63d28";

    public function send($to_email, $to_name, $subject, $content)
    {
        $mj = new Client(
            $this->api_key, 
            $this->api_key_secret, 
            true, 
            [
                'version' => 'v3.1',
                'curl' => [
                    CURLOPT_SSL_VERIFYHOST => 0,
                    CURLOPT_SSL_VERIFYPEER => 0
                ]
            ]
        );
        
        $body = [
            'Messages' => [
                [
                    'From' => [
                        'Email' => "mfaouzi.hmida@gmail.com",
                        'Name' => "AFCS"
                    ],
                    'To' => [
                        [
                            'Email' => $to_email,
                            'Name' => $to_name
                        ]
                    ],
                    'Subject' => $subject,
                    'HTMLPart' => $content,
                    'TextPart' => strip_tags($content)
                ]
            ]
        ];
        
        try {
            $response = $mj->post(Resources::$Email, ['body' => $body]);
            
            if ($response->success()) {
                return true;
            } else {
                error_log("Erreur Mailjet : " . json_encode($response->getData()));
                return false;
            }
        } catch (\Exception $e) {
            error_log("Exception Mailjet : " . $e->getMessage());
            return false;
        }
    }
}