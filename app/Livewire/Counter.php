<?php

namespace App\Livewire;

use Livewire\Component;

class Counter extends Component
{
    public $count = 0;

    public $step = 1;

    public function increment(): void
    {
        $this->count += $this->step;
    }

    public function decrement(): void
    {
        $this->count = max(0, $this->count - $this->step);
    }

    public function resetCounter(): void
    {
        $this->reset(['count', 'step']);
    }

    public function updatedStep($value): void
    {
        $this->step = max(1, (int) $value);
    }

    public function render()
    {
        return view('livewire.counter');
    }
}
