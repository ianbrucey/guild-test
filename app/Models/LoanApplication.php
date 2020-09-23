<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LoanApplication extends Model
{
    use HasFactory;

    const COMPLETE_PROGRESS   = "1";
    const INCOMPLETE_PROGRESS = "0";
    const DENIED_STATUS = "-1";
    const PENDING_STATUS = "0";
    const APPROVED_STATUS = "1";

    const PRINT_STATUS = [
        self::PENDING_STATUS => "Pending",
        self::APPROVED_STATUS => "Approved",
        self::DENIED_STATUS => "DENIED PLEASE DON'T COME BACK!",
    ];

    const PRINT_PROGRESS = [
        self::COMPLETE_PROGRESS => "Complete",
        self::INCOMPLETE_PROGRESS => "Incomplete",
    ];

    protected $fillable = [
        'title',
        'progress',
        'status',
        'user_id'
    ];

    public function user() {
        return $this->belongsTo('App\Models\User');
    }

    public function borrowers() {
        return $this->hasMany('App\Models\Borrower');
    }

    public static function getStatus() {

    }
}
