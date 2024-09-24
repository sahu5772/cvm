<?php

namespace App\View\Components;

use Illuminate\View\Component;

class SelectInputComponent extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public $name;
    public $options;
    public $selected;
    public $title;
    public $id;

    public function __construct($name, $options='', $selected = null,$title = null,$id=null)
    {
        $this->title = $title;
        $this->id = $id;
        $this->name = $name;
        $this->options = $options;
        $this->selected = $selected;
    }


    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.select-input-component');
    }
}
