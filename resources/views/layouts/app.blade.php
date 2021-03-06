<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="icon" href="{{ asset('img/AdminLTELogo.png') }}" type="image/x-icon">
    <title>@yield('title') — {{ env('APP_NAME') ?? 'Q&A' }}</title>
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback"
          rel="stylesheet">
    <link href="{{ mix('css/app.css') }}" rel="stylesheet">
{{--    <link href="{{ asset('public/css/editor-light.css') }}" rel="stylesheet">--}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.2.0/highlight.min.js"
            integrity="sha512-MinqHeqca99q5bWxFNQEQpplMBFiUNrEwuuDj2rCSh1DgeeTXUgvgYIHZ1puBS9IKBkdfLMSk/ZWVDasa3Y/2A=="
            crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.2.0/styles/github.min.css"
          integrity="sha512-0aPQyyeZrWj9sCA46UlmWgKOP0mUipLQ6OZXu8l4IcAmD2u31EPEy9VcIMvl7SoAaKe8bLXZhYoMaE/in+gcgA=="
          crossorigin="anonymous" referrerpolicy="no-referrer"/>
    <script>
        window._token = '{{ csrf_token() }}';
    </script>

    @yield('styles')

</head>
<body
    class="hold-transition sidebar-mini layout-fixed layout-navbar-fixed {{ (session('dark_mode')) ? 'dark-mode' : '' }} {{ (session('sidebar')) ? '' : 'sidebar-collapse' }}">
<div id="app">
    <div class="wrapper">
        @include('layouts.sections.navbar')
        <aside class="main-sidebar sidebar-dark-primary elevation-4">
            @if(auth()->user())
                <a href="{{ route('my.feed') }}" class="brand-link">
                    @else
                        <a href="{{ route('feed') }}" class="brand-link">
                            @endif
                            <img src="{{ asset('img/AdminLTELogo.png') }}" alt="{{ env('APP_NAME') ?? 'Q&A' }}"
                                 class="brand-image img-circle elevation-3"
                                 style="opacity: .8">
                            <span class="brand-text font-weight-light">{{ env('APP_NAME') ?? 'Q&A' }}</span>
                        </a>
                @include('layouts.sections.sidebar')
        </aside>
        <div class="content-wrapper">
            @yield('content-header')

            @yield('content')
        </div>
    </div>
</div>
<script src="{{ mix('js/app.js') }}"></script>
<script>
    $(document).ready(function () {
        $('[data-toggle="tooltip"]').tooltip();
        //hljs.highlightAuto()
    });
</script>

@yield('scripts')

</body>
</html>
