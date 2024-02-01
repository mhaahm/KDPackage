<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KdDeposit extends Model
{
    use HasFactory;

    protected $table = 'kd_deposit';

    protected $fillable = [
      'deposit_name',
      'deposit_path',
      'deposit_url'
    ];
}
