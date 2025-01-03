@php
    $containerFooter =
        isset($configData['contentLayout']) && $configData['contentLayout'] === 'compact'
            ? 'container-xxl'
            : 'container-fluid';
@endphp

<!-- Footer-->
<footer class="content-footer footer bg-footer-theme">
    <div class="{{ $containerFooter }}">
        <div class="footer-container d-flex align-items-center justify-content-between py-4 flex-md-row flex-column">
            <div class="text-body">
                ©
                <script>
                    document.write(new Date().getFullYear())
                </script>, made with ❤️ by <a
                    href="{{ !empty(config('variables.creatorUrl')) ? config('variables.creatorUrl') : '' }}"
                    target="_blank"
                    class="footer-link">{{ !empty(config('variables.creatorName')) ? config('variables.creatorName') : '' }}</a>
            </div>
            <div class="d-none d-lg-inline-block">

              <a href="{{ route('terms_of_service')  }}" target="_blank" class="footer-link me-4">Terms of Service</a>
              <a href="{{ route('privacy_policy')  }}" target="_blank" class="footer-link me-4">Privacy Policy</a>
              {{-- <a href="{{ config('variables.contact') ? config('variables.contact') : '#' }}" class="footer-link me-4" target="_blank">Contact</a>
              <a href="{{ config('variables.terms_of_service') ? config('variables.terms_of_service') : '#' }}" target="_blank" class="footer-link me-4">Terms and Conditions</a>
              <a href="{{ config('variables.privacy_policy') ? config('variables.privacy_policy') : '#' }}" target="_blank" class="footer-link me-4">Privacy Policy</a>
              <a href="{{ config('variables.faq') ? config('variables.faq') : '#' }}" target="_blank" class="footer-link d-none d-sm-inline-block">FAQ</a> --}}
            </div>
        </div>
    </div>
</footer>
<!--/ Footer-->
