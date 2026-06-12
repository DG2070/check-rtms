 <tr>
     <td>{{ $loop->iteration }}</td>

     <td>{{ $project['Name'] }}</td>

     <td>{{ $project['TownName'] }}</td>

     <td>
         <div class="table-progress mb-2">
             <div class="progress">
                 <div class="progress-bar bg-success" role="progressbar"
                     style="width: {{ $project->lastDisbursement->DisbursementPercentage ?? 0 }}%;"
                     aria-valuenow="{{ $project->lastDisbursement->DisbursementPercentage ?? 0 }}" aria-valuemin="0"
                     aria-valuemax="100">
                 </div>
             </div>
             <span class="progress-des">
                 <strong>Financial</strong>{{ floor($project->lastDisbursement->DisbursementPercentage ?? 0) }}%
             </span>
         </div>
         <div class="table-progress mb-2">
             <div class="progress">
                 <div class="progress-bar bg-success" role="progressbar"
                     style="width: {{ $project->lastprogress->physical_progress ?? 0 }}%;"
                     aria-valuenow="{{ $project->lastprogress->physical_progress ?? 0 }}" aria-valuemin="0"
                     aria-valuemax="100">
                 </div>
             </div>
             <span class="progress-des">
                 <strong>Physical</strong>{{ floor($project->lastprogress->physical_progress ?? 0) }}%
             </span>
         </div>
         <div class="table-progress mb-2">
             <div class="progress">
                 <div class="progress-bar bg-success" role="progressbar" style="width: 0%;" aria-valuenow="0"
                     aria-valuemin="0" aria-valuemax="100">
                 </div>
             </div>
             <span class="progress-des">
                 <strong>Target</strong>0%
             </span>
         </div>
     </td>
 </tr>
