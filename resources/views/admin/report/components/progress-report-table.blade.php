 @php
     $quaterfilter = new App\Helper\QuaterFilter();
 @endphp
 {{-- <div style="text-align: center;" class="m-4">
     <h2>{{ $program->NameLong }}</h2>
 </div> --}}
 <div id="main_content">

     <table border="1" id="report_table"
         class="table table-responsive custom-table fullscreen_table tdf-table-primary">
         <thead>
             <tr>
                 <th colspan="{{ 7 + 12 + 4 + 4 }}" class="text-center">
                     Town Development Fund <br>
                     Progress of Performance Monitoring Framework (PPMF) <br>
                     {{ $program->NameLong }} <br>
                     FY 20{{ $fiscalYear }} <br>
                 </th>
             </tr>
             <tr>
                 <th rowspan="3">Project Name</th>
                 <th colspan="2">Project status as of the end of FY
                     20{{ App\Helper\FiscalYear::previousFYFromGivenFY($fiscalYear) }}</th>
                 <th rowspan="3">Approved Budget FY 20{{ $fiscalYear }}</th>
                 <th rowspan="3">Main Activities (Total: target of this year)</th>
                 <th rowspan="3" colspan="2">Milestones</th>
                 <th colspan="{{ 4 + $quaterfilter->allQuaterCount() }}">
                     Timeline
                 </th>
                 <th rowspan="3">Performance Indicators</th>
                 <th colspan="2">Responsibility</th>
                 <th rowspan="3">Remarks</th>
                 {{-- <th rowspan="3" class="align-middle text-center">Attachment</th> --}}
             </tr>

             <tr>
                 <th rowspan="2">Physical</th>
                 <th rowspan="2">Financial</th>
                 @if ($quaterfilter->firstQuaterCount() > 0)
                     <th colspan="{{ $quaterfilter->firstQuaterCount() }}">1st Quarter </th>
                 @endif
                 @if ($quaterfilter->secondQuaterCount() > 0)
                     <th colspan="{{ $quaterfilter->secondQuaterCount() }}">2nd Quarter </th>
                 @endif
                 @if ($quaterfilter->thirdQuaterCount() > 0)
                     <th colspan="{{ $quaterfilter->thirdQuaterCount() }}">3rd Quarter </th>
                 @endif
                 @if ($quaterfilter->fourthQuaterCount() > 0)
                     <th colspan="{{ $quaterfilter->fourthQuaterCount() }}">4th Quarter </th>
                 @endif
                 <th colspan="4">Total </th>
                 <th rowspan="2">Main Responsibility</th>
                 <th rowspan="2">Supportive Responsibility</th>
             </tr>

             <tr>
                 @if (in_array(1, $quaterfilter->showMonths()))
                     <th>1</th>
                 @endif
                 @if (in_array(2, $quaterfilter->showMonths()))
                     <th>2</th>
                 @endif
                 @if (in_array(3, $quaterfilter->showMonths()))
                     <th>3</th>
                 @endif
                 @if (in_array(4, $quaterfilter->showMonths()))
                     <th>1</th>
                 @endif
                 @if (in_array(5, $quaterfilter->showMonths()))
                     <th>2</th>
                 @endif
                 @if (in_array(6, $quaterfilter->showMonths()))
                     <th>3</th>
                 @endif
                 @if (in_array(7, $quaterfilter->showMonths()))
                     <th>1</th>
                 @endif
                 @if (in_array(8, $quaterfilter->showMonths()))
                     <th>2</th>
                 @endif
                 @if (in_array(9, $quaterfilter->showMonths()))
                     <th>3</th>
                 @endif
                 @if (in_array(10, $quaterfilter->showMonths()))
                     <th>1</th>
                 @endif
                 @if (in_array(11, $quaterfilter->showMonths()))
                     <th>2</th>
                 @endif
                 @if (in_array(12, $quaterfilter->showMonths()))
                     <th>3</th>
                 @endif
                 <th>FT</th>
                 <th>FP</th>
                 <th>PT</th>
                 <th>PP</th>
             </tr>
         </thead>

         <tbody>
             @php
                 $counter = 1;
             @endphp
             @foreach ($program->project as $pro_key => $project)
                 @php $count = 0; @endphp
                 @foreach ($project->projectActivity as $pro_act)
                     @php $count += count($pro_act->milestone); @endphp
                 @endforeach
                 @foreach ($project->projectActivity as $key => $pro_act)
                     @foreach ($pro_act->milestone as $key2 => $mile)
                         <tr
                             @if ($key == 0 && $key2 == 0) style="border-top:1.5px solid #2969a2 !important" @endif>
                             @if ($key == 0 && $key2 == 0)
                                 <td rowspan="{{ $count * 2 }}" class="">{{ $project->Name }} [
                                     {{ $project->TownName }} ]</td>
                                 <td rowspan="{{ $count * 2 }}">
                                     {{ isset($project->projectDataSQ[0]->physical_progress) ? $project->projectDataSQ[0]->physical_progress . '%' : 'NA' }}
                                 </td>
                                 <td rowspan="{{ $count * 2 }}"class="number_ format">
                                     {{ \App\Helper\DisbursementFilter::totalDisbursementForProjectAsOfYear('20' . App\Helper\FiscalYear::previousFYFromGivenFY($fiscalYear), $project->programID, $project->projectID) }}
                                 </td>

                                 {{-- Approved Budget FY --}}
                                 <td rowspan="{{ $count * 2 }}">
                                     {{ isset($project->projectDataSQ[0]->approved_budget) ? $project->projectDataSQ[0]->approved_budget : 'NA' }}
                                 </td>
                             @endif

                             @if ($key2 == 0)
                                 <td rowspan="{{ count($pro_act->milestone) * 2 }}" class="">
                                     {{ $pro_act->activity }}</td>
                             @endif

                             <td rowspan="2" class=" text-left"
                                 style="min-width: 200px;max-width: 200px;padding: 0px !important; padding-left:10px!important;@if ($key2 % 2 == 0) background: aliceblue; @endif">
                                 {{ $mile->milestone }}
                             </td>

                             <td @if ($key2 % 2 == 0) style="background: aliceblue;" @endif>
                                 T
                             </td>

                             {{-- timeline for target --}}
                             @if ($mile->timeline)
                                 @foreach ($mile->timeline->timeline ?? [] as $timeline_month => $time)
                                     @if (in_array($timeline_month, $quaterfilter->showMonths()))
                                         @if ($mile->is_text == 'yes')
                                             <td style="{{ $key2 % 2 == 0 ? 'background: aliceblue;' : '' }}">
                                                 {{ $time }}
                                             </td>
                                         @else
                                             <td style="{{ $key2 % 2 == 0 ? 'background: aliceblue;' : '' }}">
                                                 @if ($time)
                                                     <div class="tdf-progress-input-target-box--small">
                                                     </div>
                                                 @endif
                                             </td>
                                         @endif
                                     @endif
                                 @endforeach
                             @else
                                 @for ($i = 0; $i < 12; $i++)
                                     @if (in_array($i, $quaterfilter->showMonths()))
                                         <td style="{{ $key2 % 2 == 0 ? 'background: aliceblue;' : '' }}">
                                         </td>
                                     @endif
                                 @endfor
                             @endif
                             {{-- !ENDS timeline for target --}}

                             @if ($key == 0 && $key2 == 0)
                                 {{-- FT --}}
                                 <td rowspan="{{ $count * 2 }}">
                                     {{ isset($project->projectDataSQ[0]->FT) ? $project->projectDataSQ[0]->FT : 'NA' }}
                                 </td>
                                 {{-- FP --}}
                                 <td rowspan="{{ $count * 2 }}">
                                     {{ isset($project->projectDataSQ[0]->FP) ? $project->projectDataSQ[0]->FP : 'NA' }}
                                 </td>
                                 {{-- PT --}}
                                 <td rowspan="{{ $count * 2 }}">
                                     {{ isset($project->projectDataSQ[0]->PT) ? $project->projectDataSQ[0]->PT : 'NA' }}
                                 </td>
                                 {{-- PP --}}
                                 <td rowspan="{{ $count * 2 }}">
                                     {{ isset($project->projectDataSQ[0]->PP) ? $project->projectDataSQ[0]->PP : 'NA' }}
                                 </td>
                             @endif

                             {{-- performance_indicator --}}
                             <td rowspan="2" class=" text-left" style="min-width: 200px;max-width: 200px">
                                 {{ $mile->performance_indicator }}
                             </td>

                             @if ($key2 == 0)
                                 <td rowspan="{{ count($pro_act->milestone) * 2 }}" class="">
                                     <div class="d-flex flex-wrap">
                                         @foreach (\App\Models\User::whereIn('id', $pro_act->main_responsibility ?? [])->get() as $user)
                                             <div>
                                                 {{ $user->name }}
                                                 @if (!$loop->last)
                                                     ,
                                                 @endif
                                             </div>
                                         @endforeach
                                     </div>
                                 </td>
                                 <td rowspan="{{ count($pro_act->milestone) * 2 }}" class="">
                                     <div class="d-flex flex-wrap">
                                         @foreach (\App\Models\User::whereIn('id', $pro_act->supportive_responsibility ?? [])->get() as $user)
                                             <div>
                                                 {{ $user->name }}
                                                 @if (!$loop->last)
                                                     ,
                                                 @endif
                                             </div>
                                         @endforeach
                                     </div>
                                 </td>
                                 {{-- <td rowspan="{{ count($pro_act->milestone) }}" class="">
                                        {{ $pro_act->remark }}
                                    </td> --}}
                             @endif
                             <td rowspan="2" style="min-width: 150px;">
                                 {{ $mile->remark }}
                             </td>
                             {{-- <td rowspan="2">
                                 <div class="text-center d-flex justify-content-center">
                                     @if (!empty($mile->attachment) && $mile->attachment != '')
                                         <a href="/uploads/attachments/{{ $mile->attachment }}" target="_blank"
                                             class="btn btn-primary mr-2 tdf-border-small btn-tdf-primary">
                                             <i class="nav-icon fas fa-eye"></i>
                                         </a>
                                     @else
                                         NA
                                     @endif
                                 </div>
                             </td> --}}

                         </tr>

                         <tr>
                             <td @if ($key2 % 2 == 0) style="background: aliceblue;" @endif>
                                 P
                             </td>
                             {{-- timeline  for progress --}}
                             @if ($mile->timeline)
                                 @foreach ($mile->timeline->timeline ?? [] as $timeline_month => $time)
                                     @if (in_array($timeline_month, $quaterfilter->showMonths()))
                                         @if ($mile->is_text == 'yes')
                                             <td style="{{ $key2 % 2 == 0 ? 'background: aliceblue;' : '' }}">
                                                 {{ $mile->timeline->progress_input_data[$loop->index + 1] ?? '' }}
                                             </td>
                                         @else
                                             <td style="{{ $key2 % 2 == 0 ? 'background: aliceblue;' : '' }}">
                                                 <input style="min-width: 25px;height: 25px;padding: 0px !important"
                                                     class="form-control p-0 {{ isset($mile->timeline->progress_input_data[$loop->index + 1]) && $mile->timeline->progress_input_data[$loop->index + 1] == 1 ? '' : 'd-none' }}"
                                                     type="checkbox" readonly onclick="return false;"
                                                     {{ isset($mile->timeline->progress_input_data[$loop->index + 1]) && $mile->timeline->progress_input_data[$loop->index + 1] == 1 ? 'checked' : '' }}
                                                     data-toggle="tooltip" data-placement="top"
                                                     title="{{ isset($mile->timeline->remarks[$loop->index + 1]) ? $mile->timeline->remarks[$loop->index + 1] : '' }}">
                                             </td>
                                         @endif
                                     @endif
                                 @endforeach
                             @else
                                 @for ($i = 0; $i < 12; $i++)
                                     @if (in_array($i, $quaterfilter->showMonths()))
                                         <td style="{{ $key2 % 2 == 0 ? 'background: aliceblue;' : '' }}">
                                         </td>
                                     @endif
                                 @endfor
                             @endif
                             {{-- !ENDS timeline for progress --}}
                         </tr>
                     @endforeach

         </tbody>
         @endforeach
         @php
             $counter++;
         @endphp
         @endforeach
     </table>

 </div>

 @push('script')
     <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js" crossorigin="anonymous"></script>
     <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"
         integrity="sha512-BNaRQnYJYiPSqHHDb58B0yaPfCu+Wgds8Gp/gU33kqBtgNS4tSPHuGibyoeqMV/TJlSKda6FXzoEyYGjTe+vXA=="
         crossorigin="anonymous" referrerpolicy="no-referrer"></script>
     <script src="https://cdnjs.cloudflare.com/ajax/libs/dom-to-image/2.6.0/dom-to-image.min.js"
         integrity="sha512-01CJ9/g7e8cUmY0DFTMcUw/ikS799FHiOA0eyHsUWfOetgbx/t6oV4otQ5zXKQyIrQGTHSmRVPIgrgLcZi/WMA=="
         crossorigin="anonymous" referrerpolicy="no-referrer"></script>
 @endpush
