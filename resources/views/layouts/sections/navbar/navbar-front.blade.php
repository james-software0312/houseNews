@php
    use Illuminate\Support\Facades\Auth;
    use Illuminate\Support\Facades\Route;
    $currentRouteName = Route::currentRouteName();
    $activeRoutes = ['front-pages-pricing', 'front-pages-payment', 'front-pages-checkout', 'front-pages-help-center'];
    $activeClass = in_array($currentRouteName, $activeRoutes) ? 'active' : '';
@endphp
<!-- Navbar: Start -->
<nav class="layout-navbar shadow-none py-0">
    <div class="container">
        <div class="navbar navbar-expand-lg landing-navbar px-3 px-md-8">
            <!-- Menu logo wrapper: Start -->
            <div class="navbar-brand app-brand demo d-flex py-0 me-4 me-xl-8">
                <!-- Mobile menu toggle: Start-->
                <button class="navbar-toggler border-0 px-0 me-4" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                    aria-label="Toggle navigation">
                    <i class="tf-icons bx bx-menu bx-lg align-middle text-heading fw-medium"></i>
                </button>
                <!-- Mobile menu toggle: End-->
                <a href="{{url('/')}}" class="app-brand-link">
                    {{-- <span class="app-brand-logo demo">@include('_partials.macros', ['width' => 25, 'withbg' => 'var(--bs-primary)'])</span> --}}
                  <span class="app-brand-logo demo">
                    <img src="{{asset('assets/img/logo.png')}}" alt="footer-logo" class="float-right">
                  </span>
                  {{-- <span class="app-brand-text demo menu-text fw-bold ms-2 ps-1">{{ config('variables.templateName') }}</span> --}}
                </a>
            </div>
            <!-- Menu logo wrapper: End -->
            <!-- Menu wrapper: Start -->
            <div class="collapse navbar-collapse landing-nav-menu" id="navbarSupportedContent">
                <button class="navbar-toggler border-0 text-heading position-absolute end-0 top-0 scaleX-n1-rtl p-2"
                    type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
                    aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <i class="tf-icons bx bx-x bx-lg"></i>
                </button>
                <ul class="navbar-nav me-auto mx-4">
                    {{-- <li class="nav-item">
                        <a class="nav-link fw-medium" aria-current="page" href="/">{{ __('Home') }}</a>
                    </li> --}}
                    <li class="nav-item">
                        <a class="nav-link fw-medium" href="/terms-and-conditions">{{ __('Terms of Service') }}</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link fw-medium" href="/privacy-policy">{{ __('Privacy Policy') }}</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link fw-medium" href="/faq">{{ __('FAQ') }}</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link fw-medium" href="/contact-us">{{ __('Contact Us') }}</a>
                    </li>

                    {{-- @if (Auth::check())
                        <li class="nav-item">
                            <a class="nav-link fw-medium" href="{{ route('dashboard') }}">{{ __('Panel') }}</a>
                        </li>
                    @endif --}}
                </ul>
            </div>
            <div class="landing-menu-overlay d-lg-none"></div>
                <!-- Menu wrapper: End -->

                <!-- Toolbar: Start -->
                <ul class="navbar-nav flex-row align-items-center ms-auto">
                    <!-- Language -->
                    <li class="nav-item dropdown-language dropdown me-2 me-xl-0">
                        <a class="nav-link dropdown-toggle hide-arrow" href="javascript:void(0);" data-bs-toggle="dropdown">
                            <i class='bx bx-globe bx-md'></i>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li>
                                <a class="dropdown-item {{ app()->getLocale() === 'en' ? 'active' : '' }}"
                                    href="{{ url('lang/en') }}" data-language="en" data-text-direction="ltr">
                                    <span>English</span>
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item {{ app()->getLocale() === 'it' ? 'active' : '' }}"
                                    href="{{ url('lang/it') }}" data-language="it" data-text-direction="ltr">
                                    <span>Italiano</span>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <!-- /Language -->
                @if ($configData['hasCustomizer'] == true)
                    <!-- Style Switcher -->
                    <li class="nav-item dropdown-style-switcher dropdown me-2 me-xl-1">
                        <a class="nav-link dropdown-toggle hide-arrow" href="javascript:void(0);"
                            data-bs-toggle="dropdown">
                            <i class='bx bx-lg'></i>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end dropdown-styles">
                            <li>
                                <a class="dropdown-item" href="javascript:void(0);" data-theme="light">
                                    <span class="align-middle"><i class='bx bx-md bx-sun me-3'></i>{{ __('Light') }}</span>
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="javascript:void(0);" data-theme="dark">
                                    <span class="align-middle"><i class="bx bx-md bx-moon me-3"></i>{{ __('Dark') }}</span>
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="javascript:void(0);" data-theme="system">
                                    <span class="align-middle"><i class="bx bx-md bx-desktop me-3"></i>{{ __('System') }}</span>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <!-- / Style Switcher-->
                @endif
                <!-- navbar button: Start -->
                <li>
                    <a href="{{ route('login') }}" class="btn btn-primary" ><span
                            class="tf-icons bx bx-log-in-circle scaleX-n1-rtl me-md-1"></span><span
                            class="d-none d-md-block">{{ __('Login') }}/{{ __('Register') }}</span></a>
                </li>
                <!-- navbar button: End -->
            </ul>
            <!-- Toolbar: End -->
        </div>
    </div>
</nav>
<!-- Navbar: End -->
