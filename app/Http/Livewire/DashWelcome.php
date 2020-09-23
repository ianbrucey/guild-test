<?php

namespace App\Http\Livewire;

use App\Models\LoanApplication;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class DashWelcome extends Component
{
    public function render()
    {
        $apps = DB::table('loan_applications')->orderBy('id', 'desc')->simplePaginate(5);
        return view('livewire.dash-welcome', ['apps' => $apps]);
    }
}
