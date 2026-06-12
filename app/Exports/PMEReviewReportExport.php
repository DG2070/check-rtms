<?php

namespace App\Exports;

use App\Helper\QuaterFilter;
use App\Models\Program;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Collection;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\WithEvents;
// use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class PMEReviewReportExport implements FromView, WithEvents
// , ShouldAutoSize
{
    protected $program;
    protected $selected_months;
    protected $for_single_project;


    public function __construct(Program $program, $selected_months)
    {
        $this->program = $program;
        $this->selected_months = $selected_months;
        $this->for_single_project = false;

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

        return view('admin.excel.pme-review-report', [
            'program' => $this->program,
            "quaterfilter" => $quaterfilter,
            "for_single_project" => $this->for_single_project,

        ]);
    }

    /**
     * Write code on Method
     *
     * @return response()
     */
    public function registerEvents(): array
    {
        return [
            AfterSheet::class    => function (AfterSheet $event) {
                $event->sheet->getDelegate()->getStyle('A1:M2')
                    ->getAlignment()
                    ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

                $event->sheet->getDelegate()->getRowDimension('1')->setRowHeight(90);
                $event->sheet->getDelegate()->getRowDimension('2')->setRowHeight(50);

                $event->sheet->getDelegate()->getColumnDimension('A')->setWidth(15);
                $event->sheet->getDelegate()->getColumnDimension('E')->setWidth(15);
                $event->sheet->getDelegate()->getColumnDimension('F')->setWidth(25);
                $event->sheet->getColumnDimension('G')->setAutoSize(true);
                $event->sheet->getColumnDimension('C')->setAutoSize(true);
            },
        ];
    }
}
