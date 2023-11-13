<?php
if (!function_exists('log_activity')) {
    function log_activity($employeeId, $ipAddress, $description)
    {
        $userLogModel = new \App\Models\UserLogModel();

        $data = [
            'id_emp' => $employeeId,
            'ip_adresse' => $ipAddress,
            'date_log' => date('Y-m-d H:i:s'),
            'description' => $description,
        ];

        $userLogModel->insert($data);
    }
}