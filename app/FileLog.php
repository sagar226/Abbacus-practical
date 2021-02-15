<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FileLog extends Model
{
    protected $fillable = [
        'id','uuid','row_number','delivery_note_number','beat_name','fail_reason'
    ];
}

