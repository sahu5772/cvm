<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Form extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public $action;
    public $method;
    public $id;
    public $name;

    public function __construct($action, $method,$id=null,$name=null)
    {
        $this->action = $action;
        $this->id = $id;
        $this->name = $name;
        $this->method = strtoupper($method);
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.form');
    }
}
