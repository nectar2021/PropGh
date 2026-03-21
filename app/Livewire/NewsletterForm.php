<?php

namespace App\Livewire;

use App\Models\Subscriber;
use Livewire\Component;

class NewsletterForm extends Component
{
    public string $email = '';

    protected array $rules = [
        'email' => 'required|email|max:255',
    ];

    public function subscribe(): void
    {
        $this->validate();

        Subscriber::firstOrCreate(
            ['email' => strtolower(trim($this->email))],
            ['subscribed_at' => now()],
        );

        $this->reset('email');
        $this->dispatch('subscribed');
        session()->flash('subscribed', 'You\'re in! Watch your inbox for updates.');
    }

    public function render()
    {
        return view('livewire.newsletter-form');
    }
}
