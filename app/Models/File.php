<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class File extends Model
{
    use HasFactory;

    protected $table = "files";
    protected $primary = "idFile";
    protected $fillable = [
        'pathName',
    ];

    public function events()
    {
        return $this->belongsTo(Events::class);
    }
}
