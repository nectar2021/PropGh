@extends('layouts.app')

@section('title', config('app.name', 'Laravel') . ' • Livewire + Tailwind')

@section('content')
    <div class="space-y-10">
        <section class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <div class="space-y-3">
                <p class="text-xs font-semibold uppercase tracking-[0.25em] text-amber-300">
                    Laravel 12 • Vite 7 • Tailwind 4
                </p>
                <h1 class="text-4xl font-semibold leading-tight text-white sm:text-5xl">Livewire is wired up.</h1>
                <p class="max-w-2xl text-lg text-slate-300">
                    Build reactive UIs with PHP-driven state. Tailwind + Vite handle the pipeline while Livewire keeps interactions
                    snappy without writing JavaScript.
                </p>
            </div>
            <div class="flex flex-wrap items-center gap-2 text-sm">
                <span class="rounded-full border border-white/10 bg-white/5 px-3 py-1 text-amber-100">Livewire v3.7</span>
                <span class="rounded-full border border-white/10 bg-white/5 px-3 py-1 text-slate-200">PHP {{ PHP_VERSION }}</span>
                <span class="rounded-full border border-white/10 bg-white/5 px-3 py-1 text-slate-200">Vite + Tailwind ready</span>
            </div>
        </section>

        <section class="grid gap-8 lg:grid-cols-[2fr_1fr]">
            <livewire:counter />

            <div class="space-y-4">
                <div class="rounded-2xl border border-white/10 bg-white/5 p-5 shadow-lg backdrop-blur">
                    <h3 class="text-lg font-semibold text-white">Stack highlights</h3>
                    <ul class="mt-3 space-y-3 text-sm text-slate-300">
                        <li class="flex gap-3">
                            <span class="mt-[6px] size-2 rounded-full bg-amber-300"></span>
                            Laravel 12 with Vite entry points at <code>resources/css/app.css</code> and <code>resources/js/app.js</code>.
                        </li>
                        <li class="flex gap-3">
                            <span class="mt-[6px] size-2 rounded-full bg-amber-300"></span>
                            Tailwind CSS 4 compiled through the official <code>@tailwindcss/vite</code> plugin.
                        </li>
                        <li class="flex gap-3">
                            <span class="mt-[6px] size-2 rounded-full bg-amber-300"></span>
                            Livewire 3.7 installed—components are PHP classes rendered server-side with minimal AJAX diffs.
                        </li>
                    </ul>
                </div>

                <div class="rounded-2xl border border-white/10 bg-black/30 p-5 shadow-lg backdrop-blur">
                    <h3 class="text-lg font-semibold text-white">Quickstart</h3>
                    <div class="mt-3 space-y-2 text-sm text-slate-300">
                        <p>1) <code>composer install</code> (already wired to Livewire 3.7)</p>
                        <p>2) <code>npm install</code></p>
                        <p>3) <code>npm run dev</code> and <code>php artisan serve</code></p>
                        <p class="text-xs text-slate-400">Vite’s dev server will auto-refresh the page.</p>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
