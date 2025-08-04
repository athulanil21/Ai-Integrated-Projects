<?php

namespace App\Libraries;

use CodeIgniter\Debug\BaseExceptionHandler;
use CodeIgniter\Debug\ExceptionHandler;
use CodeIgniter\Debug\ExceptionHandlerInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Throwable;

class CustomExceptionHandler extends BaseExceptionHandler implements ExceptionHandlerInterface
{
    protected ?string $viewPath = APPPATH . 'Views/errors/';

    public function handle(
        Throwable $exception,
        RequestInterface $request,
        ResponseInterface $response,
        int $statusCode,
        int $exitCode
    ): void {
        
        // Log detailed error information
        if (!in_array($statusCode, $this->config->ignoreCodes, true)) {
            $logMessage = sprintf(
                '[%s] %s in %s:%d - Request: %s %s - IP: %s - User Agent: %s',
                $statusCode,
                $exception->getMessage(),
                clean_path($exception->getFile()),
                $exception->getLine(),
                $request->getMethod(),
                $request->getUri()->getPath(),
                $request->getIPAddress(),
                $request->getUserAgent()
            );
            
            log_message('critical', $logMessage, [
                'exception' => $exception,
                'request_data' => $request->getJSON(true) ?: $request->getPost(),
                'session_data' => session()->get()
            ]);
        }

        // Use framework handler for display
        $frameworkHandler = new ExceptionHandler($this->config);
        $frameworkHandler->handle($exception, $request, $response, $statusCode, $exitCode);
    }
}
