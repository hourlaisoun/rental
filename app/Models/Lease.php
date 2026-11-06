<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lease extends Model
{
    use HasFactory;

    protected $fillable = [
        'room_id',
        'tenant_id',
        'start_date',
        'end_date',
        'deposit_amount',
        'monthly_rent',
        'rent_amount',    // 💡 បន្ថែម field នេះចូល
        'payment_method',
        'status',
    ];
}