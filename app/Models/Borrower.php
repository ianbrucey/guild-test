<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Borrower extends Model
{
    use HasFactory;

    const PRIMARY_BORROWER_TYPE = "1";
    const CO_BORROWER_TYPE = "0";

    protected $fillable = [
        'first',
        'last',
        'email',
        'loan_application_id',
        'user_id',
        'borrower_type',
        'annual_salary',
        'bank_account_value',
        'user_id'
    ];

    public function user() {
        $this->belongsTo('App\Models\User');
    }

    public function application() {
        $this->belongsTo('App\Models\LoanApplication');
    }
}
