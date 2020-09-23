<?php

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

/**
 * This route here will get the total income of all borrowers on the application
 */
Route::middleware('auth:sanctum')->get('/application/{loanAppId}', function (Request $request, $loanAppId) {
    return DB::table('borrowers')->select(DB::raw('SUM(annual_salary) + SUM(bank_account_value) as total'))->where("loan_application_id", $loanAppId)->get();
});

Route::post('/logout', function (Request $request) {
    Auth::logout();
    redirect()->route("welcome");
});

Route::post('/login', function (Request $request) {
    $request->validate([
        'email' => 'required|email',
        'password' => 'required'
    ]);

    $user = User::where('email', $request->email)->first();

    if (!$user || !Hash::check($request->password, $user->password)) {
        return response([
            'error' => ['These credentials do not match our records.']
        ], 404);
    } else {

        $token = $user->createToken('guild')->plainTextToken;

        $response = [
            'user' => $user,
            'token' => $token
        ];

        if($request->web == 1) {
            Auth::attempt($request->only('email', 'password'));
            return response(['web_success' => $response], 201);
        }

        return response(['success' => $response], 201);
    }

});
