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


Route::post('/login', [AuthController::class, 'Login']);
Route::post('/login/validate-otc', [AuthController::class, 'validateOTC']);/* ->middleware('auth:sanctum'); */
Route::post('/login/resend-otc', [AuthController::class, 'resendOTC']);/* ->middleware('auth:sanctum'); */


Route::middleware(['auth:sanctum'])->group(function () {

    //all admin routes
    Route::prefix('admin')->group(function () {
        Route::apiSingleton('/', AdminController::class); // managing admin and sub admin routes
        Route::apiResource('/users', OrgUsersController::class); // managing organization members or users
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
    //super admin routes
    // Route::middleware('user.role:super-admin')->group(function () {
    //     Route::prefix('supper-admin')->group(function () {
    //         Route::apiSingleton('/user', UserController::class);
    //         Route::apiResource('/admins', ManageAdminController::class);
    //         Route::get('/user/roles', function () {
    //             return response()->json([
    //                 'success' => true,
    //                 'data' => UserRole::all()
    //             ]);
    //         });
    //         Route::get('/admin/account_status', function () {
    //             return response()->json([
    //                 'success' => true,
    //                 'data' => UserAccountStatus::all()
    //             ]);
    //         });
    //     });
    // });
    //admin routes
    // Route::middleware('user.role:admin')->group(function () {
    //     Route::get('/admin', [OrganizationController::class, 'index']);
    //     Route::prefix('admin')->group(function () {

    //         Route::get('/account_status', function () {\
    //             return response()->json([
    //                 'success' => true,
    //                 'data' => UserAccountStatus::all()
    //             ]);
    //         });
    //         Route::apiResources([]);
    //         Route::prefix('org')->group(function () {
    //             Route::get('/', [OrganizationController::class, 'show']);
    //             Route::apiResource('/parents', OrganizationParentController::class);
    //             Route::apiResource('/departments', OrgDepartmentsController::class);
    //             Route::apiResource('/cards', '');
    //             Route::apiResource('/teachers', OrgMemberController::class);
    //             Route::get('/clock-ins', [OrganizationController::class, 'clockIns']);
    //             Route::get('/clock-outs', [OrganizationController::class, 'clockOuts']);
    //         });
    //         Route::apiResource('/org{id}', OrganizationController::class); //admin route for organizations
    //     });
    // });
    // Route::prefix('/organizations')->group(function () {
    //     Route::apiResource('/org', OrganizationController::class); //admin route for organizations
    //     Route::apiResource('/{id}/parents', OrganizationParentController::class);
    //     // Route::apiResource('/{id}/children', [OrganizationController::class, 'members']);
    //     // Route::apiResource('/{id}/departments', [OrganizationController::class, 'departments']);
    //     // Route::apiResource('/{id}/cards', [OrganizationController::class, 'projects']);
    //     // Route::apiResource('/{id}/members', OrganizationController::class, 'members');
    //     // Route::get('/{id}/clock-ins', [OrganizationController::class, 'tasks']);
    // })->middleware('user.role:super-admin');
    // Route::prefix('parents')->group(function () {
    //     Route::get('{id}', [ParentController::class, 'show']); //get the specified parent
    //     Route::get('/{id}/children', [ParentController::class, 'children']); // get the children of the specified parent 
    //     Route::get('/{id}/children/{child_id}', [ParentController::class, 'child']); // get the child of the specified parent, with all the info about the specified child
    //     Route::apiResource('/{id}/delegates', ParentDelegateController::class); // actions for the delegates of the specified parent
    // })->middleware('user.role:parent'); // middleware to check if the user is a parent
    // // Route::prefix('/parent')->group(function () {
    //     Route::get('/{id}', [OrganizationController::class, 'parentEmployees']);
    //     Route::get('/{id}/children', [OrganizationController::class, 'parentMembers']);
    //     Route::get('/{id}/departments', [OrganizationController::class, 'parentDepartments']);
    //     Route::get('/{id}/projects', [OrganizationController::class, 'parentProjects']);
    //     Route::get('/{id}/tasks', [OrganizationController::class, 'parentTasks']);
    //     Route::get('/{id}/meetings', [OrganizationController::class, 'parentMeetings']);
    //     Route::get('/{id}/reports', [OrganizationController::class, 'parentReports']);
    //     Route::get('/{id}/settings', [OrganizationController::class, 'parentSettings']);
    //     Route::get('/{id}/calendar', [OrganizationController::class, 'parentCalendar']);
    // });
    // Route::prefix('/children')->group(function () {
    //     Route::get('/{id}', [OrganizationController::class, 'childEmployees']);
    //     Route::get('/{id}/parents', [OrganizationController::class, 'childParents']);
    //     Route::get('/{id}/departments', [OrganizationController::class, 'childDepartments']);
    //     Route::get('/{id}/projects', [OrganizationController::class, 'childProjects']);
    //     Route::get('/{id}/tasks', [OrganizationController::class, 'childTasks']);
    //     Route::get('/{id}/meetings', [OrganizationController::class, 'childMeetings']);
    //     Route::get('/{id}/reports', [OrganizationController::class, 'childReports']);
    //     Route::get('/{id}/settings', [OrganizationController::class, 'childSettings']);
    //     Route::get('/{id}/calendar', [OrganizationController::class, 'childCalendar']);
    // });
});
