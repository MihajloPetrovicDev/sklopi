<?php 

namespace App\Services;

use Exception;
use Illuminate\Support\Facades\Log;

class ErrorService {
    public function handleGuestException(Exception $e) {
        Log::error('Error occurred', [
            'message' => $e->getMessage(),
            'exception' => $e,
            'file' => $e->getFile(),
            'line' => $e->getLine(),
            'trace' => $e->getTraceAsString()
        ]);

        return response()->json(['errors' => [
            'error' => [__('errors.general.unexpected_error')]
        ]], 500);
    }
}