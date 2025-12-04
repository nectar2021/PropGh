<div class="contact-card p-4 p-lg-5">
    <h2 class="h4 fw-semibold mb-1">Send us a message</h2>
    <p class="text-body-secondary mb-4">Tell us what you need — we’ll respond within one business day.</p>

    @if (session('contact_submitted'))
        <div class="alert alert-success py-2 px-3 mb-3">
            {{ session('contact_submitted') }}
        </div>
    @endif

    <form class="row g-3" wire:submit.prevent="submit">
        <div class="col-md-6">
            <label class="form-label">First name</label>
            <input type="text" class="form-control form-control-lg" placeholder="Jane" wire:model.defer="first_name">
            @error('first_name') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
        </div>
        <div class="col-md-6">
            <label class="form-label">Last name</label>
            <input type="text" class="form-control form-control-lg" placeholder="Doe" wire:model.defer="last_name">
            @error('last_name') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
        </div>
        <div class="col-md-6">
            <label class="form-label">Email</label>
            <input type="email" class="form-control form-control-lg" placeholder="you@example.com" wire:model.defer="email">
            @error('email') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
        </div>
        <div class="col-md-6">
            <label class="form-label">Phone</label>
            <input type="tel" class="form-control form-control-lg" placeholder="+233..." wire:model.defer="phone">
            @error('phone') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
        </div>
        <div class="col-md-6">
            <label class="form-label">Topic</label>
            <select class="form-select form-select-lg" wire:model.defer="topic">
                <option>Bookings</option>
                <option>List my property</option>
                <option>Partnerships</option>
                <option>Support</option>
                <option>Other</option>
            </select>
            @error('topic') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
        </div>
        <div class="col-md-6">
            <label class="form-label">Preferred city</label>
            <select class="form-select form-select-lg" wire:model.defer="city">
                <option>Accra</option>
                <option>Kumasi</option>
                <option>Tema</option>
                <option>Takoradi</option>
            </select>
            @error('city') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
        </div>
        <div class="col-12">
            <label class="form-label">How can we help?</label>
            <textarea class="form-control form-control-lg" rows="4" placeholder="Tell us about your needs..." wire:model.defer="message"></textarea>
            @error('message') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
        </div>
        <div class="col-12 d-flex align-items-center justify-content-between flex-wrap gap-2">
            <div class="form-check">
                <input class="form-check-input" type="checkbox" id="newsletter" wire:model.defer="newsletter">
                <label class="form-check-label" for="newsletter">Send me Propsgh updates</label>
            </div>
            <button type="submit" class="btn btn-primary btn-lg px-4">Send message</button>
        </div>
    </form>
</div>
