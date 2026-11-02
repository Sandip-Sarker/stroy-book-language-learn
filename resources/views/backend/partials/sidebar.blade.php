@php
    $systemSetting = App\Models\SystemSetting::first();
    $logo =
        $systemSetting && $systemSetting->logo
            ? url(\Illuminate\Support\Facades\Storage::url($systemSetting->logo))
            : null;
@endphp

<div class="sticky">
    <div class="app-sidebar__overlay" data-bs-toggle="sidebar"></div>
    <div class="app-sidebar">
        <div class="side-header">
            <a class="header-brand1" href="{{ route('dashboard') }}">
                <img src="{{ $logo ?? asset('backend/images/brand/logo.png') }}" class="header-brand-img desktop-logo" alt="logo">
                <img src="{{ $logo ?? asset('backend/images/brand/logo.png') }}" class="header-brand-img toggle-logo"
                    alt="logo">
                <img src="{{ $logo ?? asset('backend/images/brand/logo.png') }}" class="header-brand-img light-logo" alt="logo">
                <img src="{{ $logo ?? asset('backend/images/brand/logo.png') }}" class="header-brand-img light-logo1"
                    alt="logo">
            </a>
        </div>

        <div class="main-sidemenu">
            <div class="slide-left disabled" id="slide-left">
                <svg xmlns="http://www.w3.org/2000/svg" fill="#7b8191" width="24" height="24"
                    viewBox="0 0 24 24">
                    <path d="M13.293 6.293 7.586 12l5.707 5.707 1.414-1.414L10.414 12l4.293-4.293z" />
                </svg>
            </div>

            <ul class="side-menu">
                <li class="slide">
                    <a class="side-menu__item has-link" data-bs-toggle="slide" href="{{ route('dashboard') }}">
                        <svg class="mx-2" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-house-icon lucide-house"><path d="M15 21v-8a1 1 0 0 0-1-1h-4a1 1 0 0 0-1 1v8"/><path d="M3 10a2 2 0 0 1 .709-1.528l7-6a2 2 0 0 1 2.582 0l7 6A2 2 0 0 1 21 10v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/></svg>
                        <span class="side-menu__label">Dashboard</span>
                    </a>
                </li>

                {{-- Language --}}
                <li class="slide">
                    <a class="side-menu__item has-link" data-bs-toggle="slide" href="{{ route('language.index') }}">
                        <svg class="mx-2" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-languages-icon lucide-languages"><path d="m5 8 6 6"/><path d="m4 14 6-6 2-3"/><path d="M2 5h12"/><path d="M7 2h1"/><path d="m22 22-5-10-5 10"/><path d="M14 18h6"/></svg>
                        <span class="side-menu__label">Language</span>
                    </a>
                </li>

                {{-- Artist --}}
                <li class="slide">
                    <a class="side-menu__item has-link" data-bs-toggle="slide" href="{{ route('artist.index') }}">
                        <svg class="mx-2" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-mic-vocal-icon lucide-mic-vocal"><path d="m11 7.601-5.994 8.19a1 1 0 0 0 .1 1.298l.817.818a1 1 0 0 0 1.314.087L15.09 12"/><path d="M16.5 21.174C15.5 20.5 14.372 20 13 20c-2.058 0-3.928 2.356-6 2-2.072-.356-2.775-3.369-1.5-4.5"/><circle cx="16" cy="7" r="5"/></svg>
                        <span class="side-menu__label">Artist</span>
                    </a>
                </li>

                {{-- Category --}}
                <li class="slide">
                    <a class="side-menu__item has-link" data-bs-toggle="slide" href="{{ route('song.category.index') }}">
                       <svg class="mx-2" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-menu-icon lucide-menu"><path d="M4 5h16"/><path d="M4 12h16"/><path d="M4 19h16"/></svg>
                        <span class="side-menu__label">Category</span>
                    </a>
                </li>


                {{-- Song --}}
                <li class="slide">
                    <a class="side-menu__item has-link" data-bs-toggle="slide" href="{{ route('song.index') }}">
                      <svg class="mx-2" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-audio-lines-icon lucide-audio-lines"><path d="M2 10v3"/><path d="M6 6v11"/><path d="M10 3v18"/><path d="M14 8v7"/><path d="M18 5v13"/><path d="M22 10v3"/></svg>
                        <span class="side-menu__label">Song</span>
                    </a>
                </li>


                {{-- Song --}}
{{--                <li class="slide {{ request()->is('admin/settings*') ? 'active is-expanded' : '' }}">--}}
{{--                    <a class="side-menu__item {{ request()->is('admin/settings*') ? 'active is-expanded' : '' }}"--}}
{{--                       data-bs-toggle="slide" href="#">--}}
{{--                        <i class="fa fa-headphones px-2"></i>--}}
{{--                        <span class="side-menu__label">Songs</span><i class="angle fa fa-angle-right"></i>--}}
{{--                    </a>--}}

