<?php

namespace App\Exports;

use App\Helper\QuaterFilter;
use App\Models\Program;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Collection;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class ProgressReportExport implements FromView, WithEvents
// , ShouldAutoSize
{
    protected $program;
    protected $selected_months;
    protected $is_target_report;
    protected $for_single_project;

    public function __construct(Program $program, $selected_months)
    {
        $this->program = $program;
        $this->selected_months = $selected_months;
        $this->is_target_report = false;
        $this->for_single_project = false;

        if (!empty(request("is_target_report")) && request("is_target_report") == "yes") {
            $this->is_target_report = true;
        }
        if (!empty(request("project")) && request("project") != "") {
            $this->for_single_project = true;
        }
        if (!empty(request("projectID")) && request("projectID") != "") {
            $this->for_single_project = true;
        }
    }

    public function view(): View
    {

        $quaterfilter = new QuaterFilter($this->selected_months);



        return view('admin.excel.progress-report', [
            'program' => $this->program,
            "quaterfilter" => $quaterfilter,
            "is_target_report" => $this->is_target_report,
            "for_single_project" => $this->for_single_project,

        ]);
    }

    /**
     * Write code on Method
     *
     * @return response()
     *
     * https://laraveldaily.com/laravel-excel-export-formatting-and-styling-cells/
     */
    public function registerEvents(): array
    {
        return [
            AfterSheet::class    => function (AfterSheet $event) {
                $event->sheet->getDelegate()->getStyle('A1:Y3')
                    ->getAlignment()
                    ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

                $event->sheet->getDelegate()->getRowDimension('1')->setRowHeight(90);
                $event->sheet->getDelegate()->getRowDimension('2')->setRowHeight(50);

                // $event->sheet->getColumnDimension('A')->setAutoSize(false);


                $event->sheet->getDelegate()->getColumnDimension('A')->setWidth(15);
                $event->sheet->getDelegate()->getColumnDimension('E')->setWidth(15);
                $event->sheet->getDelegate()->getColumnDimension('F')->setWidth(25);
                $event->sheet->getColumnDimension('G')->setAutoSize(true);
                $event->sheet->getColumnDimension('C')->setAutoSize(true);



                // $event->sheet->getDelegate()->getColumnDimension('B')->setWidth(50);
                // $event->sheet->getDelegate()->getColumnDimension('C')->setWidth(50);

                // $event->sheet->getDelegate()->getColumnDimension('A')->setWidth(50);
                // $event->sheet->getDelegate()->getColumnDimension('B')->setWidth(25);
                // $event->sheet->getDelegate()->getColumnDimension('C')->setWidth(25);
                // $event->sheet->getDelegate()->getColumnDimension('D')->setWidth(25);
                // $event->sheet->getDelegate()->getColumnDimension('E')->setWidth(50);
                // $event->sheet->getDelegate()->getColumnDimension('F')->setWidth(50);
                // $event->sheet->getDelegate()->getColumnDimension('X')->setWidth(50);
                // $event->sheet->getDelegate()->getColumnDimension('Y')->setWidth(25);
                // $event->sheet->getDelegate()->getColumnDimension('Z')->setWidth(25);
                // $event->sheet->getDelegate()->getColumnDimension('AA')->setWidth(50);


                // $event->sheet->getDelegate()->getStyle('A1:Y1')->getFont()->setSize(14);
            },
        ];
    }
}
