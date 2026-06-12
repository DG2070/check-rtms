 <div>
     <table border="1">
         <thead style="background: #2767a0;color:white;">
             <tr>
                 <th colspan="{{ 4 + $quaterfilter->allQuaterCount() + 7 }}"
                     style="text-align: center; vertical-align: center; background-color: #2767a0;color:white;">
                     <div>
                         Town Development Fund
                     </div>
                     <br style="mso-data-placement:same-cell;" />
                     <div>
                         Performance Monitoring Framework (PMF)
                     </div>
                     <br style="mso-data-placement:same-cell;" />
                     <div>
                         {{ $project->name ?? '' }}
                     </div>
                     <br style="mso-data-placement:same-cell;" />
                     <div>
                         FY 2079/80
                     </div>
                 </th>
             </tr>


             <tr>
                 <th rowspan="3"
                     style="text-align: center; vertical-align: center; background-color: #2767a0;color:white;word-wrap:break-word;">
                     S.N</th>
                 <th rowspan="3"
                     style="text-align: center; vertical-align: center; background-color: #2767a0;color:white;word-wrap:break-word;">
                     Approved Budget FY 2078/79</th>
                 <th rowspan="3" colspan="2"
                     style="text-align: center; vertical-align: center; background-color: #2767a0;color:white;word-wrap:break-word;">
                     Activities/Milestones</th>
                 <th colspan="{{ $quaterfilter->allQuaterCount() }}"
                     style="text-align: center; vertical-align: center; background-color: #2767a0;color:white;word-wrap:break-word;">
                     Timeline
                 </th>
                 <th rowspan="3"
                     style="text-align: center; vertical-align: center; background-color: #2767a0;color:white;word-wrap:break-word;">
                     Performance Indicators</th>
                 <th rowspan="3"
                     style="text-align: center; vertical-align: center; background-color: #2767a0;color:white;word-wrap:break-word;">
                     Progress</th>
                 <th colspan="2"
                     style="text-align: center; vertical-align: center; background-color: #2767a0;color:white;word-wrap:break-word;">
                     PME Review</th>
                 <th rowspan="3"
                     style="text-align: center; vertical-align: center; background-color: #2767a0;color:white;word-wrap:break-word;">
                     Main Responsibility</th>
                 <th rowspan="3"
                     style="text-align: center; vertical-align: center; background-color: #2767a0;color:white;word-wrap:break-word;">
                     Supportive Responsibility</th>
                 <th rowspan="3"
                     style="text-align: center; vertical-align: center; background-color: #2767a0;color:white;word-wrap:break-word;">
                     Remarks</th>
             </tr>

             <tr>
                 @if ($quaterfilter->firstQuaterCount() > 0)
                     <th colspan="{{ $quaterfilter->firstQuaterCount() }}"
                         style="text-align: center; vertical-align: center;background-color: #2767a0;color:white;">1st
                         Quarter </th>
                 @endif
                 @if ($quaterfilter->secondQuaterCount() > 0)
                     <th colspan="{{ $quaterfilter->secondQuaterCount() }}"
                         style="text-align: center; vertical-align: center;background-color: #2767a0;color:white;">2nd
                         Quarter </th>
                 @endif
                 @if ($quaterfilter->thirdQuaterCount() > 0)
                     <th colspan="{{ $quaterfilter->thirdQuaterCount() }}"
                         style="text-align: center; vertical-align: center;background-color: #2767a0;color:white;">3rd
                         Quarter </th>
                 @endif
                 @if ($quaterfilter->fourthQuaterCount() > 0)
                     <th colspan="{{ $quaterfilter->fourthQuaterCount() }}"
                         style="text-align: center; vertical-align: center;background-color: #2767a0;color:white;">4th
                         Quarter </th>
                 @endif

                 <th rowspan="2"
                     style="text-align: center; vertical-align: center;background-color: #2767a0;color:white;">Achived
                 </th>
                 <th rowspan="2"
                     style="text-align: center; vertical-align: center;background-color: #2767a0;color:white;">Not
                     Achived</th>
             </tr>

             <tr>
                 @if (in_array(1, $quaterfilter->showMonths()))
                     <th style="text-align: center; vertical-align: center;background-color: #2767a0;color:white;">1
                     </th>
                 @endif
                 @if (in_array(2, $quaterfilter->showMonths()))
                     <th style="text-align: center; vertical-align: center;background-color: #2767a0;color:white;">2
                     </th>
                 @endif
                 @if (in_array(3, $quaterfilter->showMonths()))
                     <th style="text-align: center; vertical-align: center;background-color: #2767a0;color:white;">3
                     </th>
                 @endif
                 @if (in_array(4, $quaterfilter->showMonths()))
                     <th style="text-align: center; vertical-align: center;background-color: #2767a0;color:white;">1
                     </th>
                 @endif
                 @if (in_array(5, $quaterfilter->showMonths()))
                     <th style="text-align: center; vertical-align: center;background-color: #2767a0;color:white;">2
                     </th>
                 @endif
                 @if (in_array(6, $quaterfilter->showMonths()))
                     <th style="text-align: center; vertical-align: center;background-color: #2767a0;color:white;">3
                     </th>
                 @endif
                 @if (in_array(7, $quaterfilter->showMonths()))
                     <th style="text-align: center; vertical-align: center;background-color: #2767a0;color:white;">1
                     </th>
                 @endif
                 @if (in_array(8, $quaterfilter->showMonths()))
                     <th style="text-align: center; vertical-align: center;background-color: #2767a0;color:white;">2
                     </th>
                 @endif
                 @if (in_array(9, $quaterfilter->showMonths()))
                     <th style="text-align: center; vertical-align: center;background-color: #2767a0;color:white;">3
                     </th>
                 @endif
                 @if (in_array(10, $quaterfilter->showMonths()))
                     <th style="text-align: center; vertical-align: center;background-color: #2767a0;color:white;">1
                     </th>
                 @endif
                 @if (in_array(11, $quaterfilter->showMonths()))
                     <th style="text-align: center; vertical-align: center;background-color: #2767a0;color:white;">2
                     </th>
                 @endif
                 @if (in_array(12, $quaterfilter->showMonths()))
                     <th style="text-align: center; vertical-align: center;background-color: #2767a0;color:white;">3
                     </th>
                 @endif
             </tr>
         </thead>

         <tbody>


             @if (!empty($project_datas))
                 @foreach ($project_datas as $item)
                     <tr>
                         <td rowspan="2" style="text-align: center; vertical-align: center;">{{ $loop->index + 1 }}
                         </td>
                         <td rowspan="2" style="text-align: left;">
                             {{ $item->approved_budget }}</td>
                         <td rowspan="2" style="text-align: left; vertical-align: center;word-wrap:break-word;">
                             {{ $item->activity_milestone }}</td>
                         <td>
                             T
                         </td>
                         {{-- timeline_target --}}
                         @if (!empty($item->timeline_target))
                             @foreach ($item->timeline_target ?? [] as $timeline_month => $time)
                                 @if (in_array($timeline_month, $quaterfilter->showMonths()))
                                     @if ($item->is_text == 'yes')
                                         <td style="text-align: center; vertical-align: center;">
                                             {{ $time }}
                                         </td>
                                     @else
                                         <td @if ($time) style="background: #28a745;" @endif>


                                         </td>
                                     @endif
                                 @endif
                             @endforeach
                         @else
                             @for ($i = 0; $i < 12; $i++)
                                 @if (in_array($i, $quaterfilter->showMonths()))
                                     <td>

                                     </td>
                                 @endif
                             @endfor
                         @endif
                         {{-- !ENDS timeline_target --}}
                         <td rowspan="2" style="text-align: left; vertical-align: center;word-wrap:break-word;">
                             {{ $item->performance_indicator }}</td>

                         <td rowspan="2" style="text-align: left; vertical-align: center;word-wrap:break-word;">
                             {{ isset($item->progress) ? $item->progress : '' }}
                         </td>

                         <td rowspan="2" style="text-align: left; vertical-align: center;">
                             {{ isset($item->pme_target_review) && $item->pme_target_review == 'achived' ? '✓' : '' }}

                         </td>
                         <td rowspan="2" style="text-align: left; vertical-align: center;">
                             {{ isset($item->pme_target_review) && $item->pme_target_review == 'not_achived' ? '✓' : '' }}

                         </td>

                         <td rowspan="2" style="text-align: center; vertical-align: center;word-wrap:break-word;">
                             @foreach (\App\Models\User::whereIn('id', $item->main_responsibility ?? [])->get() as $user)
                                 <div>
                                     {{ $user->name }}
                                     @if (!$loop->last)
                                         ,
                                     @endif
                                 </div>
                             @endforeach
                         </td>
                         <td rowspan="2" style="text-align: center; vertical-align: center;word-wrap:break-word;">
                             @foreach (\App\Models\User::whereIn('id', $item->supportive_responsibility ?? [])->get() as $user)
                                 <div>
                                     {{ $user->name }}
                                     @if (!$loop->last)
                                         ,
                                     @endif
                                 </div>
                             @endforeach
                         </td>
                         <td rowspan="2" style="text-align: left; vertical-align: center;word-wrap:break-word;">
                             {{ $item->pme_target_remarks }}</td>

                     </tr>
                     <tr>
                         <td>P</td>
                         {{-- timeline  for progress --}}
                         @if ($item->timeline_progress)
                             @foreach ($item->timeline_progress ?? [] as $timeline_month => $time)
                                 @if (in_array($timeline_month, $quaterfilter->showMonths()))
                                     @if ($item->is_text == 'yes')
                                         <td style="text-align: center; vertical-align: center;">
                                             {{ $item->timeline_progress[$loop->index + 1] ?? '' }}
                                         </td>
                                     @else
                                         <td style="text-align: center">
                                             {{ isset($item->timeline_progress[$loop->index + 1]) && $item->timeline_progress[$loop->index + 1] == 1 ? '✓' : '' }}
                                         </td>
                                     @endif
                                 @endif
                             @endforeach
                         @else
                             @for ($i = 0; $i < 12; $i++)
                                 @if (in_array($i, $quaterfilter->showMonths()))
                                     <td>
                                     </td>
                                 @endif
                             @endfor
                         @endif
                         {{-- !ENDS timeline for progress --}}

                     </tr>
                 @endforeach
             @endif


         </tbody>
     </table>
 </div>
