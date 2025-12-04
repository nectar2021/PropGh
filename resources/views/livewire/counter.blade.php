<div class="rounded-2xl border border-white/10 bg-white/5 p-6 shadow-xl backdrop-blur">
    <div class="flex items-start justify-between gap-4">
        <div>
            <p class="text-xs font-semibold uppercase tracking-[0.2em] text-amber-300">Livewire 3</p>
            <h2 class="mt-1 text-3xl font-semibold text-white">Reactive Counter</h2>
            <p class="mt-2 text-sm text-slate-300">State lives in PHP, updates stay snappy.</p>
        </div>
        <div class="flex flex-col items-center rounded-xl border border-amber-400/30 bg-amber-500/10 px-4 py-3 text-amber-50 shadow-inner shadow-amber-500/20">
            <span class="text-[11px] uppercase tracking-[0.18em] text-amber-200">Count</span>
            <span class="text-4xl font-semibold leading-none">{{ $count }}</span>
            <span class="mt-1 text-[11px] uppercase tracking-[0.2em] text-amber-200">step {{ $step }}</span>
        </div>
    </div>

    <div class="mt-6 grid gap-3 sm:grid-cols-3">
        <button
            type="button"
            wire:click="decrement"
            class="group inline-flex items-center justify-center gap-2 rounded-xl border border-white/10 bg-white/5 px-4 py-3 text-sm font-semibold text-white transition hover:-translate-y-0.5 hover:border-amber-200/40 hover:bg-white/10 hover:text-amber-100"
        >
            <span class="text-lg leading-none">−</span>
            <span class="transition group-hover:text-amber-200">Decrease</span>
        </button>
        <button
            type="button"
            wire:click="resetCounter"
            class="inline-flex items-center justify-center gap-2 rounded-xl border border-white/10 bg-black/30 px-4 py-3 text-sm font-semibold text-white transition hover:-translate-y-0.5 hover:border-amber-200/40 hover:bg-black/40 hover:text-amber-100"
        >
            <svg class="size-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                <path d="M4 4v6h6" />
                <path d="M20 20v-6h-6" />
                <path d="M4 10a8 8 0 0 1 13.657-5.657L20 6" />
                <path d="M20 14a8 8 0 0 1-13.657 5.657L4 18" />
            </svg>
            <span class="transition group-hover:text-amber-200">Reset</span>
        </button>
        <button
            type="button"
            wire:click="increment"
            class="group inline-flex items-center justify-center gap-2 rounded-xl border border-amber-400/60 bg-amber-500/10 px-4 py-3 text-sm font-semibold text-amber-50 transition hover:-translate-y-0.5 hover:bg-amber-500/20 hover:text-white"
        >
            <span class="text-lg leading-none">+</span>
            <span class="transition group-hover:text-white">Add {{ $step }}</span>
        </button>
    </div>

    <div class="mt-6 rounded-xl border border-white/10 bg-black/30 px-4 py-3">
        <label class="text-[11px] font-semibold uppercase tracking-[0.2em] text-slate-300">
            Step size
        </label>
        <div class="mt-2 flex items-center gap-3">
            <input
                type="number"
                min="1"
                max="99"
                wire:model.live="step"
                class="w-24 rounded-lg border border-white/10 bg-black/40 px-3 py-2 text-base font-semibold text-white outline-none transition focus:border-amber-300 focus:ring-2 focus:ring-amber-300/30"
            />
            <p class="text-sm text-slate-400">`wire:model.live` keeps the step synced as you type.</p>
        </div>
    </div>

    <div class="mt-4 flex items-center gap-2 text-xs text-slate-400">
        <span class="size-2 rounded-full bg-emerald-400/80"></span>
        <p>Watch your network tab to see Livewire diffs travel over AJAX without writing any JavaScript.</p>
    </div>

    <div
        wire:loading.delay
        wire:target="increment,decrement,resetCounter,step"
        class="pointer-events-none mt-4 inline-flex items-center gap-2 rounded-full bg-amber-500/10 px-3 py-1 text-[12px] font-semibold uppercase tracking-[0.18em] text-amber-100 ring-1 ring-amber-400/40"
    >
        <span class="size-2 animate-ping rounded-full bg-amber-300"></span>
        Syncing
    </div>
</div>
