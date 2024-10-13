<?php

use App\Http\Controllers\OrgDepartmentsController;
use App\Http\Controllers\OrgMemberController;
use App\Http\Controllers\v1\AdminController;
use App\Http\Controllers\v1\AuthController;
use App\Http\Controllers\v1\ManageAdminController;
use App\Http\Controllers\v1\ManageOrganization;
use App\Http\Controllers\v1\OrganizationController;
use App\Http\Controllers\v1\OrganizationParentController;
use App\Http\Controllers\v1\OrgCardsController;
use App\Http\Controllers\v1\OrgUsersController;
use App\Http\Controllers\v1\ParentController;
use App\Http\Controllers\v1\ParentDelegateController;
use App\Http\Controllers\v1\UserController;
use App\Models\UserAccountStatus;
use App\Models\UserRole;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


// Route::get('/', fn() => abort(404))->name('app');
Route::get('/', fn() =>  response()->json(['message' => 'Not Authourized'], 401))->name('login');
Route::post('/login', [AuthController::class, 'Login']);
Route::post('/login/validate-otc', [AuthController::class, 'validateOTC']);/* ->middleware('auth:sanctum'); */
Route::post('/login/resend-otc', [AuthController::class, 'resendOTC']);/* ->middleware('auth:sanctum'); */

// Route::middleware(['auth:sanctum'])->group(function () {
//all admin routes
Route::prefix('admin')->group(function () {
    Route::apiSingleton('/', AdminController::class); // managing admin and sub admin routes
    Route::apiResource('/users', OrgUsersController::class); // managing organization members or users
    Route::post('/cards/link-card/{user_id}', [OrgUsersController::class, 'LinkCard']); // managing
    Route::apiResource('/cards', OrgCardsController::class); // managing
    Route::apiResource('/departments', OrgDepartmentsController::class); // managing
});
// all super admin routes
Route::prefix('super-admin')->group(function () {
    Route::apiSingleton('/admin', AdminController::class);
    Route::apiResource('/organizations', ManageOrganization::class);
});
Route::post('/logout', function (Request $request) {
    $request->user()->tokens()->delete();
    return response()->noContent();
});
Route::put('/users/{id}/upload-image', [UserController::class, 'storeImage']);
// });
