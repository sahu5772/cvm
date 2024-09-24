<?php

namespace App\View\Components;

use Illuminate\View\Component;

class InputComponent extends Component
{
    public $name;
    public $id;
    public $title;
    public $value;
    public $type;
    public $placeholder;

    public function __construct($name,$title=null,$value=null,$type = null,$placeholder = null,$id=null)
    {
        $this->name = $name;
        $this->id = $id;
        $this->title = $title;
        $this->value = $value;
        $this->type = $type;
        $this->placeholder = $placeholder;
    }

    public function render()
    {
        return view('components.input-component');
    }
}
