<?php
namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\PatientModel;

class PatientController extends BaseController
{
    protected $patientModel;
    
    public function __construct()
    {
        $this->patientModel = new PatientModel();
    }
    
    public function index()
    {
        $data['patients'] = $this->patientModel->findAll();
        return view('admin/patients/index', $data);
    }
    
    public function create()
    {
        if ($this->request->getMethod() === 'POST') {
            $patientData = [
                'mr_id' => $this->request->getPost('mr_id'),
                'first_name' => $this->request->getPost('first_name'),
                'last_name' => $this->request->getPost('last_name'),
                'date_of_birth' => $this->request->getPost('date_of_birth'),
                'gender' => $this->request->getPost('gender'),
                'phone' => $this->request->getPost('phone'),
                'email' => $this->request->getPost('email'),
                'address' => $this->request->getPost('address'),
                'emergency_contact' => $this->request->getPost('emergency_contact'),
                'insurance_info' => $this->request->getPost('insurance_info'),
                'whatsapp_opted' => $this->request->getPost('whatsapp_opted') ? 1 : 0
            ];
            
            if ($this->patientModel->createPatient($patientData)) {
                return redirect()->to('/admin/patients')->with('success', 'Patient added successfully');
            } else {
                return redirect()->back()->with('errors', $this->patientModel->errors());
            }
        }
        
        return view('admin/patients/create');
    }
    
    public function edit($patientId)
    {
        $data['patient'] = $this->patientModel->find($patientId);
        
        if (!$data['patient']) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException();
        }
        
        if ($this->request->getMethod() === 'POST') {
            $updateData = [
                'first_name' => $this->request->getPost('first_name'),
                'last_name' => $this->request->getPost('last_name'),
                'phone' => $this->request->getPost('phone'),
                'email' => $this->request->getPost('email'),
                'address' => $this->request->getPost('address'),
                'whatsapp_opted' => $this->request->getPost('whatsapp_opted') ? 1 : 0
            ];
            
            if ($this->patientModel->update($patientId, $updateData)) {
                return redirect()->to('/admin/patients')->with('success', 'Patient updated successfully');
            }
        }
        
        return view('admin/patients/edit', $data);
    }
}
