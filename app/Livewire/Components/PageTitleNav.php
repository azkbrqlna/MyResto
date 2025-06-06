<?php

namespace App\Livewire\Components;

use Livewire\Component;

class PageTitleNav extends Component
{
    public string $title;
    public bool $showModal = false;
    public bool $hasBack = false;
    public bool $hasFIlter = true;

    protected $listeners = [
        'showModal' => 'openModal',
    ];

    public function openModal(){
        $this->showModal = true;
    }

    public function closeModal(){
        $this->showModal = false;
    }

    public function render()
    {
        return view('livewire.components.page-title-nav');
    }
}
