<?php

namespace App\Services;

use Twilio\Rest\Client;
use Exception;

class WhatsAppService
{
    protected $twilio;
    protected $from;

    public function __construct()
    {
        $sid = env('TWILIO_SID');
        $token = env('TWILIO_AUTH_TOKEN');
        $from = env('TWILIO_WHATSAPP_FROM');

        // If credentials missing, set twilio to null
        if (!$sid || !$token || !$from) {
            $this->twilio = null;
            $this->from = $from;
            return;
        }

        $this->twilio = new Client($sid, $token);
        $this->from = $from;
    }

    public function send($to, $message)
    {
        if (!$this->twilio) {
            // Log the missing credentials instead of throwing
            \Log::error("Twilio credentials missing. Cannot send WhatsApp message to {$to}");
            return false;
        }

        try {
            $this->twilio->messages->create(
                "whatsapp:$to",
                [
                    'from' => $this->from,
                    'body' => $message,
                ]
            );
        } catch (Exception $e) {
            // Log the error but don’t stop the application
            \Log::error("WhatsApp send failed: " . $e->getMessage());
        }
    }
}