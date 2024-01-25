<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class StackGraph extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(public array $labels, public array $cashDataSet, public array $cardDataSet)
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.stack-graph');
    }
}
