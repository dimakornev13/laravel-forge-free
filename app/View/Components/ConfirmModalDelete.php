<?php

namespace App\View\Components;

use Illuminate\View\Component;

class ConfirmModalDelete extends Component
{
    /**
     * @var string
     */
    public $content;

    /**
     * @var
     */
    public $url;


    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(string $url, string $content)
    {
        $this->content = $content;
        $this->url = $url;
    }


    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        return view('components.confirm-modal-delete');
    }
}
