<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TimeLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'start_time',
        'end_time',
        'duration',
        'description',
        'status'
    ];

    protected $casts = [
        'start_time' => 'datetime:Y-m-d\TH:i:s.uP', // Example format
        'end_time' => 'datetime:Y-m-d\TH:i:s.uP',   // Example format
    ];

}

?>
