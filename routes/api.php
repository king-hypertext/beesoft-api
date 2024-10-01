<?php

use App\Http\Controllers\v1\AuthController;
use App\Http\Controllers\v1\OrganizationController;
use App\Http\Controllers\v1\ParentController;
use App\Http\Controllers\v1\ParentDelegateController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::post('/login', [AuthController::class, 'Login']);
Route::post('/login/validate-otc', [AuthController::class, 'validateOTC']);/* ->middleware('auth:sanctum'); */
Route::post('/login/resend-otc', [AuthController::class, 'resendOTC']);/* ->middleware('auth:sanctum'); */

Route::middleware(['auth:sanctum'])->group(function () {
    // Route::resource('/organizations', OrganizationController::class); //admin route for organizations
    Route::prefix('/organizations')->group(function () {
        Route::resource('/', OrganizationController::class); //admin route for organizations
        Route::resource('/{id}/parents', [OrganizationController::class, 'employees']);
        Route::resource('/{id}/children', [OrganizationController::class, 'members']);
        Route::resource('/{id}/departments', [OrganizationController::class, 'departments']);
        Route::resource('/{id}/cards', [OrganizationController::class, 'projects']);
        Route::resource('/{id}/members', OrganizationController::class, 'members');
        Route::get('/{id}/clock-ins', [OrganizationController::class, 'tasks']);
    });
    Route::prefix('parents')->group(function () {
        Route::get('{id}', [ParentController::class, 'show']); //get the specified parent
        Route::get('/{id}/children', [ParentController::class, 'children']); // get the children of the specified parent 
        Route::get('/{id}/children/{id}', [ParentController::class, 'child']); // get the child of the specified parent, with all the info about the specified child
        Route::resource('/{id}/delegates', ParentDelegateController::class); // actions for the delegates of the specified parent

    })->middleware('user.role:parent'); // middleware to check if the user is a parent
    Route::prefix('/parent')->group(function () {
        Route::get('/{id}', [OrganizationController::class, 'parentEmployees']);
        Route::get('/{id}/children', [OrganizationController::class, 'parentMembers']);
        Route::get('/{id}/departments', [OrganizationController::class, 'parentDepartments']);
        Route::get('/{id}/projects', [OrganizationController::class, 'parentProjects']);
        Route::get('/{id}/tasks', [OrganizationController::class, 'parentTasks']);
        Route::get('/{id}/meetings', [OrganizationController::class, 'parentMeetings']);
        Route::get('/{id}/reports', [OrganizationController::class, 'parentReports']);
        Route::get('/{id}/settings', [OrganizationController::class, 'parentSettings']);
        Route::get('/{id}/calendar', [OrganizationController::class, 'parentCalendar']);
    });
    Route::prefix('/children')->group(function () {
        Route::get('/{id}', [OrganizationController::class, 'childEmployees']);
        Route::get('/{id}/parents', [OrganizationController::class, 'childParents']);
        Route::get('/{id}/departments', [OrganizationController::class, 'childDepartments']);
        Route::get('/{id}/projects', [OrganizationController::class, 'childProjects']);
        Route::get('/{id}/tasks', [OrganizationController::class, 'childTasks']);
        Route::get('/{id}/meetings', [OrganizationController::class, 'childMeetings']);
        Route::get('/{id}/reports', [OrganizationController::class, 'childReports']);
        Route::get('/{id}/settings', [OrganizationController::class, 'childSettings']);
        Route::get('/{id}/calendar', [OrganizationController::class, 'childCalendar']);
    });
});
