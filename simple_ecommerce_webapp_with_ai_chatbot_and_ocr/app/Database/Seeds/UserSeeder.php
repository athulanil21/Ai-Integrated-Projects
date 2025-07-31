<?php

namespace App\Database\Seeds;

class UserSeeder extends \CodeIgniter\Database\Seeder
{
    public function run()
    {
        $data = array(
            'name' => 'codemaster labs',
            'email' => 'codemasterlabs@gmail.com',
            'password' => '1234567asdf'
        );
        $this->db->table('users')->insert($data);
    }
}