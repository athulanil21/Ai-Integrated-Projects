<?php
namespace App\Models;

use CodeIgniter\Model;

class WhatsAppMessageModel extends Model
{
    protected $table = 'whatsapp_messages';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'patient_id', 'message_type', 'message_content', 
        'whatsapp_status', 'sent_date', 'delivered_date'
    ];
    protected $useTimestamps = true;
    
    public function sendReportNotification($patientId, $reportDetails)
    {
        $patient = model('PatientModel')->find($patientId);
        
        if (!$patient || !$patient['whatsapp_opted']) {
            return false;
        }
        
        $message = "Hello {$patient['first_name']},\n\n";
        $message .= "Your medical report is ready. Please visit our clinic to collect it.\n\n";
        $message .= "Report Details:\n";
        $message .= "Date: " . date('d-m-Y') . "\n";
        $message .= "Patient ID: {$patient['patient_id']}\n\n";
        $message .= "Thank you for choosing our services.";
        
        $whatsapp = new \App\Libraries\WhatsAppLibrary();
        $result = $whatsapp->sendMessage($patient['phone'], $message);
        
        // Log the message
        $logData = [
            'patient_id' => $patientId,
            'message_type' => 'report',
            'message_content' => $message,
            'whatsapp_status' => $result['success'] ? 'sent' : 'failed',
            'sent_date' => date('Y-m-d')
        ];
        
        return $this->insert($logData);
    }
    
    public function getWhatsAppOptedPatients()
    {
        return $this->db->table('patients')
            ->select('patient_id, first_name, last_name, phone')
            ->where('whatsapp_opted', 1)
            ->get()
            ->getResultArray();
    }
}
