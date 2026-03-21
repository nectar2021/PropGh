@extends('layouts.app')

@section('title', 'Propsgh | Contact')
@section('meta_description', 'Get in touch with Propsgh for bookings, listings, and support.')

@push('styles')
<style>
  /* ── Contact page ── */
  .ct-page {
    --ct-dark: #0f172a;
    --ct-slate: #475569;
    --ct-muted: #94a3b8;
    --ct-surface: #ffffff;
    --ct-bg: #f8fafc;
    --ct-border: rgba(15, 23, 42, 0.07);
    --ct-accent: #0ea5e9;
    --ct-accent-soft: rgba(14, 165, 233, 0.08);
    --ct-green: #10b981;
    --ct-green-soft: rgba(16, 185, 129, 0.07);
    --ct-violet: #8b5cf6;
    --ct-violet-soft: rgba(139, 92, 246, 0.07);
    --ct-amber: #f59e0b;
    background: var(--ct-bg);
    overflow-x: hidden;
  }

  /* ─── Hero banner ─── */
  .ct-page .ct-hero {
    position: relative;
    min-height: 340px;
    display: flex;
    align-items: center;
    justify-content: center;
    text-align: center;
    padding: 4rem 1.5rem 3rem;
    overflow: hidden;
    margin: -1rem -0.75rem 0;
    border-radius: 0 0 2rem 2rem;
  }
  .ct-page .ct-hero-bg {
    position: absolute;
    inset: 0;
    z-index: 0;
  }
  .ct-page .ct-hero-bg img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    object-position: center 35%;
  }
  .ct-page .ct-hero-bg::after {
    content: '';
    position: absolute;
    inset: 0;
    background:
      linear-gradient(180deg,
        rgba(15, 23, 42, 0.55) 0%,
        rgba(15, 23, 42, 0.75) 50%,
        rgba(15, 23, 42, 0.85) 100%
      );
  }
  .ct-page .ct-hero-content {
    position: relative;
    z-index: 1;
    max-width: 600px;
  }
  .ct-page .ct-hero-tag {
    display: inline-flex;
    align-items: center;
    gap: 0.4rem;
    padding: 0.3rem 0.8rem;
    border-radius: 999px;
    background: rgba(255, 255, 255, 0.12);
    backdrop-filter: blur(8px);
    -webkit-backdrop-filter: blur(8px);
    border: 1px solid rgba(255, 255, 255, 0.15);
    color: rgba(255, 255, 255, 0.9);
    font-size: 0.68rem;
    font-weight: 700;
    letter-spacing: 0.1em;
    text-transform: uppercase;
    margin-bottom: 1.25rem;
  }
  .ct-page .ct-hero-tag i {
    font-size: 0.7rem;
  }
  .ct-page .ct-hero-title {
    font-size: clamp(2rem, 5vw, 3rem);
    font-weight: 800;
    color: #ffffff;
    letter-spacing: -0.03em;
    line-height: 1.1;
    margin-bottom: 0.85rem;
  }
  .ct-page .ct-hero-sub {
    font-size: 1rem;
    color: rgba(255, 255, 255, 0.7);
    line-height: 1.65;
    max-width: 480px;
    margin: 0 auto;
  }

  /* ─── Floating stat row ─── */
  .ct-page .ct-stats {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 0.75rem;
    max-width: 720px;
    margin: -2.5rem auto 2.5rem;
    position: relative;
    z-index: 2;
    padding: 0 1rem;
  }
  .ct-page .ct-stat {
    background: var(--ct-surface);
    border: 1px solid var(--ct-border);
    border-radius: 1rem;
    padding: 1rem 0.75rem;
    text-align: center;
    box-shadow: 0 4px 20px rgba(15, 23, 42, 0.06);
    transition: transform 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);
  }
  .ct-page .ct-stat:hover {
    transform: translateY(-3px);
  }
  .ct-page .ct-stat-icon {
    width: 36px;
    height: 36px;
    border-radius: 0.7rem;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    font-size: 1rem;
    margin-bottom: 0.45rem;
  }
  .ct-page .ct-stat-icon.sky { background: var(--ct-accent-soft); color: var(--ct-accent); }
  .ct-page .ct-stat-icon.green { background: var(--ct-green-soft); color: var(--ct-green); }
  .ct-page .ct-stat-icon.violet { background: var(--ct-violet-soft); color: var(--ct-violet); }
  .ct-page .ct-stat-icon.amber { background: rgba(245, 158, 11, 0.08); color: var(--ct-amber); }
  .ct-page .ct-stat-num {
    font-size: 1.2rem;
    font-weight: 800;
    color: var(--ct-dark);
    letter-spacing: -0.02em;
    line-height: 1;
  }
  .ct-page .ct-stat-label {
    font-size: 0.62rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.06em;
    color: var(--ct-muted);
    margin-top: 0.2rem;
  }

  @media (max-width: 767.98px) {
    .ct-page .ct-hero {
      min-height: 260px;
      padding: 3rem 1rem 2.5rem;
      margin: -1rem -0.5rem 0;
      border-radius: 0 0 1.25rem 1.25rem;
    }
    .ct-page .ct-hero-title {
      font-size: 1.65rem;
    }
    .ct-page .ct-hero-sub {
      font-size: 0.88rem;
    }
    .ct-page .ct-stats {
      margin-top: -2rem;
    }
  }
  @media (max-width: 575.98px) {
    .ct-page .ct-hero {
      min-height: 220px;
      padding: 2.5rem 0.75rem 2rem;
      margin: -0.5rem -0.25rem 0;
      border-radius: 0 0 1rem 1rem;
    }
    .ct-page .ct-hero-title {
      font-size: 1.4rem;
    }
    .ct-page .ct-stats {
      grid-template-columns: repeat(2, 1fr);
      margin-top: -1.5rem;
      padding: 0 0.5rem;
    }
  }
  @media (max-width: 374.98px) {
    .ct-page .ct-hero-title {
      font-size: 1.2rem;
    }
    .ct-page .ct-hero-sub {
      font-size: 0.8rem;
    }
  }

  /* ─── Main layout ─── */
  .ct-page .ct-main {
    display: grid;
    grid-template-columns: 1fr;
    gap: 2rem;
    max-width: 1040px;
    margin: 0 auto;
    padding: 0 1rem 3rem;
  }
  @media (min-width: 768px) {
    .ct-page .ct-main {
      grid-template-columns: 1fr 1fr;
      gap: 2.5rem;
    }
  }

  /* ─── Left: form ─── */
  .ct-page .ct-form-wrap {
    background: var(--ct-surface);
    border: 1px solid var(--ct-border);
    border-radius: 1.5rem;
    padding: 2.25rem;
    position: relative;
    overflow: hidden;
    box-shadow:
      0 1px 3px rgba(15, 23, 42, 0.03),
      0 12px 40px rgba(15, 23, 42, 0.06);
  }
  .ct-page .ct-form-wrap::before {
    content: '';
    position: absolute;
    top: 0; left: 0; right: 0;
    height: 3px;
    background: linear-gradient(90deg, var(--ct-accent), var(--ct-green), var(--ct-accent));
    border-radius: 1.5rem 1.5rem 0 0;
  }
  .ct-page .ct-form-head {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    margin-bottom: 1.5rem;
  }
  .ct-page .ct-form-head-icon {
    width: 48px;
    height: 48px;
    border-radius: 0.9rem;
    background: linear-gradient(135deg, var(--ct-accent-soft), var(--ct-green-soft));
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.2rem;
    color: var(--ct-accent);
    flex-shrink: 0;
  }
  .ct-page .ct-form-title {
    font-size: 1.25rem;
    font-weight: 700;
    color: var(--ct-dark);
    margin-bottom: 0.1rem;
    line-height: 1.2;
  }
  .ct-page .ct-form-sub {
    font-size: 0.8rem;
    color: var(--ct-slate);
  }

  /* Fields */
  .ct-page .ct-row {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 0.85rem;
  }
  @media (max-width: 575.98px) {
    .ct-page .ct-row { grid-template-columns: 1fr; }
  }
  .ct-page .ct-field {
    margin-bottom: 0.85rem;
    position: relative;
    z-index: 1;
  }
  .ct-page .ct-field label {
    display: flex;
    align-items: center;
    gap: 0.3rem;
    font-size: 0.74rem;
    font-weight: 600;
    color: var(--ct-slate);
    margin-bottom: 0.3rem;
    letter-spacing: 0.015em;
  }
  .ct-page .ct-field label i {
    font-size: 0.75rem;
    color: var(--ct-muted);
    opacity: 0.6;
  }
  .ct-page .ct-input {
    width: 100%;
    border-radius: 0.8rem;
    border: 1.5px solid rgba(148, 163, 184, 0.3);
    background: #f9fafb;
    padding: 0.68rem 0.95rem;
    font-size: 0.88rem;
    color: var(--ct-dark);
    font-family: inherit;
    transition:
      border-color 0.2s ease,
      background 0.2s ease,
      box-shadow 0.25s ease;
    outline: none;
  }
  .ct-page .ct-input::placeholder {
    color: rgba(100, 116, 139, 0.4);
  }
  .ct-page .ct-input:hover {
    border-color: rgba(148, 163, 184, 0.55);
    background: #fafbfe;
  }
  .ct-page .ct-input:focus {
    border-color: var(--ct-accent);
    background: #fff;
    box-shadow: 0 0 0 3.5px rgba(14, 165, 233, 0.1);
  }
  .ct-page textarea.ct-input {
    resize: vertical;
    min-height: 100px;
  }
  .ct-page select.ct-input {
    cursor: pointer;
    appearance: none;
    background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 24 24' fill='none' stroke='%2394a3b8' stroke-width='2.5' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpolyline points='6 9 12 15 18 9'/%3E%3C/svg%3E");
    background-repeat: no-repeat;
    background-position: right 0.85rem center;
    padding-right: 2.5rem;
  }

  /* Submit */
  .ct-page .ct-submit {
    width: 100%;
    padding: 0.78rem;
    border: none;
    border-radius: 0.8rem;
    background: var(--ct-dark);
    color: #fff;
    font-size: 0.9rem;
    font-weight: 600;
    font-family: inherit;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0.45rem;
    margin-top: 0.35rem;
    transition:
      background 0.2s ease,
      transform 0.2s cubic-bezier(0.34, 1.56, 0.64, 1),
      box-shadow 0.2s ease;
  }
  .ct-page .ct-submit:hover {
    background: #1e293b;
    transform: translateY(-1px);
    box-shadow: 0 4px 18px rgba(15, 23, 42, 0.22);
  }
  .ct-page .ct-submit i {
    font-size: 0.82rem;
    transition: transform 0.25s ease;
  }
  .ct-page .ct-submit:hover i {
    transform: translateX(3px) rotate(-12deg);
  }

  /* ─── Right column ─── */
  .ct-page .ct-right {
    display: flex;
    flex-direction: column;
    gap: 1.15rem;
  }

  /* Contact cards */
  .ct-page .ct-contact-card {
    background: var(--ct-surface);
    border: 1px solid var(--ct-border);
    border-radius: 1.2rem;
    padding: 1.35rem;
    display: flex;
    align-items: center;
    gap: 1rem;
    text-decoration: none;
    transition:
      transform 0.3s cubic-bezier(0.34, 1.56, 0.64, 1),
      box-shadow 0.25s ease,
      border-color 0.2s ease;
  }
  .ct-page .ct-contact-card:hover {
    transform: translateY(-3px);
    box-shadow: 0 8px 28px rgba(15, 23, 42, 0.07);
    border-color: rgba(14, 165, 233, 0.15);
  }
  .ct-page .ct-contact-icon {
    width: 50px;
    height: 50px;
    border-radius: 0.9rem;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.2rem;
    flex-shrink: 0;
  }
  .ct-page .ct-contact-icon.sky { background: var(--ct-accent-soft); color: var(--ct-accent); }
  .ct-page .ct-contact-icon.green { background: var(--ct-green-soft); color: var(--ct-green); }
  .ct-page .ct-contact-icon.violet { background: var(--ct-violet-soft); color: var(--ct-violet); }
  .ct-page .ct-contact-label {
    font-size: 0.68rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.07em;
    color: var(--ct-muted);
    margin-bottom: 0.1rem;
  }
  .ct-page .ct-contact-value {
    font-size: 0.95rem;
    font-weight: 600;
    color: var(--ct-dark);
  }
  .ct-page .ct-contact-hint {
    font-size: 0.72rem;
    color: var(--ct-muted);
    margin-top: 0.1rem;
  }

  /* Person card */
  .ct-page .ct-person-card {
    background: var(--ct-surface);
    border: 1px solid var(--ct-border);
    border-radius: 1.2rem;
    padding: 1.35rem;
    position: relative;
    overflow: hidden;
  }
  .ct-page .ct-person-card::before {
    content: '';
    position: absolute;
    top: 0; left: 0; right: 0;
    height: 60px;
    background: linear-gradient(135deg, rgba(14, 165, 233, 0.05), rgba(16, 185, 129, 0.05));
  }
  .ct-page .ct-person-top {
    position: relative;
    display: flex;
    align-items: center;
    gap: 0.85rem;
    margin-bottom: 1rem;
  }
  .ct-page .ct-avatar {
    width: 52px;
    height: 52px;
    border-radius: 50%;
    object-fit: cover;
    border: 3px solid var(--ct-surface);
    box-shadow: 0 2px 8px rgba(15, 23, 42, 0.1);
  }
  .ct-page .ct-person-name {
    font-size: 0.95rem;
    font-weight: 700;
    color: var(--ct-dark);
  }
  .ct-page .ct-person-role {
    font-size: 0.72rem;
    color: var(--ct-muted);
  }
  .ct-page .ct-online {
    display: inline-flex;
    align-items: center;
    gap: 0.3rem;
    font-size: 0.68rem;
    font-weight: 600;
    color: var(--ct-green);
  }
  .ct-page .ct-online::before {
    content: '';
    width: 7px; height: 7px;
    border-radius: 50%;
    background: var(--ct-green);
    box-shadow: 0 0 0 2px rgba(16, 185, 129, 0.2);
    animation: ct-blink 2s ease-in-out infinite;
  }
  @keyframes ct-blink {
    0%, 100% { opacity: 1; }
    50% { opacity: 0.35; }
  }
  .ct-page .ct-person-text {
    font-size: 0.82rem;
    color: var(--ct-slate);
    line-height: 1.55;
    margin: 0;
  }

  /* FAQ card */
  .ct-page .ct-faq-card {
    background: var(--ct-surface);
    border: 1px solid var(--ct-border);
    border-radius: 1.2rem;
    padding: 1.35rem;
  }
  .ct-page .ct-faq-heading {
    font-size: 0.7rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.08em;
    color: var(--ct-muted);
    margin-bottom: 0.65rem;
    display: flex;
    align-items: center;
    gap: 0.35rem;
  }
  .ct-page .ct-faq-heading i { font-size: 0.8rem; color: var(--ct-accent); }
  .ct-page .ct-faq-item {
    padding: 0.6rem 0;
    border-bottom: 1px dashed var(--ct-border);
  }
  .ct-page .ct-faq-item:last-child {
    border-bottom: none;
    padding-bottom: 0;
  }
  .ct-page .ct-faq-q {
    font-size: 0.84rem;
    font-weight: 600;
    color: var(--ct-dark);
    margin-bottom: 0.15rem;
  }
  .ct-page .ct-faq-a {
    font-size: 0.76rem;
    color: var(--ct-slate);
    line-height: 1.5;
  }

  /* Trust bar */
  .ct-page .ct-trust {
    display: flex;
    align-items: center;
    justify-content: center;
    flex-wrap: wrap;
    gap: 1.5rem;
    max-width: 1040px;
    margin: 0 auto;
    padding: 0 1rem 2.5rem;
  }
  .ct-page .ct-trust-item {
    display: flex;
    align-items: center;
    gap: 0.35rem;
    font-size: 0.75rem;
    font-weight: 500;
    color: var(--ct-muted);
  }
  .ct-page .ct-trust-item i {
    font-size: 0.85rem;
    color: var(--ct-green);
  }

  /* \u2500\u2500 Contact responsive extras \u2500\u2500 */
  @media (max-width: 767.98px) {
    .ct-page .ct-form-wrap {
      padding: 1.5rem;
      border-radius: 1.15rem;
    }
    .ct-page .ct-form-head-icon {
      width: 40px;
      height: 40px;
      font-size: 1rem;
    }
    .ct-page .ct-main {
      padding: 0 0.75rem 2rem;
    }
  }
  @media (max-width: 575.98px) {
    .ct-page .ct-form-wrap {
      padding: 1.15rem;
      border-radius: 1rem;
    }
    .ct-page .ct-trust {
      gap: 0.75rem 1rem;
      padding: 0 0.5rem 1.5rem;
    }
    .ct-page .ct-main {
      gap: 1.5rem;
      padding: 0 0.5rem 1.5rem;
    }
  }
