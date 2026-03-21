<div>
    @if (session('subscribed'))
        <p class="ft-cta-success"><i class="fi-check-circle"></i> {{ session('subscribed') }}</p>
    @else
        <form class="ft-cta-form" wire:submit="subscribe">
            <div class="ft-cta-input-wrap">
                <i class="fi-mail ft-cta-input-icon"></i>
                <input type="email" class="ft-cta-input" placeholder="Enter your email" wire:model="email" required>
            </div>
            <button type="submit" class="ft-cta-btn" wire:loading.attr="disabled">
                <span wire:loading.remove>Subscribe <i class="fi-arrow-right"></i></span>
                <span wire:loading>Subscribing…</span>
            </button>
        </form>
        @error('email')
            <p class="ft-cta-note" style="color: #f87171;">{{ $message }}</p>
        @enderror
    @endif
</div>