{{--                    <ul class="slide-menu">--}}
{{--                        <li><a href="{{ route('song.category.index') }}" class="slide-item">Category</a></li>--}}
{{--                        <li><a href="{{ route('song.index') }}" class="slide-item">Song</a></li>--}}
{{--                    </ul>--}}
{{--                </li>--}}

                {{-- Lyrics --}}
{{--                <li class="slide">--}}
{{--                    <a class="side-menu__item has-link" data-bs-toggle="slide" href="{{ route('lyrics.index') }}">--}}
{{--                        <i class="fa fa-music px-2"></i>--}}
{{--                        <span class="side-menu__label">Lyrics</span>--}}
{{--                    </a>--}}
{{--                </li>--}}

                {{-- Vocabulary --}}
{{--                <li class="slide">--}}
{{--                    <a class="side-menu__item has-link" data-bs-toggle="slide" href="{{ route('vocabulary.index') }}">--}}
{{--                        <i class="fa fa-book px-2"></i>--}}
{{--                        <span class="side-menu__label">Vocabulary</span>--}}
{{--                    </a>--}}
{{--                </li>--}}

                {{-- QIZ --}}
                <li class="slide">
                    <a class="side-menu__item has-link" data-bs-toggle="slide" href="{{ route('qiz.index') }}">
                        <svg class="mx-2" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-lightbulb-icon lucide-lightbulb"><path d="M15 14c.2-1 .7-1.7 1.5-2.5 1-.9 1.5-2.2 1.5-3.5A6 6 0 0 0 6 8c0 1 .2 2.2 1.5 3.5.7.7 1.3 1.5 1.5 2.5"/><path d="M9 18h6"/><path d="M10 22h4"/></svg>
                        <span class="side-menu__label">QIZ</span>
                    </a>
                </li>

                {{-- Achievement --}}
                <li class="slide">
                    <a class="side-menu__item has-link" data-bs-toggle="slide" href="{{ route('achievement.index') }}">
                       <svg class="mx-2" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-award-icon lucide-award"><path d="m15.477 12.89 1.515 8.526a.5.5 0 0 1-.81.47l-3.58-2.687a1 1 0 0 0-1.197 0l-3.586 2.686a.5.5 0 0 1-.81-.469l1.514-8.526"/><circle cx="12" cy="8" r="6"/></svg>
                        <span class="side-menu__label">Achievement</span>
                    </a>
                </li>

                {{-- User --}}
                <li class="slide">
                    <a class="side-menu__item has-link" data-bs-toggle="slide" href="{{ route('user.index') }}">
                        <svg class="mx-2" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-users-icon lucide-users"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><path d="M16 3.128a4 4 0 0 1 0 7.744"/><path d="M22 21v-2a4 4 0 0 0-3-3.87"/><circle cx="9" cy="7" r="4"/></svg>
                        <span class="side-menu__label">Users</span>
                    </a>
                </li>

                {{-- Fun Fact --}}
                <li class="slide">
                    <a class="side-menu__item has-link" data-bs-toggle="slide" href="{{ route('fun-fact.index') }}">
                       <svg class="mx-2" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-face-smile-icon lucide-face-smile"><circle cx="12" cy="12" r="10"/><path d="M8 14s1.5 2 6 2 6-2 6-2"/><line x1="9" x2="9.01" y1="9" y2="9"/><line x1="15" x2="15.01" y1="9" y2="9"/></svg>
                        <span class="side-menu__label">Fun Fact</span>
                    </a>
                </li>


                {{-- Contact --}}
                <li class="slide">
                    <a class="side-menu__item has-link" data-bs-toggle="slide" href="{{ route('contact.index') }}">
                       <svg class="mx-2" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-notebook-tabs-icon lucide-notebook-tabs"><path d="M2 6h4"/><path d="M2 10h4"/><path d="M2 14h4"/><path d="M2 18h4"/><rect width="16" height="20" x="4" y="2" rx="2"/><path d="M15 2v20"/><path d="M15 7h5"/><path d="M15 12h5"/><path d="M15 17h5"/></svg>
                        <span class="side-menu__label">Contact</span>
                    </a>
                </li>

                {{-- Faq --}}
                {{-- <li class="slide {{ request()->is('admin/faq*') ? 'active is-expanded' : '' }}">
                    <a class="side-menu__item {{ request()->is('admin/faq*') ? 'active is-expanded' : '' }}"
                       data-bs-toggle="slide" href="#">
                        <i class="fa fa-question px-2"></i>
                        <span class="side-menu__label">Faq</span><i class="angle fa fa-angle-right"></i>
                    </a>

                    <ul class="slide-menu">
                        <li><a href="{{ route('faq.index') }}" class="slide-item">List</a></li>
                    </ul>
                </li> --}}

                {{-- Contact Us --}}
                {{--                <li class="slide {{ request()->is('admin/contact*') ? 'active is-expanded' : '' }}"> --}}
                {{--                    <a class="side-menu__item {{ request()->is('admin/contact*') ? 'active is-expanded' : '' }}" --}}
                {{--                       data-bs-toggle="slide" href="#"> --}}
                {{--                        <i class="fa fa-phone px-2"></i> --}}
                {{--                        <span class="side-menu__label">Contact Us</span><i class="angle fa fa-angle-right"></i> --}}
                {{--                    </a> --}}

                {{--                    <ul class="slide-menu"> --}}
                {{--                        <li><a href="{{ route('contact-us.create') }}" class="slide-item">Contact Us</a></li> --}}
                {{--                    </ul> --}}
                {{--                </li> --}}


                {{-- Plan --}}
                 <li class="slide {{ request()->is('admin/plans*') ? 'active is-expanded' : '' }}">
                    <a class="side-menu__item {{ request()->is('admin/plans*') ? 'active is-expanded' : '' }}"
                        data-bs-toggle="slide" href="#">
                        <svg class="mx-2" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-list-alt-icon lucide-list-alt"><line x1="21" x2="3" y1="6" y2="6"/><line x1="17" x2="3" y1="12" y2="12"/><line x1="13" x2="3" y1="18" y2="18"/></svg>
                        <span class="side-menu__label">Plan</span><i class="angle fa fa-angle-right"></i>
                    </a>

                    <ul class="slide-menu">
                        <li><a href="{{ route('plan.index') }}" class="slide-item">Plans</a></li>
                        <li><a href="{{ route('plan.feature.index') }}" class="slide-item">Plan Feature</a></li>
                        <li><a href="{{ route(('user.subscription.index')) }}" class="slide-item">User Subscription</a></li>
                        <li><a href="{{ route(('user.donation.index')) }}" class="slide-item">User Donation</a></li>
                    </ul>
                </li>

                {{-- Setting --}}
                <li class="slide {{ request()->is('admin/settings*') ? 'active is-expanded' : '' }}">
                    <a class="side-menu__item {{ request()->is('admin/settings*') ? 'active is-expanded' : '' }}"
                       data-bs-toggle="slide" href="#">
                        <svg class="mx-2" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-settings-icon lucide-settings"><path d="M9.671 4.136a2.34 2.34 0 0 1 4.659 0 2.34 2.34 0 0 0 3.319 1.915 2.34 2.34 0 0 1 2.33 4.033 2.34 2.34 0 0 0 0 3.831 2.34 2.34 0 0 1-2.33 4.033 2.34 2.34 0 0 0-3.319 1.915 2.34 2.34 0 0 1-4.659 0 2.34 2.34 0 0 0-3.32-1.915 2.34 2.34 0 0 1-2.33-4.033 2.34 2.34 0 0 0 0-3.831A2.34 2.34 0 0 1 6.35 6.051a2.34 2.34 0 0 0 3.319-1.915"/><circle cx="12" cy="12" r="3"/></svg>
                        <span class="side-menu__label">Settings</span><i class="angle fa fa-angle-right"></i>
                    </a>

                    <ul class="slide-menu">
                        <li><a href="{{ route('profile.setting') }}" class="slide-item">Profile Settings</a></li>
                        <li><a href="{{ route('mail.setting') }}" class="slide-item">Mail Settings</a></li>
{{--                        <li><a href="{{ route('page.setting') }}" class="slide-item">Page Settings</a></li>--}}
                    </ul>
                </li>
            </ul>

            <div class="slide-right" id="slide-right">
                <svg xmlns="http://www.w3.org/2000/svg" fill="#7b8191" width="24" height="24"
                    viewBox="0 0 24 24">
                    <path d="M10.707 17.707 16.414 12l-5.707-5.707-1.414 1.414L13.586 12l-4.293 4.293z" />
                </svg>
            </div>
        </div>
    </div>
</div>
