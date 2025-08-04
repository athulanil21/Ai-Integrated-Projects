<?php
namespace App\Controllers;

use App\Models\PatientModel;
use App\Models\AppointmentModel;
use App\Models\BillingModel;
use App\Models\InventoryModel;

class ReportsController extends BaseController
{
    public function patientReport()
    {
        $startDate = $this->request->getGet('start_date') ?: date('Y-m-01');
        $endDate = $this->request->getGet('end_date') ?: date('Y-m-d');
        $reportType = $this->request->getGet('type') ?: 'daily';
        
        $patientModel = new PatientModel();
        
        switch ($reportType) {
            case 'daily':
                $data['patients'] = $this->getDailyPatientData($startDate, $endDate);
                break;
            case 'monthly':
                $data['patients'] = $this->getMonthlyPatientData($startDate, $endDate);
                break;
        }
        
        $data['start_date'] = $startDate;
        $data['end_date'] = $endDate;
        $data['report_type'] = $reportType;
        
        return view('reports/patient_report', $data);
    }
    
    public function appointmentReport()
    {
        $appointmentModel = new AppointmentModel();
        $date = $this->request->getGet('date') ?: date('Y-m-d');
        
        $data['appointments'] = $appointmentModel->getAppointmentsByDate($date);
        $data['selected_date'] = $date;
        $data['statistics'] = [
            'total' => count($data['appointments']),
            'completed' => count(array_filter($data['appointments'], fn($a) => $a['status'] === 'completed')),
            'cancelled' => count(array_filter($data['appointments'], fn($a) => $a['status'] === 'cancelled')),
            'scheduled' => count(array_filter($data['appointments'], fn($a) => $a['status'] === 'scheduled'))
        ];
        
        return view('reports/appointment_report', $data);
    }
    
    public function billingReport()
    {
        $billingModel = new BillingModel();
        $month = $this->request->getGet('month') ?: date('n');
        $year = $this->request->getGet('year') ?: date('Y');
        
        $data['revenue'] = $billingModel->getMonthlyRevenue($month, $year);
        $data['daily_bills'] = $billingModel->getDailyBilling(date('Y-m-d'));
        $data['selected_month'] = $month;
        $data['selected_year'] = $year;
        
        return view('reports/billing_report', $data);
    }
    
    public function inventoryReport()
    {
        $inventoryModel = new InventoryModel();
        
        $data['low_stock_items'] = $inventoryModel->getLowStockItems();
        $data['all_items'] = $inventoryModel->getItemsWithCategories();
        $data['stock_summary'] = [
            'total_items' => count($data['all_items']),
            'low_stock_count' => count($data['low_stock_items']),
            'out_of_stock_count' => count(array_filter($data['all_items'], fn($i) => $i['current_stock'] == 0))
        ];
        
        return view('reports/inventory_report', $data);
    }
    
    private function getDailyPatientData($startDate, $endDate)
    {
        return model('PatientModel')
            ->db->table('patients p')
            ->select('DATE(p.created_at) as date, COUNT(*) as patient_count')
            ->where('DATE(p.created_at) >=', $startDate)
            ->where('DATE(p.created_at) <=', $endDate)
            ->groupBy('DATE(p.created_at)')
            ->orderBy('date', 'ASC')
            ->get()
            ->getResultArray();
    }
    
    private function getMonthlyPatientData($startDate, $endDate)
    {
        return model('PatientModel')
            ->db->table('patients p')
            ->select('YEAR(p.created_at) as year, MONTH(p.created_at) as month, COUNT(*) as patient_count')
            ->where('DATE(p.created_at) >=', $startDate)
            ->where('DATE(p.created_at) <=', $endDate)
            ->groupBy('YEAR(p.created_at), MONTH(p.created_at)')
            ->orderBy('year, month', 'ASC')
            ->get()
            ->getResultArray();
    }
}
