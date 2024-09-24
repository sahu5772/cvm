<?php

namespace App\View\Components;

use Illuminate\View\Component;

class ButtonComponent extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public $type;
    public $class;
    public $label;

    public function __construct($type = 'button', $class = 'btn', $label = 'Button')
    {
        $this->type = $type;
        $this->class = $class;
        $this->label = $label;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.button-component');
    }
}
