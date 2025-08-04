<?php
namespace App\Models;
use CodeIgniter\Model;

class PatientModel extends Model
{
    protected $table = 'patients';
    protected $primaryKey = 'patient_id';
    protected $allowedFields = [
        'mr_id', 'first_name', 'last_name', 'date_of_birth', 
        'gender', 'phone', 'email', 'address', 'emergency_contact',
        'insurance_info', 'medical_history', 'whatsapp_opted'
    ];
    protected $useTimestamps = true;
    protected $validationRules = [
        'mr_id' => 'required|is_unique[patients.mr_id]',
        'first_name' => 'required|min_length[2]|max_length[100]',
        'last_name' => 'required|min_length[2]|max_length[100]',
        'phone' => 'required|numeric|min_length[10]',
        'date_of_birth' => 'required|valid_date'
    ];
    
    public function generatePatientId()
    {
        $year = date('Y');
        $lastPatient = $this->orderBy('patient_id', 'DESC')->first();
        
        if ($lastPatient) {
            $lastNumber = (int)substr($lastPatient['patient_id'], -4);
            $newNumber = str_pad($lastNumber + 1, 4, '0', STR_PAD_LEFT);
        } else {
            $newNumber = '0001';
        }
        
        return 'P' . $year . $newNumber;
    }
    
    public function createPatient($data)
    {
        $data['patient_id'] = $this->generatePatientId();
        return $this->insert($data);
    }
    
    public function getPatientWithAppointments($patientId)
    {
        return $this->db->table('patients p')
            ->select('p.*, COUNT(a.appointment_id) as total_appointments')
            ->join('appointments a', 'p.patient_id = a.patient_id', 'left')
            ->where('p.patient_id', $patientId)
            ->groupBy('p.patient_id')
            ->get()
            ->getRowArray();
    }
}
}
