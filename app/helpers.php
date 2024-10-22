<?php

if (!function_exists('format_phone_number')) {
    function format_phone_number($phone) {
        $phone = preg_replace('/\D+/', '', $phone);

        if (strlen($phone) === 10) {
            return preg_replace('/(\d{2})(\d{2})(\d{2})(\d{2})(\d{2})/', '$1 $2 $3 $4 $5', $phone);
        }

        return $phone;
    }
}
