<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReportedBench extends Model
{
    use HasFactory;

    protected $fillable = [
        'bench',
        'reason',
        'amount_reported',
    ];
}
