<?php

namespace App\Http\Livewire;

use App\Models\LoanApplication;
use App\Models\User;
use Faker\Factory;
use Faker\Generator;
use Faker\Provider\Address;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;
use App\Models\Borrower;

class LoanAppForm extends Component
{
    public $borrower;
    public $coBorrower;
    public $failureMessage;
    public $successMessage;

    protected $rules = [
        'borrower.first' => 'required|string|min:2',
        'borrower.last' => 'required|string|min:2',
        'borrower.annual_salary' => 'required|integer',
        'borrower.bank_account_value' => 'integer',
        'borrower.email' => 'required|email',
        'coBorrower.first' => 'required|string|min:2',
        'coBorrower.last' => 'required|string|min:2',
        'coBorrower.annual_salary' => 'required|integer',
        'coBorrower.bank_account_value' => 'integer',
        'coBorrower.email' => 'required|email',
    ];

    public function __construct($id = null)
    {
        parent::__construct($id);

        $this->borrower = new Borrower();
        $this->borrower->first = ucfirst(Auth::user()->first);
        $this->borrower->last = ucfirst(Auth::user()->last);
        $this->borrower->email = Auth::user()->email;


        $this->coBorrower = new Borrower();

    }

    public function render()
    {
        return view('livewire.loan-app-form');
    }

    public function submitApplication() {

        try {
            $this->validate();

            DB::beginTransaction();

            $loanApplication = LoanApplication::create([
                'title' => "Mortgage Loan Application for " . rand(1111, 9999) . " fake street",
                'progress' => LoanApplication::COMPLETE_PROGRESS,
                'status' => LoanApplication::PENDING_STATUS,
                'user_id' => Auth::id()
            ]);

            /** create co-borrower user account */

            $user = User::firstOrCreate(
                [
                    'email' => $this->coBorrower->email
                ],
                [
                    'first' => $this->coBorrower->first,
                    'last' => $this->coBorrower->last,
                    'password' => Hash::make("c2fE@Ffr3f#%")
                ]
            );

            /**
             * in a real world situation,
             * we would want to send an email to the coBorrower so they
             * could reset their PW, establish their own account and see any updates
             */

            $this->setUserIdOnBorrowers($user);
            $this->setLoanAppIds($loanApplication);
            $this->setBorrowerTypes();
            $this->saveBorrowers();
            DB::commit();

        } catch (\Exception $e) {
            DB::rollBack();
            $this->emit('error');
            return $this->failureMessage = $e->getMessage();
        }

        $this->successMessage = "Submission successful";

        session()->flash('success', "Your application has been submitted successfully!");

        return redirect()->to("/dashboard");
    }

    private function setLoanAppIds($loanApplication) {
        $this->borrower->loan_application_id = $loanApplication->id;
        $this->coBorrower->loan_application_id = $loanApplication->id;
    }

    private function setUserIdOnBorrowers($user) {
        $this->coBorrower->user_id = $user['id'];
        $this->borrower->user_id = Auth::id();
    }

    private function setBorrowerTypes() {
        $this->borrower->borrower_type = Borrower::PRIMARY_BORROWER_TYPE;
        $this->coBorrower->borrower_type = Borrower::CO_BORROWER_TYPE;
    }

    private function saveBorrowers() {
        $this->borrower->save();
        $this->coBorrower->save();
    }

}
