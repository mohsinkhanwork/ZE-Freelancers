<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserData extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'first_name',
        'last_name',
        'company',
        'address',
        'city',
        'country',
        'postal_code',
        'description',
    ];

    public function user()
        {
            return $this->belongsTo(User::class);
        }
}
