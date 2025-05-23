<?php

namespace App\View\Components;

use Illuminate\View\Component;

class StatisticCard extends Component
{
    public $label;
    public $value;

    public function __construct($label, $value)
    {
        $this->label = $label;
        $this->value = $value;
    }

    public function render()
    {
        return view('components.statistic-card');
    }
}
