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

use App\Http\Controllers\Admin\DisbursementController;
use App\Http\Controllers\Internal\InternalMainController;
use Illuminate\Support\Facades\Route;



/**************************** Routes For Disbursement ******************************/

Route::controller(DisbursementController::class)
    ->prefix('disbursements')
    ->as('disbursements.')
    ->group(function () {

        Route::get('/', 'disbursementsIndex')->name('index');
    });

// $route->get('/disbursements', [DisbursementController::class, 'index'])->name('disbursements.index');