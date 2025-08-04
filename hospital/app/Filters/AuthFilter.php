<?php
namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

class AuthFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        if (!session()->get('is_logged_in')) {
            return redirect()->to('/login');
        }
        
        if ($arguments && !$this->hasPermission($arguments)) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException();
        }
    }
    
    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Nothing to do here
    }
    
    private function hasPermission($requiredRoles)
    {
        $userRoleId = session()->get('role_id');
        return in_array($userRoleId, $requiredRoles);
    }
}
