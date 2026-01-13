<?php

namespace App\Livewire;

use Livewire\Component;

class ContactForm extends Component
{
    public string $first_name = '';
    public string $last_name = '';
    public string $email = '';
    public string $phone = '';
    public string $topic = 'Bookings';
    public string $city = 'Accra';
    public string $message = '';
    public bool $newsletter = false;

    protected array $rules = [
        'first_name' => 'required|string|max:255',
        'last_name'  => 'required|string|max:255',
        'email'      => 'required|email',
        'phone'      => 'nullable|string|max:50',
        'topic'      => 'required|string|max:255',
        'city'       => 'required|string|max:255',
        'message'    => 'required|string|min:10',
        'newsletter' => 'boolean',
    ];

    public function submit(): void
    {
        $this->validate();
        // TODO: handle submission (mail/support ticket) as needed.
        session()->flash('contact_submitted', 'Thanks! We will get back to you within one business day.');
        $this->resetExcept('topic', 'city');
    }

    public function render()
    {
        return view('livewire.contact-form');
    }
}
