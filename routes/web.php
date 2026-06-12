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
use App\Http\Controllers\Auth\ProfileController;
use App\Http\Controllers\Admin\{
    ActivityController,
    DisbursementController,
    LocationController,
    ProgramController,
    ProjectController,
    ReportController,
    SearchController
};
use App\Http\Controllers\Admin\Program\AjaxController;
use App\Http\Controllers\Permission\{RoleController, UserController};
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return redirect()->route('login');
});

// Auth::routes(['except' => ['register']]);
Auth::routes();

Route::group(['middleware' => ['auth']], function ($route) {

    $route->get('/home', [App\Http\Controllers\HomeController::class, 'index'])
        ->name('home');
    $route->get('/home/reports', [App\Http\Controllers\HomeController::class, 'homeReports'])
        ->name('home.reports');

    $route->get('/profile/reset-password', [ProfileController::class, 'resetPassword'])
        ->name('profile.reset-password');

    $route->post('/profile/update-password', [ProfileController::class, 'updatePassword'])
        ->name('profile.update-password');

    $route->get('/profile/profile', [ProfileController::class, 'profile'])
        ->name('profile.profile');

    $route->post('/profile/update-profile', [ProfileController::class, 'updateProfile'])
        ->name('profile.update-profile');

    /****************************** Routes For Program Controller ********************************/
    $route->get("/programs", [ProgramController::class, "index"])->name("programs.index");
    $route->get("/programs/new", [ProgramController::class, "newProgramIndex"])->name("programs.new");
    $route->get("/programs/{program}", [ProgramController::class, "show"])->name("programs.show");

    $route->post("/programs/new", [ProgramController::class, "addNewProgram"])->name("programs.store");
    $route->delete("/programs/{id}", [ProgramController::class, "softDeleteProgram"])->name("programs.delete");

    $route->post("/programs/new/progress-input/timeline/store", [ProjectController::class, "storeProgressInputMilestoneProgress"])
        ->name("programs.progress-input-milestone-progress.store");

    $route->post("/programs/new/progress-input/timeline/remark/store", [ProjectController::class, "storeProgressInputMilestoneProgressRemark"])
        ->name("programs.progress-input.milestone-progress.remark.store");
    $route->post("/programs/new/progress-input/milestone/remark/store", [ProjectController::class, "storeProgressInputMilestoneRemark"])
        ->name("programs.progress-input.milestone.remark.store");


    /*****************************Routes For Project Controller *********************************/
    $route->get('/projects', [ProjectController::class, 'index'])->name('projects.index');

    $route->post("/projects/new", [ProjectController::class, "addNewProject"])->name("projects.store");
    $route->delete("/projects/{id}", [ProjectController::class, "softDeleteProject"])->name("projects.delete");


    $route->get("/projects/{id}/physical-progress", [ProjectController::class, "physicalProgress"])
        ->name("project.physicalProgress");


    $route->get("/projects/{id}/physical-progress/create", [ProjectController::class, "createPhysicalProgress"])
        ->name("project.createPhysicalProgress");


    $route->post("/projects/{id}/physical-progress/create", [ProjectController::class, "storePhysicalProgress"])
        ->name("project.physicalProgress.store");


    $route->get("/projects/{id}/physical-progress/{progress}/edit", [ProjectController::class, "editPhysicalProgress"])
        ->name("project.physicalProgress.edit");


    $route->post("/projects/{id}/physical-progress/{progress}/update", [ProjectController::class, "updatePhysicalProgress"])
        ->name("project.physicalProgress.update");


    $route->get("/projects/{id}/input-program-report/create", [ProjectController::class, "createInputProgramReport"])
        ->name("project.inputProgramReport.create");

    /* Main Activities */
    $route->post("/projects/{id}/main-activity/store", [ProjectController::class, "storeMainActivity"])
        ->name("project.mainActivity.store");


    $route->post("/projects/{id}/main-activity/update/{activity_id}", [ProjectController::class, "updateMainActivity"])
        ->name("project.mainActivity.update");

    // $route->delete("/projects/activity/delete/{activity_id}", [ProjectController::class, "deleteActivity"])
    //     ->name("project.activity.delete");

    /* Milestones */
    $route->post("/projects/{id}/milestone/store", [ProjectController::class, "storeMilestone"])
        ->name("project.milestone.store");

    $route->post("/projects/{id}/milestone/update/{milestone_id}", [ProjectController::class, "updateMilestone"])
        ->name("project.milestone.update");


    $route->get("/projects/{id}/input-program-report/show", [ProjectController::class, "showInputProgramReport"])
        ->name("project.inputProgramReport.show");


    $route->get("/projects/{id}/progress-report-performance", [ProjectController::class, "projectReportPerformance"])
        ->name("project.progress.report.performance");

    /**Province */
    $route->get("/projects/province/{province_code}", [ProjectController::class, "showProjectListByProvince"])
        ->name("project.province.show");



    /************************************** Timelines ******************************************/
    $route->post("/projects/{id}/timeline/store", [ProjectController::class, "storeTimeline"])
        ->name("project.timeline.store");

    $route->get("/projects/{id}/review", [ProjectController::class, "reviewProjectMilestone"])
        ->name("project.milestone.review");

    $route->post("/projects/{id}/review/store", [ProjectController::class, "storeProjectMilestoneReview"])
        ->name("project.milestone.review.store");


    /*************************** Progress Review Report *************************/
    $route->get("/progress/report", [ProgramController::class, "progressReportFilter"])
        ->name("progress.report.filter");

    $route->post("/progress/report/download", [ReportController::class, "progressReportDownload"])
        ->name("progress.report.download");

    $route->get("/download-progress-report", [ProgramController::class, "downloadProgressReport"])
        ->name("download.progress.report");

    $route->post("/down-p", [ProgramController::class, "downloadFile"])->name("download");

    $route->get("/export-progress-report", [ProgramController::class, "exportProgressReport"])
        ->name("export.progress.report");


    /*************************** PME Review Report *************************/
    $route->get("/pme-review/report", [ProgramController::class, "pmeReviewReportFilter"])
        ->name("pme.report.filter");

    $route->post("/pme-review/report/download", [ReportController::class, "pmeReviewReportDownload"])
        ->name("pme.report.download");

    $route->get("/download-pme-report", [ProgramController::class, "downloadPMEReport"])
        ->name("download.pme.report");

    $route->get("/export-pme-report", [ProgramController::class, "exportPMEReport"])
        ->name("export.pme.report");


    /**************************** Routes For Activities Controller *******************************/
    //TODO: remove this (belongs to disbursement section on sidenav / commented)
    $route->get('/activities', [ActivityController::class, 'index'])->name('activities.index');



    /**************************** Routes For Location Controller **********************************/
    $route->get('/locations', [LocationController::class, 'index'])->name('locations.index');


    // Physical Progress
    $route->get('/physical-progress', [DisbursementController::class, 'physicalProgress'])
        ->name('admin.physicalProgress');

    $route->get('/program-report-performance', [DisbursementController::class, 'programReportPerformanceport'])
        ->name('admin.programReportPerformanceport');

    $route->get('/progress-report-performance', [DisbursementController::class, 'progressReportPerformance'])
        ->name('admin.progressReportPerformance');

    $route->get('/program-report-input', [DisbursementController::class, 'programReportInput'])
        ->name('admin.programReportInput');

    $route->get('/progress-report-input', [DisbursementController::class, 'progressReprogressReportInput'])
        ->name('admin.progressReprogressReportInput');




    /**************************** Routes For Search Controller **********************************/
    Route::controller(SearchController::class)
        ->prefix('search')
        ->as('search.')
        ->group(function () {
            Route::get('', 'index')->name('index');
        });

    $route->get('/about', [App\Http\Controllers\HomeController::class, 'aboutIndex'])
        ->name('about.index');


    /**************************** Routes For New Program AJAX View Controller **********************************/
    Route::controller(AjaxController::class)
        ->prefix('ajax')
        ->as('ajax.')
        ->group(function () {
            Route::post('/view/activity-milestone', 'activityMilestoneView')->name('view.activity-milestone');
        });

    $route->resource('roles', RoleController::class)->except(['show']);

    $route->resource('users', UserController::class)->except(['show']);

    // disbursement Routes
    require __DIR__ . '/disbursement.php';

    // Settings Routes
    require __DIR__ . '/settings.php';

    // FLow Routes
    require __DIR__ . '/flow.php';

    // Internal Routes
    require __DIR__ . '/internal.php';
});

// Playground Routes
require __DIR__ . '/playground.php';


// Route::get('/map', function () {
//     return view("home.maps.district");
// });

// Route::get('/trash/playground', [TrashController::class, "index"]);