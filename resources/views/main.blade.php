<!doctype html>
<html @lang('en')>

<head>
    @include('partials._head')
    @include('partials._css')
</head>

<body id="page-top">
    <div class="loader-container d-none" id="loader-container">
        <svg class="loader" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 340 340">
            <circle cx="170" cy="170" r="160" stroke="#E2007C" />
            <circle cx="170" cy="170" r="135" stroke="#20c997" />
            <circle cx="170" cy="170" r="110" stroke="#E2007C" />
            <circle cx="170" cy="170" r="85" stroke="#20c997" />
        </svg>

    </div>
    @include('partials._nav')

    <div>
        @yield('content')
    </div>

    @include('partials._footer')
    @include('partials._script')

    @yield('script')
</body>

</html>
