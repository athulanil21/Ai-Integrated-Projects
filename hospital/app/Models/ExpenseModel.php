<?php
namespace App\Models;

use CodeIgniter\Model;

class ExpenseModel extends Model
{
    protected $table = 'daily_expenses';
    protected $primaryKey = 'expense_id';
    protected $allowedFields = [
        'category', 'item_name', 'amount', 'expense_date',
        'description', 'receipt_path', 'created_by'
    ];
    protected $useTimestamps = true;
    
    public function addExpense($expenseData)
    {
        $expenseData['created_by'] = session()->get('user_id');
        return $this->insert($expenseData);
    }
    
    public function getDailyExpenses($date)
    {
        return $this->where('expense_date', $date)
            ->orderBy('created_at', 'DESC')
            ->findAll();
    }
    
    public function getExpensesByCategory($startDate, $endDate)
    {
        return $this->db->table('daily_expenses')
            ->select('category, SUM(amount) as total_amount')
            ->where('expense_date >=', $startDate)
            ->where('expense_date <=', $endDate)
            ->groupBy('category')
            ->get()
            ->getResultArray();
    }
}
