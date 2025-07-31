<?php

namespace App\Controllers;

class Home extends BaseController
{
    public function index(): string
    {
        // Example: get user name from session or set default
        $name = session()->get('name') ?? 'User';
        return view('user_home', ['name' => $name]);
    }

    public function ocr()
    {
        $name = session()->get('name') ?? 'User';
        $ocr_text = null;
        $ocr_error = null;
        $file = $this->request->getFile('ocr_image');
        if ($file && $file->isValid() && !$file->hasMoved()) {
            $newName = $file->getRandomName();
            $file->move(WRITEPATH . 'uploads', $newName);
            $imagePath = WRITEPATH . 'uploads/' . $newName;
            // Use full path to python and ocr_service.py, rely on script to set tessdata config
            $python = escapeshellarg('C:\\Users\\athul\\AppData\\Local\\Programs\\Python\\Python311\\python.exe');
            $script = escapeshellarg('C:\\xampp\\htdocs\\new\\ocr_service.py');
            $img = escapeshellarg($imagePath);
            $command = $python . ' ' . $script . ' ' . $img;
            $output = shell_exec($command . ' 2>&1');
            if ($output !== null) {
                $ocr_text = $output;
                // If output contains TesseractError, show as error
                if (strpos($output, 'TesseractError') !== false || strpos($output, 'Error opening data file') !== false || strpos($output, 'could not load any languages') !== false) {
                    $ocr_error = 'OCR error: ' . $output;
                    $ocr_text = null;
                }
            } else {
                $ocr_error = 'OCR failed or Python not configured.';
            }
        } else {
            $ocr_error = 'Image upload failed.';
        }
        return view('user_home', [
            'name' => $name,
            'ocr_text' => $ocr_text,
            'ocr_error' => $ocr_error
        ]);
    }
    public function about(): string
    {
        return "This is the about page.";
    }
    public function profile($id): string
    {
        echo "this page with the value of id: " . $id;
        return "This is the profile page.";
    }
}

