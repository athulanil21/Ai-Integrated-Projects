<?php
namespace App\Models;
use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table = 'users';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'username', 'email', 'password', 'role_id', 'status', 'created_at', 'updated_at'
    ];
    protected $useTimestamps = true;

    public function createUser($userData)
    {
        $userData['password'] = password_hash($userData['password'], PASSWORD_DEFAULT);
        return $this->insert($userData);
    }

    public function authenticate($email, $password)
    {
        $user = $this->where('email', $email)->first();
        
        if ($user && password_verify($password, $user['password'])) {
            return $user;
        }
        
        return false;
    }
}
