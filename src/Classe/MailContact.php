<?php
namespace App\Classe;

use Mailjet\Client;
use Mailjet\Resources;

class MailContact
{
    private $api_key = 'fb936770aa318782809ccbcc9b6753a6';
    private $api_key_secret = 'f6bbb3c39fcdde6108b4c8261b8d5735';

    public function send($to_email, $to_name, $subject, $prenom, $nom, $email, $content)
    {

        $mj = new Client($this->api_key, $this->api_key_secret, true,['version' => 'v3.1']);
        $body = [
            'Messages' => [
                [
                    'From' => [
                        'Email' => "avamae.projet@gmail.com",
                        'Name' => "Mailjet Pilot"
                    ],
                    'To' => [
                        [
                            'Email' => $to_email,
                            'Name' => $to_name
                        ]
                    ],
                    'TemplateID' => 3902159,
                    'TemplateLanguage' => true,
                    'Subject' => $subject,
                    'Variables' => [
                        'prenom' => $prenom,
                        'nom' => $nom,
                        'email' => $email,
                        'content' => $content,
                    ]
                ]
            ]
        ];
        $response = $mj->post(Resources::$Email, ['body' => $body]);
        $response->success();
    }
}