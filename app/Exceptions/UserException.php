<?php

namespace App\Exceptions;

use Exception;

class UserException extends Exception
{
    protected $message = '';
    public function render()
    {
        return response()->json([
            'error' => class_basename($this),
            'message' => $this->message,
        ]);
    }
}
