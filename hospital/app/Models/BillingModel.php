<?php
namespace App\Models;
use CodeIgniter\Model;

class BillingModel extends Model
{
    protected $table = 'bills';
    protected $primaryKey = 'bill_id';
    protected $allowedFields = [
        'patient_id', 'appointment_id', 'total_amount', 'paid_amount',
        'payment_status', 'bill_date', 'due_date', 'payment_method', 'notes'
    ];
    protected $useTimestamps = true;
    
    public function generateBill($appointmentId)
    {
        $appointment = model('AppointmentModel')
            ->select('appointments.*, patients.first_name, patients.last_name')
            ->join('patients', 'appointments.patient_id = patients.patient_id')
            ->find($appointmentId);
            
        if (!$appointment) {
            return false;
        }
        
        $billData = [
            'patient_id' => $appointment['patient_id'],
            'appointment_id' => $appointmentId,
            'total_amount' => $appointment['charges'],
            'bill_date' => date('Y-m-d'),
            'due_date' => date('Y-m-d', strtotime('+30 days'))
        ];
        
        return $this->insert($billData);
    }
    
    public function getDailyBilling($date)
    {
        return $this->db->table('bills b')
            ->select('b.*, p.first_name, p.last_name, p.phone')
            ->join('patients p', 'b.patient_id = p.patient_id')
            ->where('b.bill_date', $date)
            ->get()
            ->getResultArray();
    }
    
    public function getMonthlyRevenue($month, $year)
    {
        return $this->db->table('bills')
            ->selectSum('paid_amount', 'total_revenue')
            ->where('MONTH(bill_date)', $month)
            ->where('YEAR(bill_date)', $year)
            ->where('payment_status !=', 'pending')
            ->get()
            ->getRowArray();
    }
}
