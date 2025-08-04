<?php
namespace App\Models;
use CodeIgniter\Model;

class InventoryModel extends Model
{
    protected $table = 'inventory_items';
    protected $primaryKey = 'item_id';
    protected $allowedFields = [
        'item_name', 'category_id', 'sku', 'unit_price', 'minimum_stock',
        'current_stock', 'unit_of_measure', 'expiry_date', 'supplier_info', 'status'
    ];
    protected $useTimestamps = true;
    
    public function getItemsWithCategories()
    {
        return $this->db->table('inventory_items i')
            ->select('i.*, c.category_name')
            ->join('inventory_categories c', 'i.category_id = c.category_id')
            ->where('i.status', 'active')
            ->get()
            ->getResultArray();
    }
    
    public function getLowStockItems()
    {
        return $this->where('current_stock <=', 'minimum_stock', false)
            ->where('status', 'active')
            ->findAll();
    }
    
    public function updateStock($itemId, $quantity, $transactionType, $referenceType = null, $referenceId = null)
    {
        $item = $this->find($itemId);
        if (!$item) return false;
        
        // Calculate new stock level
        $newStock = $transactionType === 'in' 
            ? $item['current_stock'] + $quantity 
            : $item['current_stock'] - $quantity;
            
        if ($newStock < 0) {
            return false; // Insufficient stock
        }
        
        // Update stock
        $this->update($itemId, ['current_stock' => $newStock]);
        
        // Log transaction
        $transactionModel = new InventoryTransactionModel();
        $transactionModel->insert([
            'item_id' => $itemId,
            'transaction_type' => $transactionType,
            'quantity' => $quantity,
            'unit_price' => $item['unit_price'],
            'total_amount' => $quantity * $item['unit_price'],
            'transaction_date' => date('Y-m-d'),
            'reference_type' => $referenceType,
            'reference_id' => $referenceId,
            'created_by' => session()->get('user_id')
        ]);
        
        return true;
    }
}
