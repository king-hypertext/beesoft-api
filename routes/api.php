<?php

use App\Http\Controllers\ManageCards;
use App\Http\Controllers\OrgDepartmentsController;
use App\Http\Controllers\OrgMemberController;
use App\Http\Controllers\SuperAdminController;
use App\Http\Controllers\v1\AdminController;
use App\Http\Controllers\v1\AuthController;
use App\Http\Controllers\v1\ManageAdminController;
use App\Http\Controllers\v1\ManageCardsController;
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
Route::post('/login/validate-otc', [AuthController::class, 'validateOTC']);/* ->middleware('auth:sanctum'); */
Route::post('/login', [AuthController::class, 'Login']);
Route::post('/login/resend-otc', [AuthController::class, 'resendOTC']);/* ->middleware('auth:sanctum'); */

Route::middleware(['auth:sanctum'])->group(function () {
    //all admin routes

    Route::prefix('admin')->group(function () {
        Route::apiSingleton('/', AdminController::class); // managing admin and sub admin routes
        Route::post('/user/{user_id}/link-card', [OrgUsersController::class, 'linkCard']); // managing
        Route::apiResource('/users', OrgUsersController::class); // managing organization members or users
        Route::apiResource('/cards', OrgCardsController::class); // managing
        Route::apiResource('/departments', OrgDepartmentsController::class); // managing
    });
    Route::apiSingleton('/super-admin', SuperAdminController::class)->middleware('user.role:super-admin');
    Route::prefix('super-admin')->group(function () {
        Route::apiResource('/manage-admins', ManageAdminController::class);
        Route::apiResource('/manage-cards', ManageCardsController::class);
        Route::apiResource('/manage-organizations', ManageOrganization::class);
    });

    // all super admin routes
    Route::post('/logout', function (Request $request) {
        $request->user()->tokens()->delete();
        return response()->noContent();
    });
    Route::put('/users/{id}/upload-image', [UserController::class, 'storeImage']);
});
