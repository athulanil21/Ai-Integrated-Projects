<?php
namespace App\Models;

use CodeIgniter\Model;

class InventoryTransactionModel extends Model
{
    protected $table = 'inventory_transactions';
    protected $primaryKey = 'transaction_id';
    protected $allowedFields = [
        'item_id', 'transaction_type', 'quantity', 'unit_price',
        'total_amount', 'transaction_date', 'reference_type',
        'reference_id', 'notes', 'created_by'
    ];
    protected $useTimestamps = true;
    
    public function getTransactionHistory($itemId = null, $limit = 50)
    {
        $builder = $this->db->table('inventory_transactions t')
            ->select('t.*, i.item_name, u.username')
            ->join('inventory_items i', 't.item_id = i.item_id')
            ->join('users u', 't.created_by = u.id')
            ->orderBy('t.created_at', 'DESC')
            ->limit($limit);
            
        if ($itemId) {
            $builder->where('t.item_id', $itemId);
        }
        
        return $builder->get()->getResultArray();
    }
}
