<?php

namespace App\Exceptions;

use Exception;

class GeneralExceptionCatch extends Exception
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
