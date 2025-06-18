<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Expense extends Model
{
    use HasFactory;

    protected $primaryKey = 'expense_id'; // Set primary key manual
    public $incrementing = false; // Matikan auto-increment

    protected $fillable = [
        'expense_id',
        'expense_name',
        'quantity',
        'expense_total',
        'note',
        'expense_date',
    ];

    protected $casts = [
        'expense_date' => 'datetime:d-m-Y H:i:s',
    ];
}


