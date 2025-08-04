<?php
namespace App\Libraries;

class WhatsAppLibrary
{
    private $apiUrl;
    private $token;
    private $instanceId;
    
    public function __construct()
    {
        $this->apiUrl = env('WHATSAPP_API_URL', 'https://api.ultramsg.com');
        $this->token = env('WHATSAPP_TOKEN');
        $this->instanceId = env('WHATSAPP_INSTANCE_ID');
    }
    
    public function sendMessage($phoneNumber, $message, $type = 'text')
    {
        $url = $this->apiUrl . '/' . $this->instanceId . '/messages/chat';
        
        $data = [
            'token' => $this->token,
            'to' => $phoneNumber,
            'body' => $message
        ];
        
        $response = $this->makeRequest($url, $data);
        
        return $this->processResponse($response);
    }
    
    public function sendDocument($phoneNumber, $documentUrl, $caption = '')
    {
        $url = $this->apiUrl . '/' . $this->instanceId . '/messages/document';
        
        $data = [
            'token' => $this->token,
            'to' => $phoneNumber,
            'document' => $documentUrl,
            'caption' => $caption
        ];
        
        return $this->makeRequest($url, $data);
    }
    
    private function makeRequest($url, $data)
    {
        $curl = curl_init();
        
        curl_setopt_array($curl, [
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => http_build_query($data),
            CURLOPT_HTTPHEADER => [
                'Content-Type: application/x-www-form-urlencoded'
            ]
        ]);
        
        $response = curl_exec($curl);
        $httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        curl_close($curl);
        
        return [
            'status_code' => $httpCode,
            'response' => json_decode($response, true)
        ];
    }
    
    private function processResponse($response)
    {
        if ($response['status_code'] === 200 && isset($response['response']['sent'])) {
            return [
                'success' => true,
                'message_id' => $response['response']['id'] ?? null,
                'status' => 'sent'
            ];
        }
        
        return [
            'success' => false,
            'error' => $response['response']['error'] ?? 'Unknown error'
        ];
    }
}
