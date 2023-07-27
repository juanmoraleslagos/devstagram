<?php

namespace App\View\Components;

use Illuminate\View\Component;

class ListarPost extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(public $posts)
    {
        // establecer variable en constructor
        $this->posts = $posts;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.listar-post');
    }
}
