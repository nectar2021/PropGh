@extends('layouts.auth')

@section('title', 'Propsgh | Create Account')
@section('meta-description', 'Create your Propsgh account to list or book properties and shortlets.')
@section('meta-keywords', 'propsgh, signup, register, rentals, apartments, real estate, booking')

@push('styles')
<style>
    /* ── Register page shell ── */
    .reg-shell {
        --rs-dark: #0c1220;
        --rs-slate: #1e293b;
        --rs-muted: #64748b;
        --rs-accent: #f59e0b;
        --rs-accent-hover: #d97706;
        --rs-sky: #0ea5e9;
        --rs-sky-glow: rgba(14, 165, 233, 0.15);
        --rs-emerald: #10b981;
        --rs-surface: #ffffff;
        --rs-border: rgba(226, 232, 240, 0.7);
        min-height: 100vh;
        display: flex;
    }

    /* ── Left: cinematic panel ── */
    .reg-shell .rs-visual {
        position: fixed;
        top: 0;
        left: 0;
        bottom: 0;
        width: 42%;
        background: var(--rs-dark);
        overflow: hidden;
        z-index: 1;
    }
    .reg-shell .rs-visual-img {
        position: absolute;
        inset: 0;
        width: 100%;
        height: 100%;
        object-fit: cover;
        filter: saturate(1.1) brightness(0.82);
    }
    .reg-shell .rs-visual-overlay {
        position: absolute;
        inset: 0;
        background:
            linear-gradient(180deg, rgba(12, 18, 32, 0.5) 0%, rgba(12, 18, 32, 0.1) 35%, rgba(12, 18, 32, 0.78) 100%),
            linear-gradient(135deg, rgba(16, 185, 129, 0.1) 0%, transparent 55%);
    }
    .reg-shell .rs-visual-inner {
        position: absolute;
        inset: 0;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        padding: 2.5rem 2.5rem;
        color: #ffffff;
        z-index: 2;
    }

    /* Benefit cards on image panel */
    .reg-shell .rs-benefit-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 0.75rem;
    }
    .reg-shell .rs-benefit-card {
        background: rgba(255, 255, 255, 0.09);
        backdrop-filter: blur(20px);
        -webkit-backdrop-filter: blur(20px);
        border: 1px solid rgba(255, 255, 255, 0.13);
        border-radius: 1.1rem;
        padding: 1.05rem;
        transition: transform 0.35s cubic-bezier(0.16, 1, 0.3, 1), background 0.3s ease, box-shadow 0.3s ease;
        position: relative;
        overflow: hidden;
    }
    .reg-shell .rs-benefit-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 2px;
        background: linear-gradient(90deg, rgba(16, 185, 129, 0.5), rgba(14, 165, 233, 0.4));
        opacity: 0;
        transition: opacity 0.3s ease;
    }
    .reg-shell .rs-benefit-card:hover {
        transform: translateY(-3px);
        background: rgba(255, 255, 255, 0.16);
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.18);
    }
    .reg-shell .rs-benefit-card:hover::before {
        opacity: 1;
    }
    .reg-shell .rs-benefit-icon {
        width: 38px;
        height: 38px;
        border-radius: 0.8rem;
        background: linear-gradient(135deg, rgba(16, 185, 129, 0.2), rgba(14, 165, 233, 0.15));
        display: inline-flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 0.55rem;
        font-size: 1rem;
        color: rgba(255, 255, 255, 0.9);
    }
    .reg-shell .rs-benefit-title {
        font-size: 0.82rem;
        font-weight: 600;
        color: #ffffff;
        margin-bottom: 0.2rem;
    }
    .reg-shell .rs-benefit-desc {
        font-size: 0.7rem;
        color: rgba(255, 255, 255, 0.5);
        line-height: 1.4;
    }

    /* Stats bar */
    .reg-shell .rs-stats-bar {
        display: flex;
        gap: 0.65rem;
        margin-bottom: 0.85rem;
    }
    .reg-shell .rs-mini-stat {
        flex: 1;
        background: rgba(255, 255, 255, 0.07);
        backdrop-filter: blur(14px);
        -webkit-backdrop-filter: blur(14px);
        border: 1px solid rgba(255, 255, 255, 0.1);
        border-radius: 0.85rem;
        padding: 0.65rem 0.5rem;
        text-align: center;
    }
    .reg-shell .rs-mini-stat-value {
        font-size: 1.1rem;
        font-weight: 700;
        color: #fff;
        letter-spacing: -0.02em;
    }
    .reg-shell .rs-mini-stat-label {
        font-size: 0.6rem;
        text-transform: uppercase;
        letter-spacing: 0.08em;
        color: rgba(255, 255, 255, 0.45);
        margin-top: 0.1rem;
    }

    /* Social proof strip */
    .reg-shell .rs-social-proof {
        display: flex;
        align-items: center;
        gap: 0.85rem;
        background: rgba(255, 255, 255, 0.08);
        backdrop-filter: blur(14px);
        -webkit-backdrop-filter: blur(14px);
        border: 1px solid rgba(255, 255, 255, 0.1);
        border-radius: 1.1rem;
        padding: 1rem 1.25rem;
        margin-top: 1rem;
    }
    .reg-shell .rs-avatar-stack {
        display: flex;
    }
    .reg-shell .rs-avatar-stack span {
        width: 30px;
        height: 30px;
        border-radius: 50%;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 0.65rem;
        font-weight: 700;
        color: #fff;
        border: 2px solid rgba(12, 18, 32, 0.5);
        margin-left: -8px;
    }
    .reg-shell .rs-avatar-stack span:first-child { margin-left: 0; }
    .reg-shell .rs-proof-text {
        font-size: 0.78rem;
        color: rgba(255, 255, 255, 0.8);
        line-height: 1.35;
    }
    .reg-shell .rs-proof-text strong {
        color: #fff;
    }
    .reg-shell .rs-proof-stars {
        display: flex;
        gap: 2px;
        margin-top: 0.2rem;
    }
    .reg-shell .rs-proof-stars i {
        font-size: 0.6rem;
        color: #f59e0b;
    }

    /* ── Right: form side ── */
    .reg-shell .rs-form-side {
        margin-left: 42%;
        width: 58%;
        min-height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 2rem 2.5rem;
        background:
            radial-gradient(ellipse at 15% 0%, rgba(16, 185, 129, 0.03) 0%, transparent 50%),
            radial-gradient(ellipse at 85% 100%, rgba(14, 165, 233, 0.03) 0%, transparent 50%),
            #fafbfc;
        position: relative;
        z-index: 2;
    }
    .reg-shell .rs-form-container {
        width: 100%;
        max-width: 480px;
    }

    /* Brand */
    .reg-shell .rs-brand {
        display: flex;
        align-items: center;
        gap: 0.85rem;
        margin-bottom: 1.75rem;
    }
    .reg-shell .rs-brand-logo {
        width: 48px;
        height: 48px;
        border-radius: 0.9rem;
        object-fit: contain;
        background: #fff;
        box-shadow: 0 4px 18px rgba(15, 23, 42, 0.1);
        border: 1px solid var(--rs-border);
        padding: 3px;
    }
    .reg-shell .rs-brand-name {
        font-size: 1.25rem;
        font-weight: 700;
        color: var(--rs-dark);
        letter-spacing: -0.02em;
    }
    .reg-shell .rs-brand-tagline {
        font-size: 0.72rem;
        color: var(--rs-muted);
    }

    /* Heading */
    .reg-shell .rs-heading-tag {
        display: inline-flex;
        align-items: center;
        gap: 0.4rem;
        background: linear-gradient(135deg, rgba(16, 185, 129, 0.08), rgba(14, 165, 233, 0.06));
        border: 1px solid rgba(16, 185, 129, 0.18);
        border-radius: 999px;
        padding: 0.28rem 0.8rem;
        font-size: 0.68rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.1em;
        color: var(--rs-emerald);
        margin-bottom: 0.75rem;
    }
    .reg-shell .rs-heading-tag .rs-dot {
        width: 6px;
        height: 6px;
        border-radius: 50%;
        background: var(--rs-emerald);
        animation: rsDotPulse 2s ease-in-out infinite;
    }
    .reg-shell .rs-heading h1 {
        font-size: 1.65rem;
        font-weight: 700;
        color: var(--rs-dark);
        letter-spacing: -0.03em;
        margin-bottom: 0.3rem;
    }
    .reg-shell .rs-heading p {
        font-size: 0.86rem;
        color: var(--rs-muted);
        margin-bottom: 0;
    }

    /* Steps indicator */
    .reg-shell .rs-steps {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        margin-top: 1rem;
        margin-bottom: 0.25rem;
    }
    .reg-shell .rs-step {
        flex: 1;
        height: 3px;
        border-radius: 999px;
        background: rgba(148, 163, 184, 0.25);
    }
    .reg-shell .rs-step.active {
        background: linear-gradient(90deg, var(--rs-emerald), var(--rs-sky));
    }

    /* Form card */
    .reg-shell .rs-card {
        background: var(--rs-surface);
        border: 1px solid var(--rs-border);
        border-radius: 1.5rem;
        padding: 1.85rem;
        box-shadow:
            0 1px 2px rgba(15, 23, 42, 0.03),
            0 8px 24px rgba(15, 23, 42, 0.06),
            0 24px 48px rgba(15, 23, 42, 0.04);
        margin-top: 1.25rem;
        position: relative;
        overflow: hidden;
    }
    .reg-shell .rs-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 3px;
        background: linear-gradient(90deg, var(--rs-emerald), var(--rs-sky), var(--rs-emerald));
        border-radius: 1.5rem 1.5rem 0 0;
    }
    .reg-shell .rs-card::after {
        content: '';
        position: absolute;
        top: -50%;
        right: -25%;
        width: 180px;
        height: 180px;
        border-radius: 50%;
        background: radial-gradient(circle, rgba(16, 185, 129, 0.05), transparent 65%);
        pointer-events: none;
    }

    /* Inputs */
    .reg-shell .rs-input-group {
        margin-bottom: 1.1rem;
        position: relative;
        z-index: 1;
    }
    .reg-shell .rs-input-group label {
        display: flex;
        align-items: center;
        gap: 0.35rem;
        font-size: 0.76rem;
        font-weight: 600;
        color: var(--rs-slate);
        margin-bottom: 0.35rem;
        letter-spacing: 0.02em;
    }
    .reg-shell .rs-input-group label i {
        font-size: 0.78rem;
        color: var(--rs-muted);
        opacity: 0.7;
    }
    .reg-shell .rs-card .form-control {
        border-radius: 0.85rem;
        border: 1.5px solid rgba(148, 163, 184, 0.35);
        background: #f8fafc;
        padding: 0.68rem 0.95rem;
        font-size: 0.9rem;
        color: var(--rs-dark);
        transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
    }
    .reg-shell .rs-card .form-control::placeholder {
        color: rgba(100, 116, 139, 0.5);
    }
    .reg-shell .rs-card .form-control:hover {
        border-color: rgba(148, 163, 184, 0.65);
        background: #fafbfe;
    }
    .reg-shell .rs-card .form-control:focus {
        border-color: var(--rs-sky);
        background: #ffffff;
        box-shadow: 0 0 0 3.5px var(--rs-sky-glow);
    }

    /* Two-column row */
    .reg-shell .rs-row {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 0.85rem;
    }

    /* Submit */
    .reg-shell .rs-submit {
        width: 100%;
        padding: 0.75rem 1.5rem;
        border: none;
        border-radius: 0.85rem;
        font-size: 0.93rem;
        font-weight: 600;
        letter-spacing: 0.01em;
        color: #ffffff;
        background: linear-gradient(135deg, var(--rs-dark) 0%, var(--rs-slate) 100%);
        cursor: pointer;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        position: relative;
        overflow: hidden;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
    }
    .reg-shell .rs-submit::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.08), transparent);
        transition: left 0.5s ease;
    }
    .reg-shell .rs-submit:hover {
        transform: translateY(-1px);
        box-shadow: 0 8px 25px rgba(12, 18, 32, 0.25);
    }
    .reg-shell .rs-submit:hover::before {
        left: 100%;
    }
    .reg-shell .rs-submit:active {
        transform: translateY(0);
    }

    /* Quick benefits row inside form */
    .reg-shell .rs-quick-benefits {
        display: flex;
        flex-wrap: wrap;
        gap: 0.5rem;
        margin-top: 1rem;
    }
    .reg-shell .rs-quick-chip {
        display: inline-flex;
        align-items: center;
        gap: 0.35rem;
        padding: 0.3rem 0.7rem;
        border-radius: 999px;
        background: rgba(16, 185, 129, 0.06);
        border: 1px solid rgba(16, 185, 129, 0.15);
        font-size: 0.72rem;
        font-weight: 500;
        color: var(--rs-muted);
    }
    .reg-shell .rs-quick-chip i {
        color: var(--rs-emerald);
        font-size: 0.7rem;
    }

    /* Trust row */
    .reg-shell .rs-trust {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 1.5rem;
        margin-top: 1.5rem;
        padding-top: 1rem;
        border-top: 1px solid var(--rs-border);
    }
    .reg-shell .rs-trust-item {
        display: flex;
        align-items: center;
        gap: 0.35rem;
        font-size: 0.72rem;
        color: var(--rs-muted);
    }
    .reg-shell .rs-trust-item i {
        font-size: 0.82rem;
        color: var(--rs-emerald);
    }

    /* Footer */
    .reg-shell .rs-footer {
        text-align: center;
        margin-top: 1.35rem;
        font-size: 0.78rem;
        color: var(--rs-muted);
    }
    .reg-shell .rs-footer a {
        color: var(--rs-dark);
        font-weight: 600;
        text-decoration: none;
        transition: color 0.2s ease;
    }
    .reg-shell .rs-footer a:hover {
        color: var(--rs-sky);
    }

    /* ── Animations ── */
    @media (prefers-reduced-motion: no-preference) {
        .reg-shell .rs-fade {
            opacity: 0;
            transform: translateY(14px);
            animation: rsFadeUp 0.65s cubic-bezier(0.16, 1, 0.3, 1) forwards;
        }
        .reg-shell .rs-fade[data-d="1"] { animation-delay: 0.05s; }
        .reg-shell .rs-fade[data-d="2"] { animation-delay: 0.12s; }
        .reg-shell .rs-fade[data-d="3"] { animation-delay: 0.2s; }
        .reg-shell .rs-fade[data-d="4"] { animation-delay: 0.28s; }
        .reg-shell .rs-fade[data-d="5"] { animation-delay: 0.36s; }
        .reg-shell .rs-fade[data-d="6"] { animation-delay: 0.44s; }
        .reg-shell .rs-fade[data-d="7"] { animation-delay: 0.52s; }

        .reg-shell .rs-slide {
            opacity: 0;
            transform: translateX(-25px);
            animation: rsSlide 0.8s cubic-bezier(0.16, 1, 0.3, 1) forwards;
        }
        .reg-shell .rs-slide[data-d="2"] { animation-delay: 0.15s; }
        .reg-shell .rs-slide[data-d="3"] { animation-delay: 0.3s; }
        .reg-shell .rs-slide[data-d="4"] { animation-delay: 0.45s; }
    }

    @keyframes rsFadeUp {
        to { opacity: 1; transform: translateY(0); }
    }
    @keyframes rsSlide {
        to { opacity: 1; transform: translateX(0); }
    }
    @keyframes rsDotPulse {
        0%, 100% { opacity: 1; }
        50% { opacity: 0.35; }
    }

    /* ── Responsive ── */
    @media (max-width: 991.98px) {
        .reg-shell .rs-visual { display: none; }
        .reg-shell .rs-form-side {
            margin-left: 0;
            width: 100%;
        }
    }
    @media (max-width: 767.98px) {
        .reg-shell .rs-form-side {
            padding: 2rem 1.25rem;
        }
        .reg-shell .rs-heading h1 {
            font-size: 1.45rem;
        }
        .reg-shell .rs-form-container {
            max-width: 100%;
        }
    }
    @media (max-width: 575.98px) {
        .reg-shell .rs-form-side {
            padding: 1.25rem 0.85rem;
        }
        .reg-shell .rs-brand-logo {
            width: 42px;
            height: 42px;
        }
        .reg-shell .rs-brand-name {
            font-size: 1.15rem;
        }
        .reg-shell .rs-heading h1 {
            font-size: 1.3rem;
        }
        .reg-shell .rs-heading p {
            font-size: 0.82rem;
        }
        .reg-shell .rs-card {
            padding: 1.25rem;
            border-radius: 1.15rem;
        }
        .reg-shell .rs-card .form-control {
            padding: 0.65rem 0.85rem;
            font-size: 0.88rem;
        }
        .reg-shell .rs-row {
            grid-template-columns: 1fr;
            gap: 0;
        }
        .reg-shell .rs-submit {
            padding: 0.65rem;
            font-size: 0.88rem;
        }
        .reg-shell .rs-trust {
            flex-direction: column;
            gap: 0.4rem;
        }
    }
    @media (max-width: 374.98px) {
        .reg-shell .rs-form-side {
            padding: 1rem 0.65rem;
        }
        .reg-shell .rs-card {
            padding: 1rem;
        }
    }

    /* ── Role picker ── */
    .reg-shell .rs-role-picker {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 0.75rem;
        margin-top: 1.15rem;
    }
    .reg-shell .rs-role-card {
        position: relative;
        background: var(--rs-surface);
        border: 2px solid var(--rs-border);
        border-radius: 1.15rem;
        padding: 1.1rem 1rem;
        cursor: pointer;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        text-align: center;
    }
    .reg-shell .rs-role-card:hover {
        border-color: rgba(14, 165, 233, 0.35);
        box-shadow: 0 4px 16px rgba(14, 165, 233, 0.08);
    }
    .reg-shell .rs-role-card.selected {
        border-color: var(--rs-sky);
        background: rgba(14, 165, 233, 0.03);
        box-shadow: 0 0 0 3px var(--rs-sky-glow), 0 4px 16px rgba(14, 165, 233, 0.1);
    }
    .reg-shell .rs-role-card.selected .rs-role-check {
        opacity: 1;
        transform: scale(1);
    }
    .reg-shell .rs-role-icon {
        width: 42px;
        height: 42px;
        border-radius: 0.85rem;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 0.55rem;
        font-size: 1.1rem;
    }
    .reg-shell .rs-role-card[data-role="client"] .rs-role-icon {
        background: rgba(16, 185, 129, 0.1);
        color: var(--rs-emerald);
    }
    .reg-shell .rs-role-card[data-role="agent"] .rs-role-icon {
        background: rgba(14, 165, 233, 0.1);
        color: var(--rs-sky);
    }
    .reg-shell .rs-role-name {
        font-size: 0.88rem;
        font-weight: 700;
        color: var(--rs-dark);
        margin-bottom: 0.15rem;
    }
    .reg-shell .rs-role-desc {
        font-size: 0.7rem;
        color: var(--rs-muted);
        line-height: 1.35;
    }
    .reg-shell .rs-role-check {
        position: absolute;
        top: 0.55rem;
        right: 0.55rem;
        width: 20px;
        height: 20px;
        border-radius: 50%;
        background: var(--rs-sky);
        color: #fff;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 0.6rem;
        opacity: 0;
        transform: scale(0.5);
        transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
    }
    .reg-shell .rs-agent-fields {
        max-height: 0;
        overflow: hidden;
        opacity: 0;
        transition: max-height 0.4s cubic-bezier(0.4, 0, 0.2, 1), opacity 0.3s ease;
    }
    .reg-shell .rs-agent-fields.show {
        max-height: 120px;
        opacity: 1;
    }
    @media (max-width: 575.98px) {
        .reg-shell .rs-role-picker { gap: 0.5rem; }
        .reg-shell .rs-role-icon { width: 36px; height: 36px; font-size: 0.95rem; }
        .reg-shell .rs-role-name { font-size: 0.82rem; }
        .reg-shell .rs-role-desc { font-size: 0.65rem; }
    }
