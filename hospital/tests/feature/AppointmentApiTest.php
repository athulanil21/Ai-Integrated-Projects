<?php

namespace Tests\Feature;

use CodeIgniter\Test\CIUnitTestCase;
use CodeIgniter\Test\DatabaseTestTrait;
use CodeIgniter\Test\FeatureTestTrait;

class AppointmentApiTest extends CIUnitTestCase
{
    use DatabaseTestTrait, FeatureTestTrait;

    protected $migrate = true;
    protected $refresh = true;
    protected $seed = 'TestSeeder';

    protected function setUp(): void
    {
        parent::setUp();
        // Login as admin for API tests
        $this->loginAsAdmin();
    }

    private function loginAsAdmin()
    {
        session()->set([
            'user_id' => 1,
            'email' => 'admin@test.com',
            'role_id' => 1,
            'is_logged_in' => true
        ]);
    }

    public function testCheckAppointmentAvailability()
    {
        $response = $this->get('api/appointments/availability', [
            'doctor_id' => 1,
            'date' => '2024-01-15',
            'time' => '10:00'
        ]);

        $response->assertOK();
        $response->assertJSONFragment(['available' => true]);
    }

    public function testPatientSearch()
    {
        $response = $this->get('api/patients/search', [
            'query' => 'John'
        ]);

        $response->assertOK();
        $data = $response->getJSON();
        $this->assertIsArray($data);
    }

    public function testCreateAppointmentViaAPI()
    {
        $appointmentData = [
            'patient_id' => 'P20240001',
            'doctor_id' => 1,
            'appointment_date' => '2024-01-20',
            'appointment_time' => '14:00',
            'study_type' => 'X-Ray',
            'patient_type' => 'OP',
            'charges' => 500.00
        ];

        $response = $this->post('appointments/create', $appointmentData);
        
        $response->assertRedirect();
        
        // Verify appointment was created
        $appointmentModel = model('AppointmentModel');
        $appointment = $appointmentModel->where('patient_id', 'P20240001')->first();
        $this->assertNotNull($appointment);
    }
}
