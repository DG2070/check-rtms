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

use App\Http\Controllers\Internal\InternalMainController;
use Illuminate\Support\Facades\Route;



/**************************** Routes For Settings **********************************/

Route::controller(InternalMainController::class)
    ->prefix('internal')
    ->as('internal.')
    ->group(function () {

        //Exports
        Route::get('/project/export-progress-report', 'exportProgressReport')->name('project.single.export.progress-report');
        Route::get('/project/export-pme-final-report', 'exportPmeFinalReport')->name('project.single.export.pme-final-report');


        Route::get('/projects', 'projectsIndex')->name('project.index');
        Route::post('/project', 'createProject')->name('project.store');
        Route::put('/project', 'updateProject')->name('project.update');
        Route::delete('/project/{internalProject}', 'deleteProject')->name('project.delete');
        Route::get('/project/{project_id}', 'singleProjectIndex')->name('project.single.index');
        Route::post('/project/activities-milestones/create', 'createActivitiesMilestones')->name('project.single.milestone.create');
        Route::post('/project/activities-milestones/update', 'updateActivitiesMilestones')->name('project.single.milestone.update');
        Route::delete('/project/activities-milestones/{internal_project_data_id}/delete', 'deleteActivitiesMilestones')->name('project.single.milestone.delete');
        Route::post('/project/activities-milestones/timeline_target/update', 'updateActivitiesMilestonesTimelineTarget')->name('project.single.milestone.timeline_target.update');
        Route::post('/project/pme-review/update', 'updatePmeReview')->name('project.single.pme-review.update');
        Route::post('/project/progress-input/timline-progress/update', 'updateTProgressInputimelineProgress')->name('project.single.progress-input.timeline-progress');
        Route::post('/project/progress-input/timline-progress/remarks/update', 'storeProgressInputMilestoneProgressRemark')->name('project.single.progress-input.timeline-progress.remarks');
        Route::post("/target-pdf/download", "pdfTargetReport")->name("printTargetReport");
        Route::post("/progress-pdf/download", "pdfProgressReport")->name("printProgressReport");
        Route::post("/pme-final-report-pdf/download", "printPmeFinalReport")->name("printPmeFinalReport");
    });