</style>
@endpush

@section('content')
<div class="reg-shell">

    {{-- Left: cinematic image panel (desktop only) --}}
    <aside class="rs-visual" aria-hidden="true">
        <img src="{{ asset('assets/img/home/real-estate/hero/01.jpg') }}" alt="" class="rs-visual-img">
        <div class="rs-visual-overlay"></div>
        <div class="rs-visual-inner">
            {{-- Top --}}
            <div class="rs-slide">
                <a href="{{ url('/') }}" class="d-inline-flex align-items-center gap-2 text-decoration-none mb-4">
                    <img src="{{ asset('assets/img/francee.jpeg') }}" alt="Propsgh" style="height:34px; width:34px; border-radius:0.6rem; object-fit:contain; background:#fff; padding:2px;">
                    <span style="font-weight:700; font-size:1rem; color:#fff; letter-spacing:-0.01em;">Propsgh</span>
                </a>
                <h2 class="fw-bold mb-2" style="font-size:1.7rem; letter-spacing:-0.03em; line-height:1.2;">
                    Your next home<br>starts here.
                </h2>
                <p style="font-size:0.85rem; color:rgba(255,255,255,0.65); max-width:300px;">
                    Join thousands finding their perfect property across Ghana.
                </p>
            </div>

            {{-- Bottom --}}
            <div>
                {{-- Stats bar --}}
                <div class="rs-stats-bar rs-slide" data-d="2">
                    <div class="rs-mini-stat">
                        <div class="rs-mini-stat-value">2k+</div>
                        <div class="rs-mini-stat-label">Properties</div>
                    </div>
                    <div class="rs-mini-stat">
                        <div class="rs-mini-stat-value">850+</div>
                        <div class="rs-mini-stat-label">Users</div>
                    </div>
                    <div class="rs-mini-stat">
                        <div class="rs-mini-stat-value">4.8</div>
                        <div class="rs-mini-stat-label">Rating</div>
                    </div>
                </div>

                {{-- Benefit cards --}}
                <div class="rs-benefit-grid rs-slide" data-d="3">
                    <div class="rs-benefit-card">
                        <div class="rs-benefit-icon"><i class="fi-bookmark"></i></div>
                        <div class="rs-benefit-title">Save Listings</div>
                        <div class="rs-benefit-desc">Bookmark favorites for quick access later.</div>
                    </div>
                    <div class="rs-benefit-card">
                        <div class="rs-benefit-icon"><i class="fi-bell"></i></div>
                        <div class="rs-benefit-title">Instant Alerts</div>
                        <div class="rs-benefit-desc">Get notified when new places match your criteria.</div>
                    </div>
                    <div class="rs-benefit-card">
                        <div class="rs-benefit-icon"><i class="fi-calendar"></i></div>
                        <div class="rs-benefit-title">Book Tours</div>
                        <div class="rs-benefit-desc">Schedule property visits at your convenience.</div>
                    </div>
                    <div class="rs-benefit-card">
                        <div class="rs-benefit-icon"><i class="fi-home"></i></div>
                        <div class="rs-benefit-title">Shortlet Stays</div>
                        <div class="rs-benefit-desc">Flexible short-term rentals across the country.</div>
                    </div>
                </div>

                {{-- Social proof --}}
                <div class="rs-social-proof rs-slide" data-d="4">
                    <div class="rs-avatar-stack">
                        <span style="background:linear-gradient(135deg,#f59e0b,#ef4444);">AK</span>
                        <span style="background:linear-gradient(135deg,#10b981,#0ea5e9);">NM</span>
                        <span style="background:linear-gradient(135deg,#8b5cf6,#ec4899);">KA</span>
                        <span style="background:linear-gradient(135deg,#0ea5e9,#6366f1);">EO</span>
                    </div>
                    <div>
                        <div class="rs-proof-text">
                            <strong>850+ tenants</strong> found their home through Propsgh
                        </div>
                        <div class="rs-proof-stars">
                            <i class="fi-star-filled"></i>
                            <i class="fi-star-filled"></i>
                            <i class="fi-star-filled"></i>
                            <i class="fi-star-filled"></i>
                            <i class="fi-star-filled"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </aside>

    {{-- Right: form panel --}}
    <div class="rs-form-side">
        <div class="rs-form-container">

            {{-- Brand (mobile only) --}}
            <div class="rs-brand rs-fade d-lg-none" data-d="1">
                <img src="{{ asset('assets/img/francee.jpeg') }}" alt="Propsgh" class="rs-brand-logo">
                <div>
                    <div class="rs-brand-name">Propsgh</div>
                    <div class="rs-brand-tagline">Properties &amp; shortlet stays</div>
                </div>
            </div>

            {{-- Heading --}}
            <div class="rs-heading rs-fade" data-d="2">
                <div class="rs-heading-tag">
                    <span class="rs-dot"></span>
                    Get started free
                </div>
                <h1>Create your account</h1>
                <p>Choose your account type and get started with Propsgh.</p>

                {{-- Role picker --}}
                <div class="rs-role-picker">
                    <div class="rs-role-card {{ old('account_type', 'client') === 'client' ? 'selected' : '' }}" data-role="client">
                        <span class="rs-role-check"><i class="fi-check"></i></span>
                        <div class="rs-role-icon"><i class="fi-user"></i></div>
                        <div class="rs-role-name">Individual</div>
                        <div class="rs-role-desc">Browse &amp; book properties</div>
                    </div>
                    <div class="rs-role-card {{ old('account_type') === 'agent' ? 'selected' : '' }}" data-role="agent">
                        <span class="rs-role-check"><i class="fi-check"></i></span>
                        <div class="rs-role-icon"><i class="fi-briefcase"></i></div>
                        <div class="rs-role-name">Agent</div>
                        <div class="rs-role-desc">List &amp; manage properties</div>
                    </div>
                </div>
            </div>

            {{-- Form card --}}
            <div class="rs-card rs-fade" data-d="3">
                <form class="needs-validation" novalidate method="POST" action="{{ route('register') }}">
                    @csrf
                    <input type="hidden" name="account_type" id="account_type" value="{{ old('account_type', 'client') }}">

                    @error('account_type')
                        <div class="alert alert-danger py-2 fs-sm mb-3">{{ $message }}</div>
                    @enderror

                    {{-- Full name --}}
                    <div class="rs-input-group">
                        <label for="name"><i class="fi-user"></i> Full name</label>
                        <input
                            type="text"
                            id="name"
                            name="name"
                            class="form-control @error('name') is-invalid @enderror"
                            placeholder="Your full name"
                            value="{{ old('name') }}"
                            required
                            autocomplete="name"
                            autofocus
                        >
                        @error('name')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Email --}}
                    <div class="rs-input-group">
                        <label for="email"><i class="fi-mail"></i> Email address</label>
                        <input
                            type="email"
                            id="email"
                            name="email"
                            class="form-control @error('email') is-invalid @enderror"
                            placeholder="you@example.com"
                            value="{{ old('email') }}"
                            required
                            inputmode="email"
                            autocapitalize="none"
                            spellcheck="false"
                            autocomplete="email"
                        >
                        @error('email')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Company name (agent only) --}}
                    <div class="rs-agent-fields {{ old('account_type') === 'agent' ? 'show' : '' }}" id="agentFields">
                        <div class="rs-input-group">
                            <label for="company_name"><i class="fi-briefcase"></i> Company / Agency name</label>
                            <input
                                type="text"
                                id="company_name"
                                name="company_name"
                                class="form-control @error('company_name') is-invalid @enderror"
                                placeholder="Your company or agency name"
                                value="{{ old('company_name') }}"
                                autocomplete="organization"
                            >
                            @error('company_name')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    {{-- Password row --}}
                    <div class="rs-row">
                        <div class="rs-input-group">
                            <label for="password"><i class="fi-lock"></i> Password</label>
                            <div class="password-toggle">
                                <input
                                    type="password"
                                    id="password"
                                    name="password"
                                    class="form-control @error('password') is-invalid @enderror"
                                    placeholder="Min. 8 characters"
                                    required
                                    autocomplete="new-password"
                                >
                                <label class="password-toggle-button fs-lg" aria-label="Show/hide password">
                                    <input type="checkbox" class="btn-check">
                                </label>
                            </div>
                            @error('password')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="rs-input-group">
                            <label for="password_confirmation"><i class="fi-lock"></i> Confirm</label>
                            <div class="password-toggle">
                                <input
                                    type="password"
                                    id="password_confirmation"
                                    name="password_confirmation"
                                    class="form-control @error('password_confirmation') is-invalid @enderror"
                                    placeholder="Retype password"
                                    required
                                    autocomplete="new-password"
                                >
                                <label class="password-toggle-button fs-lg" aria-label="Show/hide password">
                                    <input type="checkbox" class="btn-check">
                                </label>
                            </div>
                            @error('password_confirmation')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    {{-- Terms --}}
                    <div class="form-check mb-3" style="margin-top:0.25rem;">
                        <input
                            type="checkbox"
                            class="form-check-input @error('terms') is-invalid @enderror"
                            id="terms"
                            name="terms"
                            value="1"
                            {{ old('terms') ? 'checked' : '' }}
                            required
                        >
                        <label for="terms" class="form-check-label" style="font-size:0.8rem;">
                            I accept the
                            <a style="color:var(--rs-dark); font-weight:600;" href="{{ url('/terms') }}">Terms</a>
                            &amp;
                            <a style="color:var(--rs-dark); font-weight:600;" href="{{ url('/privacy') }}">Privacy Policy</a>
                        </label>
                        @error('terms')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @else
                            <div class="invalid-feedback">You must accept to continue.</div>
                        @enderror
                    </div>

                    {{-- Submit --}}
                    <button type="submit" class="rs-submit">
                        Create account
                        <i class="fi-chevron-right" style="font-size:0.85rem;"></i>
                    </button>

                    {{-- Quick benefits --}}
                    <div class="rs-quick-benefits">
                        <span class="rs-quick-chip"><i class="fi-shield"></i> Secure signup</span>
                        <span class="rs-quick-chip"><i class="fi-clock"></i> 2 min setup</span>
                        <span class="rs-quick-chip"><i class="fi-check-circle"></i> Free forever</span>
                    </div>
                </form>
            </div>

            {{-- Trust indicators --}}
            <div class="rs-trust rs-fade" data-d="5">
                <div class="rs-trust-item">
                    <i class="fi-shield"></i>
                    <span>Encrypted data</span>
                </div>
                <div class="rs-trust-item">
                    <i class="fi-check-circle"></i>
                    <span>Verified listings</span>
                </div>
                <div class="rs-trust-item">
                    <i class="fi-headset"></i>
                    <span>24/7 support</span>
                </div>
            </div>

            {{-- Footer --}}
            <div class="rs-footer rs-fade" data-d="6">
                Already have an account?
                <a href="{{ route('login') }}">Sign in</a>
            </div>

            <div class="rs-fade" data-d="7" style="text-align:center; margin-top:0.85rem;">
                <span style="font-size:0.68rem; color:var(--rs-muted);">
                    &copy; {{ now()->year }} Propsgh. All rights reserved.
                </span>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const cards = document.querySelectorAll('.rs-role-card');
    const input = document.getElementById('account_type');
    const agentFields = document.getElementById('agentFields');

    cards.forEach(function (card) {
        card.addEventListener('click', function () {
            cards.forEach(function (c) { c.classList.remove('selected'); });
            card.classList.add('selected');
            input.value = card.dataset.role;

            if (card.dataset.role === 'agent') {
                agentFields.classList.add('show');
            } else {
                agentFields.classList.remove('show');
            }
        });
    });
});
</script>
@endpush
