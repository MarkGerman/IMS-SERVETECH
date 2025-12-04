<?php

namespace App\Livewire\Nav\List;

use App\Models\ClassLevel;
use Livewire\Component;
use Livewire\Attributes\On;

class LevelListLivewire extends Component
{

    public $levels;

    #[On('update_nav')]
    public function reload()
    {
        $this->levels = ClassLevel::all();
    }

    public function render()
    {
        $this->levels = ClassLevel::all();

        return view('livewire.nav.list.level-list-livewire');
    }
}
