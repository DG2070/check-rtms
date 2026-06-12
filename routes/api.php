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
use App\Http\Controllers\Api\ApiController;
use Illuminate\Http\Request;
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


Route::controller(ApiController::class)
    ->group(function () {
        Route::get('/province/{province_code}/district', 'getDistrictForProvince');
        Route::post('/town-by-district-province', 'getTownForDistrictWithProvince');
        Route::post('/town-by-district', 'getTownForDistrict');
        Route::post('/project-stats-by-pdt', 'getProjectStatByPDT');
        Route::post('/project/{project_id}/update/ft-pt', 'updateProjectFtPt');

        Route::post('/set-target/{project_id}/upload-milestones', 'setTargetUploadMilestones');
    });