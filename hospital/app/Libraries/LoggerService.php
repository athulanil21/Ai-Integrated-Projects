<?php

namespace App\Libraries;

class LoggerService
{
    public static function logUserAction($action, $details = [])
    {
        $logData = [
            'user_id' => session()->get('user_id'),
            'username' => session()->get('username'),
            'action' => $action,
            'details' => $details,
            'ip_address' => service('request')->getIPAddress(),
            'user_agent' => service('request')->getUserAgent(),
            'timestamp' => date('Y-m-d H:i:s')
        ];
        
        log_message('info', 'User Action: ' . $action, $logData);
    }
    
    public static function logSystemEvent($event, $level = 'info', $context = [])
    {
        $logData = [
            'event' => $event,
            'context' => $context,
            'timestamp' => date('Y-m-d H:i:s')
        ];
        
        log_message($level, 'System Event: ' . $event, $logData);
    }
    
    public static function logSecurityEvent($event, $details = [])
    {
        $logData = [
            'event' => $event,
            'details' => $details,
            'ip_address' => service('request')->getIPAddress(),
            'user_agent' => service('request')->getUserAgent(),
            'timestamp' => date('Y-m-d H:i:s')
        ];
        
        log_message('warning', 'Security Event: ' . $event, $logData);
    }
}
