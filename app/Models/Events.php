<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Events extends Model
{
    use HasFactory;
    protected $table = 'events';
    protected $primaryKey = 'idEvents';
    protected $fillable = [
        'title',
        'description',
        'price',
        'department',
        'occupation',
        'statusEvent',
        'idFile'
    ];
    public function file()
    {
        return $this->hasOne(File::class, 'idFile', 'idFile');
    }
}