</style>
@endpush

@section('content')
  <div class="ct-page">

    {{-- ── Hero banner ── --}}
    <div class="ct-hero">
      <div class="ct-hero-bg">
        <img src="{{ asset('assets/img/contact/v1/hero.jpg') }}" alt="">
      </div>
      <div class="ct-hero-content">
        <div class="ct-hero-tag"><i class="fi-send"></i> Contact Propsgh</div>
        <h1 class="ct-hero-title">Let's start a conversation</h1>
        <p class="ct-hero-sub">Whether you need help finding a property, listing one, or just have a question — our team is ready for you.</p>
      </div>
    </div>

    {{-- ── Floating stats ── --}}
    <div class="ct-stats">
      <div class="ct-stat">
        <div class="ct-stat-icon sky"><i class="fi-clock"></i></div>
        <div class="ct-stat-num">&lt; 2hr</div>
        <div class="ct-stat-label">Response</div>
      </div>
      <div class="ct-stat">
        <div class="ct-stat-icon green"><i class="fi-check-circle"></i></div>
        <div class="ct-stat-num">98%</div>
        <div class="ct-stat-label">Resolved</div>
      </div>
      <div class="ct-stat">
        <div class="ct-stat-icon violet"><i class="fi-star-filled"></i></div>
        <div class="ct-stat-num">4.8</div>
        <div class="ct-stat-label">Rating</div>
      </div>
      <div class="ct-stat">
        <div class="ct-stat-icon amber"><i class="fi-heart-filled"></i></div>
        <div class="ct-stat-num">2k+</div>
        <div class="ct-stat-label">Happy Users</div>
      </div>
    </div>

    {{-- ── Main grid ── --}}
    <div class="ct-main">

      {{-- Form --}}
      <div class="ct-form-wrap">
        <div class="ct-form-head">
          <div class="ct-form-head-icon"><i class="fi-edit"></i></div>
          <div>
            <div class="ct-form-title">Send us a message</div>
            <div class="ct-form-sub">We'll respond within one business day</div>
          </div>
        </div>

        @if (session('status'))
          <div class="alert alert-success py-2 px-3 mb-3" style="border-radius: 0.75rem; font-size: 0.86rem;">
            <i class="fi-check-circle me-1"></i> {{ session('status') }}
          </div>
        @endif
        @if ($errors->any())
          <div class="alert alert-danger py-2 px-3 mb-3" style="border-radius: 0.75rem; font-size: 0.86rem;">
            <ul class="mb-0 ps-3" style="font-size: 0.82rem;">
              @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
              @endforeach
            </ul>
          </div>
        @endif

        <form method="POST" action="{{ route('contact.store') }}">
          @csrf
          <div class="ct-field">
            <label for="ct-name"><i class="fi-user"></i> Full name</label>
            <input id="ct-name" name="name" type="text" class="ct-input" placeholder="John Mensah" value="{{ old('name') }}" required>
          </div>

          <div class="ct-field">
            <label for="ct-email"><i class="fi-mail"></i> Email address</label>
            <input id="ct-email" name="email" type="email" class="ct-input" placeholder="you@example.com" value="{{ old('email') }}" required>
          </div>

          <div class="ct-field">
            <label for="ct-msg"><i class="fi-message-square"></i> Your message</label>
            <textarea id="ct-msg" name="message" class="ct-input" placeholder="Tell us how we can help you..." required>{{ old('message') }}</textarea>
          </div>

          <button type="submit" class="ct-submit">
            Send message <i class="fi-send"></i>
          </button>
        </form>
      </div>

      {{-- Right column --}}
      <div class="ct-right">

        {{-- Contact methods --}}
        <a href="mailto:hello@propsgh.com" class="ct-contact-card">
          <div class="ct-contact-icon sky"><i class="fi-mail"></i></div>
          <div>
            <div class="ct-contact-label">Email us</div>
            <div class="ct-contact-value">hello@propsgh.com</div>
            <div class="ct-contact-hint">For general inquiries</div>
          </div>
        </a>

        <a href="tel:+233302123456" class="ct-contact-card">
          <div class="ct-contact-icon green"><i class="fi-phone"></i></div>
          <div>
            <div class="ct-contact-label">Call us</div>
            <div class="ct-contact-value">+233 302 123 456</div>
            <div class="ct-contact-hint">Mon – Fri, 8am – 6pm GMT</div>
          </div>
        </a>

        <div class="ct-contact-card">
          <div class="ct-contact-icon violet"><i class="fi-map-pin"></i></div>
          <div>
            <div class="ct-contact-label">Visit us</div>
            <div class="ct-contact-value">East Legon, Accra</div>
            <div class="ct-contact-hint">By appointment only</div>
          </div>
        </div>

        {{-- Support person --}}
        <div class="ct-person-card">
          <div class="ct-person-top">
            <img class="ct-avatar" src="{{ asset('assets/img/contact/v3/avatar.jpg') }}" alt="Support">
            <div>
              <div class="ct-person-name">Propsgh Support</div>
              <div class="ct-person-role">Customer Success Team</div>
              <div class="ct-online">Online now</div>
            </div>
          </div>
          <p class="ct-person-text">
            Our team typically responds within 2 hours during business hours. For urgent matters, give us a call directly.
          </p>
        </div>

        {{-- FAQ --}}
        <div class="ct-faq-card">
          <div class="ct-faq-heading"><i class="fi-help-circle"></i> Common questions</div>
          <div class="ct-faq-item">
            <div class="ct-faq-q">How fast do you respond?</div>
            <div class="ct-faq-a">Usually under 2 hours on weekdays, within 24 hours on weekends.</div>
          </div>
          <div class="ct-faq-item">
            <div class="ct-faq-q">Can I list my property?</div>
            <div class="ct-faq-a">Absolutely — create an account and submit your listing for review.</div>
          </div>
          <div class="ct-faq-item">
            <div class="ct-faq-q">Is there a booking fee?</div>
            <div class="ct-faq-a">Browsing is free. A small service fee applies only when you book.</div>
          </div>
        </div>
      </div>

    </div>

    {{-- Trust bar --}}
    <div class="ct-trust">
      <div class="ct-trust-item"><i class="fi-shield"></i> Your data is secure</div>
      <div class="ct-trust-item"><i class="fi-check-circle"></i> Free to reach out</div>
      <div class="ct-trust-item"><i class="fi-clock"></i> Fast response guaranteed</div>
      <div class="ct-trust-item"><i class="fi-star-filled"></i> 4.8/5 user rating</div>
    </div>

  </div>
@endsection
