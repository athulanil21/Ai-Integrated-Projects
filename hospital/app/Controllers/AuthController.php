<?php

namespace App\Controllers;

use App\Models\UserModel;
use App\Models\RoleModel;
use CodeIgniter\Controller;

class AuthController extends BaseController
{
    protected $userModel;
    protected $roleModel;
    
    public function __construct()
    {
        $this->userModel = new UserModel();
        $this->roleModel = new RoleModel();
        helper(['form', 'url', 'email']);
    }
    
    public function register()
    {
        if ($this->request->getMethod() === 'POST') {
            $validationRules = [
                'username' => 'required|min_length[3]|max_length[50]|is_unique[users.username]',
                'email' => 'required|valid_email|is_unique[users.email]',
                'password' => 'required|min_length[8]',
                'confirm_password' => 'required|matches[password]',
                'role_id' => 'required|integer'
            ];
            
            if (!$this->validate($validationRules)) {
                return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
            }
            
            $userData = [
                'username' => $this->request->getPost('username'),
                'email' => $this->request->getPost('email'),
                'password' => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
                'role_id' => $this->request->getPost('role_id'),
                'status' => 'active'
            ];
            
            if ($this->userModel->insert($userData)) {
                return redirect()->to('/auth/login')->with('success', 'Registration successful! Please login.');
            } else {
                return redirect()->back()->with('error', 'Registration failed. Please try again.');
            }
        }
        
        $data['roles'] = $this->roleModel->where('id !=', 1)->findAll(); // Exclude admin role
        return view('auth/register', $data);
    }
    
    public function forgotPassword()
    {
        if ($this->request->getMethod() === 'POST') {
            $email = $this->request->getPost('email');
            $user = $this->userModel->where('email', $email)->first();
            
            if (!$user) {
                return redirect()->back()->with('error', 'Email address not found.');
            }
            
            // Generate reset token
            $resetToken = bin2hex(random_bytes(32));
            $resetExpires = date('Y-m-d H:i:s', strtotime('+1 hour'));
            
            // Update user with reset token
            $this->userModel->update($user['id'], [
                'reset_token' => $resetToken,
                'reset_expires' => $resetExpires
            ]);
            
            // Send email
            $this->sendPasswordResetEmail($user['email'], $resetToken);
            
            return redirect()->back()->with('success', 'Password reset link sent to your email.');
        }
        
        return view('auth/forgot_password');
    }
    
    public function resetPassword($token = null)
    {
        if (!$token) {
            return redirect()->to('/auth/forgot-password');
        }
        
        $user = $this->userModel->where('reset_token', $token)
                                ->where('reset_expires >', date('Y-m-d H:i:s'))
                                ->first();
        
        if (!$user) {
            return redirect()->to('/auth/forgot-password')->with('error', 'Invalid or expired reset token.');
        }
        
        if ($this->request->getMethod() === 'POST') {
            $validationRules = [
                'password' => 'required|min_length[8]',
                'confirm_password' => 'required|matches[password]'
            ];
            
            if (!$this->validate($validationRules)) {
                return redirect()->back()->with('errors', $this->validator->getErrors());
            }
            
            // Update password
            $this->userModel->update($user['id'], [
                'password' => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
                'reset_token' => null,
                'reset_expires' => null
            ]);
            
            return redirect()->to('/auth/login')->with('success', 'Password reset successful! Please login.');
        }
        
        $data['token'] = $token;
        return view('auth/reset_password', $data);
    }
    
    private function sendPasswordResetEmail($email, $token)
    {
        $emailService = \Config\Services::email();
        
        $emailService->setTo($email);
        $emailService->setFrom('noreply@hms.com', 'Healthcare Management System');
        $emailService->setSubject('Password Reset Request');
        
        $resetUrl = base_url("auth/reset-password/{$token}");
        $message = view('emails/password_reset', ['reset_url' => $resetUrl]);
        
        $emailService->setMessage($message);
        $emailService->send();
    }
}
