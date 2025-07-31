<?php

namespace App\Controllers;

class Migrate extends BaseController
{
    public function index(): string
    {
        $migration = \Config\Services::migrations();
        try {
            $migration->latest();
            return "All migrations completed successfully.";
        } catch (\Exception $e) {
            return "Migration failed: " . $e->getMessage();
        }
    }
    public function rollback(): string
    {
        $migration = \Config\Services::migrations();
        try {
            $migration->regress();
            return "All migrations rolled back successfully.";
        } catch (\Exception $e) {
            return "Rollback failed: " . $e->getMessage();
        }
    }
}
