<?php

namespace App\Controllers;

class Setup extends BaseController
{
    public function createProductsTable(): string
    {
        $db = \Config\Database::connect();
        $forge = \Config\Database::forge();
        try {
            // Only create if not exists
            if (!$db->tableExists('products')) {
                $fields = [
                    'id' => [
                        'type' => 'INT',
                        'constraint' => 11,
                        'unsigned' => true,
                        'auto_increment' => true
                    ],
                    'title' => [
                        'type' => 'VARCHAR',
                        'constraint' => 150,
                        'null' => false
                    ],
                    'description' => [
                        'type' => 'TEXT',
                        'null' => true
                    ],
                    'price' => [
                        'type' => 'DECIMAL',
                        'constraint' => '10,2',
                        'null' => false
                    ],
                    'image' => [
                        'type' => 'VARCHAR',
                        'constraint' => 255,
                        'null' => true
                    ],
                    'created_at' => [
                        'type' => 'DATETIME',
                        'null' => true
                    ],
                    'updated_at' => [
                        'type' => 'DATETIME',
                        'null' => true
                    ],
                    'deleted_at' => [
                        'type' => 'DATETIME',
                        'null' => true
                    ],
                ];
                $forge->addField($fields);
                $forge->addKey('id', true);
                $forge->createTable('products');
                return "Products table created successfully.";
            } else {
                return "Products table already exists.";
            }
        } catch (\Exception $e) {
            return "Failed to create products table: " . $e->getMessage();
        }
    }

    public function dropProductsTable(): string
    {
        $forge = \Config\Database::forge();
        try {
            $forge->dropTable('products');
            return "Products table dropped successfully.";
        } catch (\Exception $e) {
            return "Failed to drop products table: " . $e->getMessage();
        }
    }
    public function index(): string
    {
        $migration = \Config\Services::migrations();
        try{
            $migration->latest();
            return "Database migration completed successfully.";
        } catch (\Exception $e) {
            return "Migration failed: " . $e->getMessage();
        }
    }
    public function droptable(): string
    {
        $migration = \Config\Services::migrations();
        try{
            $migration->dropTable('users');
            return "Users table dropped successfully.";
        } catch (\Exception $e) {
            return "Failed to drop table: " . $e->getMessage();
        }
    }
    public function userSeed(){
        $seeder = \Config\Database::seeder();
        try{
            // Run the seeder (replace 'UserSeeder' with your actual seeder class name)
            $seeder->call('UserSeeder');
            return "Seeding users table...";
        }catch(\Exception $e){
            return "error in inserting data in database: " . $e->getMessage();
        }
    }
}