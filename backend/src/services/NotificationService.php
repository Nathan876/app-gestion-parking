<?php

namespace App\Services;

use \Pusher\PushNotifications\PushNotifications;

class NotificationService{
    private $beamsClient;
    public function __construct () {
        $this->beamsClient= new PushNotifications(array(
            "instanceId" => $_ENV['PUSHER_NOTIF_INSTANCE_ID'],
            "secretKey" => $_ENV['PUSHER_NOTIF_PRIMARY_KEY'],
        ));
    }

    public function send_notification($send_to, $content)
    {

        $this->beamsClient->publishToInterests(
            ["$send_to"],
            [
                "fcm" => [
                    "notification" => [
                        "title" => "Trouve ta place",
                        "body" => "$content",
                        "icon" => "https://trouvetaplace.local/public/images/logo_carre.png",
                    ]
                ],
                "web" => [
                    "notification" => [
                        "title" => "Trouve ta place",
                        "body" => "$content",
                        "icon" => "https://trouvetaplace.local/public/images/logo_carre.png",
                    ]
                ]
            ]
        );
    }
}