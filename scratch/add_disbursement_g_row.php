<?php

$file = 'resources/views/components/flow/progress-report-component.blade.php';
$content = file_get_contents($file);

// Add rowspan modification
$search1 = '<td rowspan="{{ $count * 2 }}" class="">{{ $project->Name }} [';
$replace1 = <<<HTML
@php
    \$hasDisbTarget = false;
    foreach (\$project->projectActivity as \$pa) {
        foreach (\$pa->milestone as \$m) {
            if (strtolower(trim(\$m->milestone)) == 'disbursement target') {
                \$hasDisbTarget = true;
                break 2;
            }
        }
    }
    \$totalRows = \$hasDisbTarget ? (\$count * 2) + 1 : (\$count * 2);
@endphp

                                    <td rowspan="{{ \$totalRows }}" class="">{{ \$project->Name }} [
HTML;
$content = str_replace($search1, $replace1, $content);

$search2 = '<td rowspan="{{ $count * 2 }}">';
$replace2 = '<td rowspan="{{ $totalRows }}">';
$content = str_replace($search2, $replace2, $content);

$search3 = '<td rowspan="{{ $count * 2 }}"class="number_ format">';
$replace3 = '<td rowspan="{{ $totalRows }}"class="number_ format">';
$content = str_replace($search3, $replace3, $content);

$search4 = '<td rowspan="{{ count($pro_act->milestone) * 2 }}" class="">';
$replace4 = <<<HTML
@php
    \$hasDisbTargetAct = false;
    foreach (\$pro_act->milestone as \$m) {
        if (strtolower(trim(\$m->milestone)) == 'disbursement target') {
            \$hasDisbTargetAct = true;
            break;
        }
    }
    \$actRows = \$hasDisbTargetAct ? (count(\$pro_act->milestone) * 2) + 1 : (count(\$pro_act->milestone) * 2);
@endphp
                                        <td rowspan="{{ \$actRows }}" class="">
HTML;
$content = preg_replace('/<td rowspan="\{\{ count\(\$pro_act->milestone\) \* 2 \}\}" class="">/', $replace4, $content, 1);

$search5 = '<td rowspan="{{ count($pro_act->milestone) * 2 }}" class="">';
$replace5 = '<td rowspan="{{ $actRows }}" class="">';
$content = str_replace($search5, $replace5, $content);

$search6 = '<td rowspan="2" class=" text-left"';
$replace6 = <<<HTML
@php
    \$mileRows = strtolower(trim(\$mile->milestone)) == 'disbursement target' ? 3 : 2;
@endphp
                                <td rowspan="{{ \$mileRows }}" class=" text-left"
HTML;
$content = preg_replace('/<td rowspan="2" class=" text-left"/', $replace6, $content, 1);
$content = preg_replace('/<td rowspan="2" class=" text-left"/', '<td rowspan="{{ $mileRows }}" class=" text-left"', $content, 1);

$search7 = '<td rowspan="2" style="min-width: 150px;">';
$replace7 = '<td rowspan="{{ $mileRows }}" style="min-width: 150px;">';
$content = str_replace($search7, $replace7, $content);

// Insert G row under P row
$search8 = '{{-- !ENDS timeline for progress --}}
                            </tr>';

$replace8 = <<<HTML
{{-- !ENDS timeline for progress --}}
                            </tr>

                            @if(strtolower(trim(\$mile->milestone)) == 'disbursement target')
                            @php
                                \$disbursement_data_by_month_g = \App\Helper\DisbursementFilter::disbursementsForProjectByFiscialYearG( "20".(\$fiscalYear ??'2078/2079'), \$programId, \$projectId);
                            @endphp
                            <tr>
                                <td @if (\$key2 % 2 == 0) style="background: aliceblue;" @endif>
                                    G
                                </td>
                                @for (\$i = 0; \$i < 12; \$i++)
                                    @if (in_array(array_keys(\$disbursement_data_by_month_g)[\$i], \$quaterfilter->showMonths()))
                                        <td style="{{ \$key2 % 2 == 0 ? 'background: aliceblue;' : '' }}">
                                            {{ \$disbursement_data_by_month_g[array_keys(\$disbursement_data_by_month_g)[\$i]] ?: '' }}
                                        </td>
                                    @endif
                                @endfor
                            </tr>
                            @endif
HTML;
$content = str_replace($search8, $replace8, $content);

file_put_contents($file, $content);

