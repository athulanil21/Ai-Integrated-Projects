<?php

namespace Tests\Unit;

use App\Models\PatientModel;
use CodeIgniter\Test\CIUnitTestCase;
use CodeIgniter\Test\DatabaseTestTrait;

class PatientModelTest extends CIUnitTestCase
{
    use DatabaseTestTrait;

    protected $migrate = true;
    protected $refresh = true;
    protected $seed = 'TestSeeder';
    protected $basePath = 'tests/_support/Database';
    
    protected $patientModel;

    protected function setUp(): void
    {
        parent::setUp();
        $this->patientModel = new PatientModel();
    }

    public function testGeneratePatientId()
    {
        $patientId = $this->patientModel->generatePatientId();
        
        $this->assertStringStartsWith('P' . date('Y'), $patientId);
        $this->assertEquals(9, strlen($patientId)); // P + YYYY + 0001
    }

    public function testCreatePatient()
    {
        $patientData = [
            'mr_id' => 'MR001',
            'first_name' => 'John',
            'last_name' => 'Doe',
            'date_of_birth' => '1990-01-01',
            'gender' => 'male',
            'phone' => '1234567890',
            'email' => 'john@example.com'
        ];

        $result = $this->patientModel->createPatient($patientData);
        
        $this->assertTrue($result);
        
        $patient = $this->patientModel->where('mr_id', 'MR001')->first();
        $this->assertNotNull($patient);
        $this->assertEquals('John', $patient['first_name']);
    }

    public function testValidationRules()
    {
        $patientData = [
            'first_name' => 'A', // Too short
            'phone' => '123' // Too short
        ];

        $result = $this->patientModel->insert($patientData);
        
        $this->assertFalse($result);
        $this->assertNotEmpty($this->patientModel->errors());
    }

    public function testGetPatientWithAppointments()
    {
        // Create test patient
        $patientId = $this->patientModel->createPatient([
            'mr_id' => 'MR002',
            'first_name' => 'Jane',
            'last_name' => 'Smith',
            'date_of_birth' => '1985-05-15',
            'gender' => 'female',
            'phone' => '9876543210'
        ]);

        $patient = $this->patientModel->getPatientWithAppointments($patientId);
        
        $this->assertNotNull($patient);
        $this->assertEquals('Jane', $patient['first_name']);
        $this->assertArrayHasKey('total_appointments', $patient);
    }
}
