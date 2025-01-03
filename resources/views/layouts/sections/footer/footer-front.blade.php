<!-- Footer: Start -->
<footer class="landing-footer bg-body footer-text">
  <div class="footer-top position-relative overflow-hidden z-1 d-none">
    <img src="{{asset('assets/img/front-pages/backgrounds/footer-bg.png')}}" alt="footer bg" class="footer-bg banner-bg-img z-n1" />
    <div class="container">
      <div class="row gx-0 gy-6 g-lg-10">
        <div class="col-lg-6">
          <a href="javascript:;" class="app-brand-link mb-6">
            <span class="app-brand-logo demo">@include('_partials.macros',["width"=>25,"withbg"=>'var(--bs-primary)'])</span>
            <span class="app-brand-text demo text-white fw-bold ms-2 ps-1">{{config('variables.templateName')}}</span>
          </a>
          <p class="footer-text footer-logo-description mb-6">
            Long & Short Term Apartment Rentals in Rome, Milan - Italy
          </p>
        </div>
        <div class="col-lg-6">
          <h6 class="footer-title mb-6"></h6>
          <ul class="list-unstyled">
            <li class="mb-4">
              <a href="/terms-and-conditions" target="_blank" class="footer-link">{{ __('Terms of Service') }}</a>
            </li>
            <li class="mb-4">
              <a href="/privacy-policy" target="_blank" class="footer-link">{{ __('Privacy Policy') }}</a>
            </li>
            <li class="mb-4">
              <a href="/faq" target="_blank" class="footer-link">{{ __('FAQ') }}</a>
            </li>
            <li class="mb-4">
              <a href="/contact-us" target="_blank" class="footer-link">{{ __('Contact Us') }}</a>
            </li>
          </ul>
        </div>

      </div>
    </div>
  </div>
  <div class="footer-bottom py-3 py-md-5">
    <div class="container d-flex flex-wrap justify-content-between flex-md-row flex-column text-center text-md-start">
      <div class="mb-2 mb-md-0">
        <span class="footer-bottom-text">©
          <script>
          document.write(new Date().getFullYear());

          </script>
        </span>
        <a href="javascript:;" target="_blank" class="text-white">{{config('variables.creatorName')}} &nbsp;&nbsp;-&nbsp;&nbsp; </a>
        <span class="footer-bottom-text"> Long & Short Term Apartment Rentals in Rome, Milan, Italy.</span>
      </div>
      <div class="d-none d-lg-inline-block">
        <a href="/terms-and-conditions" target="_blank" class="footer-link me-4">{{ __('Terdfgdfsgms of Service') }}</a>
        <a href="/privacy-policy" target="_blank" class="footer-link me-4">{{ __('Privacy Policy') }}</a>
        {{-- <a href="javascript:;" class="me-4" target="_blank">
          <img src="{{asset('assets/img/front-pages/icons/github.svg')}}" alt="github icon" />
        </a>
        <a href="javascript:;" class="me-4" target="_blank">
          <img src="{{asset('assets/img/front-pages/icons/facebook.svg')}}" alt="facebook icon" />
        </a>
        <a href="javascript:;" class="me-4" target="_blank">
          <img src="{{asset('assets/img/front-pages/icons/twitter.svg')}}" alt="twitter icon" />
        </a>
        <a href="javascript:;" target="_blank">
          <img src="{{asset('assets/img/front-pages/icons/instagram.svg')}}" alt="google icon" />
        </a> --}}
      </div>
    </div>
  </div>
</footer>
<!-- Footer: End -->
