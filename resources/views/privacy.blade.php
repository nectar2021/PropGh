@extends('layouts.app')

@section('title', 'Propsgh | Privacy Policy')
@section('meta_description', 'Privacy policy for the Propsgh platform — how we collect, use, and protect your data.')

@push('styles')
<style>
  .legal-page {
    --lp-dark: #0f172a;
    --lp-text: #334155;
    --lp-muted: #64748b;
    --lp-surface: #ffffff;
    --lp-bg: #f8fafc;
    --lp-border: rgba(15, 23, 42, 0.06);
    --lp-accent: #0ea5e9;
    background: var(--lp-bg);
  }

  /* ─── Hero ─── */
  .legal-hero {
    background: var(--lp-dark);
    padding: 4.5rem 1.5rem 3.5rem;
    text-align: center;
    margin: -1rem -0.75rem 0;
    border-radius: 0 0 2rem 2rem;
    position: relative;
    overflow: hidden;
  }
  .legal-hero::before {
    content: '';
    position: absolute;
    inset: 0;
    background:
      radial-gradient(ellipse 60% 50% at 20% 80%, rgba(16, 185, 129, 0.1), transparent),
      radial-gradient(ellipse 50% 40% at 80% 20%, rgba(14, 165, 233, 0.08), transparent);
    pointer-events: none;
  }
  .legal-hero-content {
    position: relative;
    z-index: 1;
    max-width: 640px;
    margin: 0 auto;
  }
  .legal-hero-tag {
    display: inline-flex;
    align-items: center;
    gap: 0.4rem;
    padding: 0.3rem 0.8rem;
    border-radius: 999px;
    background: rgba(255, 255, 255, 0.08);
    border: 1px solid rgba(255, 255, 255, 0.1);
    color: rgba(255, 255, 255, 0.7);
    font-size: 0.68rem;
    font-weight: 700;
    letter-spacing: 0.1em;
    text-transform: uppercase;
    margin-bottom: 1rem;
  }
  .legal-hero h1 {
    color: #fff;
    font-size: 2.2rem;
    font-weight: 800;
    letter-spacing: -0.03em;
    line-height: 1.2;
    margin-bottom: 0.75rem;
  }
  .legal-hero p {
    color: rgba(255, 255, 255, 0.55);
    font-size: 0.95rem;
    margin: 0;
  }

  /* ─── Body ─── */
  .legal-body {
    max-width: 800px;
    margin: -1.5rem auto 0;
    padding: 0 1rem 4rem;
    position: relative;
    z-index: 2;
  }
  .legal-card {
    background: var(--lp-surface);
    border-radius: 1.25rem;
    border: 1px solid var(--lp-border);
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.04);
    padding: 2.5rem;
  }

  /* ─── Table of contents ─── */
  .legal-toc {
    padding: 1.25rem 1.5rem;
    border-radius: 0.75rem;
    background: var(--lp-bg);
    border: 1px solid var(--lp-border);
    margin-bottom: 2rem;
  }
  .legal-toc-title {
    font-size: 0.7rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.08em;
    color: var(--lp-muted);
    margin-bottom: 0.65rem;
  }
  .legal-toc ol {
    margin: 0;
    padding-left: 1.25rem;
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 0.3rem 1.5rem;
  }
  .legal-toc li {
    font-size: 0.82rem;
    color: var(--lp-accent);
  }
  .legal-toc a {
    color: var(--lp-accent);
    text-decoration: none;
    font-weight: 500;
  }
  .legal-toc a:hover {
    text-decoration: underline;
  }

  /* ─── Sections ─── */
  .legal-section {
    margin-bottom: 2rem;
    scroll-margin-top: 100px;
  }
  .legal-section:last-child {
    margin-bottom: 0;
  }
  .legal-section h2 {
    font-size: 1.15rem;
    font-weight: 700;
    color: var(--lp-dark);
    margin-bottom: 0.75rem;
    padding-bottom: 0.5rem;
    border-bottom: 1px solid var(--lp-border);
  }
  .legal-section h2 .legal-num {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 1.6rem;
    height: 1.6rem;
    border-radius: 0.4rem;
    background: rgba(14, 165, 233, 0.08);
    color: var(--lp-accent);
    font-size: 0.75rem;
    font-weight: 800;
    margin-right: 0.5rem;
    vertical-align: middle;
  }
  .legal-section p,
  .legal-section li {
    font-size: 0.9rem;
    line-height: 1.75;
    color: var(--lp-text);
  }
  .legal-section ul {
    padding-left: 1.25rem;
    margin: 0.5rem 0;
  }
  .legal-section ul li {
    margin-bottom: 0.25rem;
  }
  .legal-section strong {
    color: var(--lp-dark);
  }

  /* ─── Contact box ─── */
  .legal-contact {
    margin-top: 2.5rem;
    padding: 1.25rem 1.5rem;
    border-radius: 0.75rem;
    background: rgba(14, 165, 233, 0.04);
    border: 1px solid rgba(14, 165, 233, 0.12);
  }
  .legal-contact p {
    font-size: 0.85rem;
    color: var(--lp-text);
    margin: 0;
  }
  .legal-contact a {
    color: var(--lp-accent);
    font-weight: 600;
    text-decoration: none;
  }
  .legal-contact a:hover {
    text-decoration: underline;
  }

  @media (max-width: 575.98px) {
    .legal-hero h1 { font-size: 1.65rem; }
    .legal-card { padding: 1.5rem; }
    .legal-toc ol { grid-template-columns: 1fr; }
  }
</style>
@endpush

@section('content')
<div class="legal-page">

  {{-- Hero --}}
  <div class="legal-hero">
    <div class="legal-hero-content">
      <span class="legal-hero-tag"><i class="fi-shield"></i> Privacy</span>
      <h1>{{ $page->title ?? 'Privacy Policy' }}</h1>
      <p>Last updated: {{ $page ? $page->updated_at->format('F j, Y') : now()->format('F j, Y') }}</p>
    </div>
  </div>

  {{-- Body --}}
  <div class="legal-body">
    <div class="legal-card">

      @if($page && !empty($page->sections))
        {{-- Table of contents --}}
        <div class="legal-toc">
          <div class="legal-toc-title">Contents</div>
          <ol>
            @foreach ($page->sections as $section)
              <li><a href="#{{ $section['anchor'] }}">{{ $section['title'] }}</a></li>
            @endforeach
          </ol>
        </div>

        {{-- Sections --}}
        @foreach ($page->sections as $i => $section)
          <div class="legal-section" id="{{ $section['anchor'] }}">
            <h2><span class="legal-num">{{ $i + 1 }}</span> {{ $section['title'] }}</h2>
            {!! $section['content'] !!}
          </div>
        @endforeach
      @endif

      <div class="legal-contact">
        <p><i class="fi-mail me-1"></i> Email: <a href="mailto:hello@propsgh.com">hello@propsgh.com</a></p>
        <p class="mt-1"><i class="fi-map-pin me-1"></i> Propsgh, Accra, Ghana</p>
        <p class="mt-1">Or visit our <a href="{{ route('contact') }}">contact page</a> for more ways to get in touch.</p>
      </div>

    </div>
  </div>
</div>
@endsection
