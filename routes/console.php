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
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

/*
|--------------------------------------------------------------------------
| Console Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of your Closure based console
| commands. Each Closure is bound to a command instance allowing a
| simple approach to interacting with each command's IO methods.
|
*/

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');