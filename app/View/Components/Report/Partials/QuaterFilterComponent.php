<?php

namespace App\View\Components\Report\Partials;

use App\Helper\QuaterFilter;
use Illuminate\View\Component;

class QuaterFilterComponent extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        $quaterfilter = new QuaterFilter();

        return view('components.report.partials.quater-filter-component',[
            "quaterfilter"=>$quaterfilter
        ]);
    }
}
