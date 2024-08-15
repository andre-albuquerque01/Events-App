<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserHasEvents extends Model
{
    use HasFactory, HasUlids;

    protected $table = 'user_has_events';
    protected $primaryKey = 'idUser_has_events';
    protected $fillable = [
        "idUser",
        "idEvents",
    ];

    public function events()
    {
        return $this->belongsTo(Events::class, 'idEvents');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'idUser');
    }
}
