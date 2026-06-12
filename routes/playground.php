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

use App\Http\Controllers\Playground\PlaygroundController;
use Illuminate\Support\Facades\Route;


/**************************** Routes For Playground **********************************/

Route::controller(PlaygroundController::class)
    ->middleware(["auth"])
    ->as('playground.')
    ->group(function () {
        Route::get('/playground/one', 'playgrounOne')->name('one');
    });