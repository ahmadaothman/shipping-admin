<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
ini_set('memory_limit','2048M');

class PaymentMethod extends Model
{
    protected $table = 'payment_method';
}
