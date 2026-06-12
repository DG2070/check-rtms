<?php
/*
 * Copyright © 2022 by SysQube Technology, All rights reserved.
 *
 * Author : Kishor Shrestha (winneecreztha@gmail.com)
 */

namespace App\Helper;

use Carbon\Carbon;

class QuaterFilter
{

    public $show_months = [];
    public $quater = [];

    public function __construct($selected_months = [])
    {
        if (count($selected_months) > 0) {
            foreach ($selected_months ?? [] as $month) {
                array_push($this->show_months, $month);
            }
        } else {
            if (!empty(request('selected_months')) && is_array(request('selected_months'))) {
                foreach (request('selected_months') ?? [] as $month) {
                    array_push($this->show_months, $month);
                }
            } else {
                $this->show_months = [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12];
            }
        }


        foreach ($this->show_months as $mnth) {
            switch ($mnth) {
                case 1:
                    array_push($this->quater, 'first');
                    break;
                case 2:
                    array_push($this->quater, 'first');
                    break;
                case 3:
                    array_push($this->quater, 'first');
                    break;
                case 4:
                    array_push($this->quater, 'second');
                    break;
                case 5:
                    array_push($this->quater, 'second');
                    break;
                case 6:
                    array_push($this->quater, 'second');
                    break;
                case 7:
                    array_push($this->quater, 'third');
                    break;
                case 8:
                    array_push($this->quater, 'third');
                    break;
                case 9:
                    array_push($this->quater, 'third');
                    break;
                case 10:
                    array_push($this->quater, 'fourth');
                    break;
                case 11:
                    array_push($this->quater, 'fourth');
                    break;
                case 12:
                    array_push($this->quater, 'fourth');
                    break;

                default:
                    # code...
                    break;
            }
        }
    }

    public function showMonths()
    {
        return $this->show_months;
    }
    public function quaters()
    {
        return $this->quater;
    }
    public function firstQuaterCount()
    {
        return count(array_keys($this->quater, 'first'));
    }
    public function secondQuaterCount()
    {
        return count(array_keys($this->quater, 'second'));
    }
    public function thirdQuaterCount()
    {
        return count(array_keys($this->quater, 'third'));
    }
    public function fourthQuaterCount()
    {
        return count(array_keys($this->quater, 'fourth'));
    }
    public function allQuaterCount()
    {
        return $this->firstQuaterCount() + $this->secondQuaterCount() + $this->thirdQuaterCount() + $this->fourthQuaterCount();
    }
}
