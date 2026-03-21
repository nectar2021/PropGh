<!-- Page footer -->
<footer class="ft" data-bs-theme="dark">

  {{-- ── Newsletter CTA ── --}}
  <div class="ft-cta">
    <div class="ft-cta-glow"></div>
    <div class="ft-cta-inner">
      <div class="ft-cta-text">
        <span class="ft-cta-badge"><i class="fi-bell"></i> Propsgh Insider</span>
        <h3 class="ft-cta-title">Get curated stays &amp; investment alerts</h3>
        <p class="ft-cta-sub">Weekly drops of verified listings, pricing trends, and shortlet openings across Ghana.</p>
      </div>
      <livewire:newsletter-form />
      <p class="ft-cta-note">No spam, ever. Unsubscribe any time.</p>
    </div>
  </div>

  {{-- ── Main grid ── --}}
  <div class="ft-body">
    <div class="ft-grid">

      {{-- Brand column --}}
      <div class="ft-brand-col">
        <a href="{{ route('home') }}" class="ft-brand-link">
          <span class="ft-logo-wrap">
            <svg viewBox="0 0 28 32" fill="none" xmlns="http://www.w3.org/2000/svg" class="ft-logo-svg">
              <path d="M4.5 2C2.5 2 1 3.8 1 6v8c0 2.2 1.5 4 3.5 4h3c2 0 3.5-1.8 3.5-4V6c0-2.2-1.5-4-3.5-4h-3Z" fill="currentColor"/>
              <path d="M16.5 8c-2 0-3.5 1.8-3.5 4v12c0 2.2 1.5 4 3.5 4h3c2 0 3.5-1.8 3.5-4V12c0-2.2-1.5-4-3.5-4h-3Z" fill="currentColor" opacity=".72"/>
            </svg>
          </span>
          <span class="ft-brand-text">
            <span class="ft-brand-name">Props<span class="ft-brand-accent">gh</span></span>
            <span class="ft-brand-tag">Discover &middot; Book &middot; Host</span>
          </span>
        </a>
        <p class="ft-brand-desc">{{ ($footerSettings['brand_description'] ?? '') ?: 'Premium stays and investments across Ghana — curated, verified, and supported by local experts.' }}</p>

        <div class="ft-contact-list">
          <a href="mailto:{{ ($footerSettings['contact_email'] ?? '') ?: 'hello@propsgh.com' }}" class="ft-contact-item">
            <i class="fi-mail"></i> {{ ($footerSettings['contact_email'] ?? '') ?: 'hello@propsgh.com' }}
          </a>
          <a href="tel:{{ Str::replace(' ', '', ($footerSettings['contact_phone'] ?? '') ?: '+233200000000') }}" class="ft-contact-item">
            <i class="fi-phone-call"></i> {{ ($footerSettings['contact_phone'] ?? '') ?: '+233 20 000 0000' }}
          </a>
        </div>

        <div class="ft-socials">
          @php
            $socials = [
              'instagram' => ['icon' => 'fi-instagram', 'label' => 'Instagram'],
              'facebook'  => ['icon' => 'fi-facebook',  'label' => 'Facebook'],
              'twitter'   => ['icon' => 'fi-x',         'label' => 'Twitter'],
              'youtube'   => ['icon' => 'fi-youtube',    'label' => 'YouTube'],
            ];
          @endphp
          @foreach($socials as $key => $social)
            @php $url = ($footerSettings["social_{$key}"] ?? '') ?: ''; @endphp
            <a href="{{ $url ?: '#!' }}" class="ft-social" aria-label="{{ $social['label'] }}" @if($url) target="_blank" rel="noopener" @endif><i class="{{ $social['icon'] }}"></i></a>
          @endforeach
        </div>
      </div>

      {{-- Link columns --}}
      <div class="ft-links-col">
        <h6 class="ft-heading">Explore</h6>
        <ul class="ft-links">
          <li><a href="{{ route('home') }}">Home</a></li>
          <li><a href="{{ route('properties.index') }}">Browse properties</a></li>
          <li><a href="{{ route('contact') }}">Contact us</a></li>
        </ul>
      </div>

      <div class="ft-links-col">
        <h6 class="ft-heading">Stays</h6>
        <ul class="ft-links">
          <li><a href="{{ route('properties.index', ['type' => 'apartment']) }}">Apartments</a></li>
          <li><a href="{{ route('properties.index', ['type' => 'house']) }}">Houses</a></li>
          <li><a href="{{ route('properties.index', ['type' => 'shortlet']) }}">Shortlets</a></li>
          <li><a href="{{ route('properties.index', ['type' => 'condo']) }}">Condos</a></li>
          <li><a href="{{ route('properties.index', ['type' => 'studio']) }}">Studios</a></li>
        </ul>
      </div>

      <div class="ft-links-col">
        <h6 class="ft-heading">Support</h6>
        <ul class="ft-links">
          <li><a href="{{ route('contact') }}">Help center</a></li>
          <li><a href="{{ route('contact') }}">FAQs</a></li>
          <li><a href="{{ route('terms') }}">Terms of service</a></li>
          <li><a href="{{ route('privacy') }}">Privacy policy</a></li>
          <li><a href="{{ route('contact') }}">Report a listing</a></li>
        </ul>
      </div>

      <div class="ft-links-col">
        <h6 class="ft-heading">For hosts</h6>
        <p class="ft-host-desc">Earn more from verified tenants and shortlet guests.</p>
        <a href="{{ route('properties.index') }}" class="ft-host-btn">
          <i class="fi-plus"></i> List a property
        </a>
        <a href="{{ route('contact') }}" class="ft-host-link">Talk to our team &rarr;</a>
      </div>
    </div>

    {{-- ── Stats ribbon ── --}}
    <div class="ft-stats">
      <div class="ft-stat">
        <span class="ft-stat-num">{{ ($footerSettings['stat_rating'] ?? '') ?: '4.9/5' }}</span>
        <span class="ft-stat-label">{{ ($footerSettings['stat_rating_label'] ?? '') ?: 'Guest rating' }}</span>
      </div>
      <div class="ft-stat-sep"></div>
      <div class="ft-stat">
        <span class="ft-stat-num">{{ number_format($livePropertyCount ?? 0) }}+</span>
        <span class="ft-stat-label">Verified homes</span>
      </div>
      <div class="ft-stat-sep"></div>
      <div class="ft-stat">
        <span class="ft-stat-num">{{ ($footerSettings['stat_support'] ?? '') ?: '24/7' }}</span>
        <span class="ft-stat-label">{{ ($footerSettings['stat_support_label'] ?? '') ?: 'Support' }}</span>
      </div>
      <div class="ft-stat-sep"></div>
      <div class="ft-stat">
        <span class="ft-stat-num">{{ ($footerSettings['stat_satisfaction'] ?? '') ?: '98%' }}</span>
        <span class="ft-stat-label">{{ ($footerSettings['stat_satisfaction_label'] ?? '') ?: 'Satisfaction' }}</span>
      </div>
    </div>

    {{-- ── Bottom bar ── --}}
    <div class="ft-bottom">
      <p class="ft-copy">&copy; {{ now()->year }} Propsgh. All rights reserved.</p>
      <div class="ft-bottom-links">
        <a href="{{ route('terms') }}">Terms</a>
        <a href="{{ route('privacy') }}">Privacy</a>
        <a href="{{ route('home') }}">Sitemap</a>
      </div>
    </div>
  </div>
</footer>
