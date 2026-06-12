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
use App\Http\Controllers\Flow\FlowController;
use App\Http\Controllers\Flow\ProgressInputController;
use App\Http\Controllers\Flow\SetTargetController;
use Illuminate\Support\Facades\Route;


/**************************** Routes For FLOW **********************************/
Route::controller(FlowController::class)
    ->prefix('flow')
    ->as('flow.')
    ->group(function () {
        Route::get('/set-target', 'setTargetIndex')->name('set-target');
        Route::get('/target-report', 'targetReportIndex')->name('target-report');
        Route::get('/progress-input', 'progressInputIndex')->name('progress-input');
        Route::get('/progress-report', 'progressReportIndex')->name('progress-report');
        Route::post('/progress-report-download', 'downloadProgressReport')->name('progress-report-download');
        Route::post('/target-report-download', 'downloadTargetReport')->name('target-report-download');
        Route::get('/pme-review', 'pmeReviewIndex')->name('pme-review');
        Route::get('/pme-final-report', 'pmeFinalReportIndex')->name('pme-final-report');
        Route::post('/pme-final-report-download', 'downloadPmeFinalReport')->name('pme-final-report-download');
    });




Route::controller(SetTargetController::class)
    ->prefix('set-target')
    ->as('set-target.')
    ->group(function () {
        Route::post('/lock', 'lockTarget')->name('lock');
        Route::post('/unlock', 'unLockTarget')->name('unlock');
        Route::post('/budget/add', 'addBudget')->name('budget.add');
        Route::post('/approved_cost/add', 'addApprovedCost')->name('approved_cost.add');
        Route::post('/contractual_cost/add', 'addContractualCost')->name('contractual_cost.add');
        Route::post('/aggrement_date/add', 'addAggrementDate')->name('aggrement_date.add');

        Route::delete('/milestone/{milestone_id}/delete', 'deleteMilestone')->name('milestone.delete');
        Route::delete('/activity/{activity_id}/delete', 'deleteActivity')->name('activity.delete');

        Route::post('/physical-progress/add', 'addPhysicalProgress')->name('physical-progress.add');

        Route::post('/delete-all-project-data', 'deleteAllProjectData')->name('delete-project-data');
    });

Route::controller(ProgressInputController::class)
    ->prefix('progress-input')
    ->as('progress-input.')
    ->group(function () {

        Route::post('/upload-attachment', 'progressInputUploadAttachment')->name('upload-attachment');

    });