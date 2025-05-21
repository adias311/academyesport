<?php

namespace App\View\Components\Card;

use Illuminate\View\Component;

class CardListItem extends Component
{
    public $title, $eps, $duration, $intro, $uri;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($title, $eps, $duration, $intro, $uri)
    {
        $this->title = $title;
        $this->eps = $eps;
        $this->duration = $duration;
        $this->intro = $intro;
        $this->uri = $uri;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.card.card-list-item');
    }
}
