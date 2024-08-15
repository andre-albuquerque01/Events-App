<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Events extends Model
{
    use HasFactory, HasUlids;
    protected $table = 'events';
    protected $primaryKey = 'idEvents';
    protected $fillable = [
        'title',
        'description',
        'price',
        'department',
        'occupation',
        'qtdParcelamento',
        'dateEvent',
        'timeEvent',
        'pathName',
        'statusEvent',
    ];

    public function eventHasUser(){
        return $this->hasMany(UserHasEvents::class, 'idEvents', 'idEvents');
    }
}
