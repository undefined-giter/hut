<div class="footer-message">
    <p>
        @if ( $adminPhoneHref && $adminPhone )
            <a href="tel:{{ $adminPhoneHref }}">{{ $adminPhone }}</a><br>
        @endif
        Cabane - Châtel-En-Trièves / Cordéac
    </p>

    <img src="{{ asset('img/hut.png') }}" loading="lazy" alt="Représentation de la Cabane">
</div>
