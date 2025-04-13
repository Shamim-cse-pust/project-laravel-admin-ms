<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Mail;

Route::get('/', function () {
    return 'shamim1';
});

Route::get('/test-email', function () {
    try {
        Mail::raw('This is a test email from Admin!', function ($message) {
            $message->to('test@example.com')
                    ->subject('Test Email');
        });

        return 'Email sent successfully!';
    } catch (\Exception $e) {
        return 'Failed to send email: ' . $e->getMessage();
    }
});
