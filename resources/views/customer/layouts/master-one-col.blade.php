<!doctype html>
<html lang="en">
<head>
    @include('customer.layouts.head-tag')
    @yield('head-tag')
</head>
<body>

@include('customer.layouts.header')

<main id="main-body-one-col" class="main-body">
    @yield('content')
</main>

@include('customer.layouts.footer')

@include('customer.layouts.script')
@yield('script')

<section class="toast-wrapper flex-row-reverse">
    @include('admin.alerts.toast.success')
    @include('admin.alerts.toast.error')
</section>

@include('admin.alerts.sweetalert.error')
@include('admin.alerts.sweetalert.success')


</body>
</html>
