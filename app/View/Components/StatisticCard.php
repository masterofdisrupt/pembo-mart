<?php

namespace App\View\Components;

use Illuminate\View\Component;

class StatisticCard extends Component
{
    public $label;
    public $value;
    public $formatted;

    public function __construct($label, $value, $formatted = null)
    {
        $this->label = $label;
        $this->value = $value;
        $this->formatted = $formatted ?? $value;
    }

    public function render()
    {
        return view('components.statistic-card');
    }
}
