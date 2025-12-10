<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LapakLog extends Model
{
    use HasFactory;

    protected $table = 'lapak_logs';

    protected $fillable = [
        'lapak_id',
        'changed_by',
        'changed_by_role',
        'old_data',
        'new_data'
    ];

    protected $casts = [
        'old_data' => 'array',
        'new_data' => 'array',
    ];
}
