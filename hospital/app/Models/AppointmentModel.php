<?php
namespace App\Models;
use CodeIgniter\Model;

class AppointmentModel extends Model
{
    protected $table = 'appointments';
    protected $primaryKey = 'appointment_id';
    protected $allowedFields = [
        'patient_id', 'doctor_id', 'appointment_date', 'appointment_time',
        'study_type', 'patient_type', 'referring_doctor', 'status', 
        'charges', 'notes', 'value_added_services'
    ];
    protected $useTimestamps = true;
    
    public function getAppointmentsByDate($date)
    {
        return $this->db->table('appointments a')
            ->select('a.*, p.first_name, p.last_name, p.phone, d.specialization')
            ->join('patients p', 'a.patient_id = p.patient_id')
            ->join('doctors d', 'a.doctor_id = d.doctor_id')
            ->where('a.appointment_date', $date)
            ->orderBy('a.appointment_time', 'ASC')
            ->get()
            ->getResultArray();
    }
    
    public function checkAvailability($doctorId, $date, $time)
    {
        $existing = $this->where([
            'doctor_id' => $doctorId,
            'appointment_date' => $date,
            'appointment_time' => $time,
            'status !=' => 'cancelled'
        ])->first();
        
        return !$existing;
    }
    
    public function getUpcomingAppointments($limit = 10)
    {
        return $this->db->table('appointments a')
            ->select('a.*, p.first_name, p.last_name, p.phone')
            ->join('patients p', 'a.patient_id = p.patient_id')
            ->where('a.appointment_date >=', date('Y-m-d'))
            ->where('a.status', 'scheduled')
            ->orderBy('a.appointment_date', 'ASC')
            ->orderBy('a.appointment_time', 'ASC')
            ->limit($limit)
            ->get()
            ->getResultArray();
    }
}
}
