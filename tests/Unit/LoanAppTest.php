<?php

namespace Tests\Unit;

use App\Models\LoanApplication;
use App\Models\Borrower;
use App\Models\User;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class LoanAppTest extends TestCase
{
    use WithFaker;
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function testExample()
    {
        $this->assertTrue(true);
    }

    public function testCanMakeLoanAppEntity() {

        $user = Sanctum::actingAs(
            User::factory()->create(),
            ['*']
        );

        $application = LoanApplication::create([
            'user_id' => Auth::id(),
            'title' => $this->faker->jobTitle . " loan application",
            'progress' => LoanApplication::COMPLETE_PROGRESS,
            'status' => LoanApplication::PENDING_STATUS,
        ]);

        $this->assertNotEmpty($application);

        $this->assertEquals($user->id, $application->user->id);

        LoanApplication::destroy($application['id']);

    }

    public function testCanMakeBorrowers() {

        Sanctum::actingAs(
            User::factory()->create(),
            ['*']
        );

        $application = LoanApplication::create([
            'user_id' => Auth::id(),
            'title' => $this->faker->jobTitle . " loan application",
            'progress' => LoanApplication::COMPLETE_PROGRESS,
            'status' => LoanApplication::PENDING_STATUS,
        ]);
// php artisan test --debug
        $borrower = Borrower::create([
            'user_id' => Auth::id(),
            'loan_application_id' => $application['id'],
            'first' => 'Test',
            'last' => 'Last',
            'email' => 'rand@yopmail.com',
            'borrower_type' => '1',
            'annual_salary' => '123455',
            'bank_account_value' => '124545',
        ]);

        $this->assertNotEmpty($application);

        $this->assertEquals($borrower['loan_application_id'], $application['id']);

        $this->assertEquals($borrower['user_id'], $application['user_id']);

        LoanApplication::destroy($application['id']);

        Borrower::destroy($borrower['id']);

    }

    public function testCanRollback() {

        Sanctum::actingAs(
            User::factory()->create(),
            ['*']
        );

        try {
            DB::beginTransaction();

            $application = LoanApplication::create([
                'user_id' => Auth::id(),
                'title' => $this->faker->jobTitle . " loan application",
                'progress' => LoanApplication::COMPLETE_PROGRESS,
                'status' => LoanApplication::PENDING_STATUS,
            ]);

            $borrower = Borrower::create([
                'user_id' => Auth::id(),
                'loan_application_id' => $application['id'],
                'first' => 'Test',
                'last' => 'Last',
                'email' => 'rand@yopmail.com',
                'borrower_type' => '1',
                'annual_salary' => '123455',
                'bank_account_value' => '124545',
            ]);

            // DB::commit(); // test will fail if this is uncommented

            throw new \Exception("Failure Test");



        } catch (\Exception $e) {
            DB::rollBack();
            $this->assertEmpty(Borrower::find($borrower['id']));
        }

    }

    public function testApiGetAccurateBorrowerTotal() {

        $total = 50000;

        Sanctum::actingAs(
            User::factory()->create(),
            ['*']
        );

        $application = LoanApplication::create([
            'user_id' => Auth::id(),
            'title' => $this->faker->jobTitle . " loan application",
            'progress' => LoanApplication::COMPLETE_PROGRESS,
            'status' => LoanApplication::PENDING_STATUS,
        ]);
// php artisan test --debug
        $borrower = Borrower::create([
            'user_id' => Auth::id(),
            'loan_application_id' => $application['id'],
            'first' => 'Test',
            'last' => 'Last',
            'email' => 'rand@yopmail.com',
            'borrower_type' => '1',
            'annual_salary' => '20000',
            'bank_account_value' => '0',
        ]);

        $coBorrower = Borrower::create([
            'user_id' => Auth::id(),
            'loan_application_id' => $application['id'],
            'first' => 'NewTest',
            'last' => 'Last',
            'email' => 'random@yopmail.com',
            'borrower_type' => '1',
            'annual_salary' => '20000',
            'bank_account_value' => '10000',
        ]);

        $response = $this->get('/api/application/'.$application['id']);

        $response->assertOk();

        $this->assertEquals($total, $response->json()[0]['total']);

        LoanApplication::destroy($application['id']);

        Borrower::destroy($borrower['id']);

        Borrower::destroy($coBorrower['id']);

    }
}
