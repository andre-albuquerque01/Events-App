<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserHasEvents extends Model
{
    use HasFactory;

    protected $fillable = [
        "idUser",
        "idEvents",
        "valuePay",
        "qtdTicket",
        "statusPay",
        "numberPix",
        "pathNameFile",
    ];
}
