<?php
/*
 * Copyright © 2022 by SysQube Technology, All rights reserved.
 *
 * Use of this file without prior written permission from SysQube Technology is prohibited.
 * For questions or any dealings please contact us
 *
 * Author: Kishor Shrestha
 * Email: winneecreztha@gmail.com | kishor@sysqube.com
 */

use App\Http\Controllers\Settings\Department\DepartmentController;
use App\Http\Controllers\Settings\Permission\PermissionController;
use App\Http\Controllers\Settings\Role\RoleController;
use App\Http\Controllers\Settings\SettingsApiController;
use App\Http\Controllers\Settings\User\UserController;
use Illuminate\Support\Facades\Route;


/**************************** Routes For Settings **********************************/

Route::controller(PermissionController::class)
    ->prefix('settings/permission')
    ->as('settings.permission.')
    ->group(function () {
        Route::get('', 'index')->name('index');
        Route::post('', 'storePermission')->name('store');
        Route::post('/{permission}', 'updatePermission')->name('update');
        Route::delete('/{permission}', 'deletePermission')->name('delete');
    });

Route::controller(RoleController::class)
    ->prefix('settings/role')
    ->as('settings.role.')
    ->group(function () {
        Route::get('', 'index')->name('index');
        Route::post('', 'store')->name('store');
        Route::post('/{role}', 'update')->name('update');
        Route::delete('/{role}', 'delete')->name('delete');
    });

Route::controller(DepartmentController::class)
    ->prefix('settings/department')
    ->as('settings.department.')
    ->group(function () {
        //use resource
        Route::get('', 'index')->name('index');
        Route::post('', 'store')->name('store');
        Route::post('/{department}', 'update')->name('update');
        Route::delete('/{department}', 'delete')->name('delete');

        Route::get('/{department_id}', 'singleDepartment')->name('divison.index');
        Route::post('/{department_id}/divison', 'addNewDivison')->name('division.store');
        Route::delete('/{department_id}/divison/{divison}', 'deleteDivison')->name('division.delete');

        Route::get('/{department}/divison/{userdivison}/section', 'singleSection')->name('divison.section.index');
        Route::post('/{department}/divison/{userdivison}/section', 'addNewSection')->name('divison.section.store');
        Route::delete('/{department}/divison/{userdivison}/section/{usersection}', 'deleteSection')->name('divison.section.delete');

    });

Route::controller(UserController::class)
    ->prefix('settings/user')
    ->as('settings.user.')
    ->group(function () {
        Route::get('', 'index')->name('index');
        Route::get('/add', 'add')->name('add');
        Route::post('', 'store')->name('store');
        Route::delete('/{user}', 'delete')->name('delete');
        Route::get('/{user}', 'singleUserEditPage')->name('single');
        Route::post('/{user}', 'update')->name('update');
        Route::post('/{user}/permissions/add', 'addPermissionToUser')->name('assign.permissions');
    });

Route::controller(SettingsApiController::class)
    ->prefix('settings/api')
    ->as('settings.api.')
    ->group(function () {
        Route::get('', 'index')->name('index');
        Route::get('/fetch-tdf-data', 'fetchTdfData')->name('fetch.tdf-data');
        Route::get('/fetch-disbursement-data', 'fetchAllDisbursementData')->name('fetch.disbursement-data');
        // Route::get('/add', 'add')->name('add');
        // Route::post('', 'store')->name('store');
        // Route::delete('/{user}', 'delete')->name('delete');
        // Route::get('/{user}', 'singleUserEditPage')->name('single');
        // Route::post('/{user}', 'update')->name('update');
        // Route::post('/{user}/permissions/add', 'addPermissionToUser')->name('assign.permissions');
    });