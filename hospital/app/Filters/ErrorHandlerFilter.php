<?php

namespace App\Filters;

use App\Libraries\LoggerService;
use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class ErrorHandlerFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        // Log request
        LoggerService::logSystemEvent('Request Started', [
            'method' => $request->getMethod(),
            'uri' => $request->getUri()->getPath(),
            'user_id' => session()->get('user_id')
        ]);
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        $statusCode = $response->getStatusCode();
        
        // Log response
        LoggerService::logSystemEvent('Request Completed', [
            'method' => $request->getMethod(),
            'uri' => $request->getUri()->getPath(),
            'status_code' => $statusCode,
            'user_id' => session()->get('user_id')
        ]);
        
        // Log errors
        if ($statusCode >= 400) {
            LoggerService::logSystemEvent('HTTP Error', [
                'status_code' => $statusCode,
                'uri' => $request->getUri()->getPath(),
                'method' => $request->getMethod()
            ]);
        }
    }
}
