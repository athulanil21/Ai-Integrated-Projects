<?php
namespace App\Controllers;

use App\Models\AppointmentModel;
use App\Models\PatientModel;
use App\Models\DoctorModel;

class AppointmentController extends BaseController
{
    protected $appointmentModel;
    protected $patientModel;
    protected $doctorModel;
    
    public function __construct()
    {
        $this->appointmentModel = new AppointmentModel();
        $this->patientModel = new PatientModel();
        $this->doctorModel = new DoctorModel();
    }
    
    public function create()
    {
        $data['patients'] = $this->patientModel->findAll();
        $data['doctors'] = $this->doctorModel->getActiveDoctors();
        
        if ($this->request->getMethod() === 'POST') {
            $appointmentData = [
                'patient_id' => $this->request->getPost('patient_id'),
                'doctor_id' => $this->request->getPost('doctor_id'),
                'appointment_date' => $this->request->getPost('appointment_date'),
                'appointment_time' => $this->request->getPost('appointment_time'),
                'study_type' => $this->request->getPost('study_type'),
                'patient_type' => $this->request->getPost('patient_type'),
                'referring_doctor' => $this->request->getPost('referring_doctor'),
                'charges' => $this->request->getPost('charges'),
                'value_added_services' => json_encode([
                    'cd' => $this->request->getPost('cd') ? true : false,
                    'contrast' => $this->request->getPost('contrast') ? true : false,
                    'second_opinion' => $this->request->getPost('second_opinion') ? true : false
                ])
            ];
            
            // Check availability
            if (!$this->appointmentModel->checkAvailability(
                $appointmentData['doctor_id'],
                $appointmentData['appointment_date'],
                $appointmentData['appointment_time']
            )) {
                return redirect()->back()->with('error', 'Time slot not available');
            }
            
            if ($this->appointmentModel->insert($appointmentData)) {
                return redirect()->to('/appointments')->with('success', 'Appointment scheduled successfully');
            }
        }
        
        return view('appointments/create', $data);
    }
}
