<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>Verify Worker - @yield('title', '默认标题')</title>
    <link rel="stylesheet" href="/assets/css/style.css">
</head>
<body class="flex flex-col min-h-screen">
@include('/public/header')
<main class="flex flex-1">
    <div class="container mx-auto p-2 sm:p-6 flex-1">
        @hasSection('breadcrumb')
            @yield('breadcrumb')
        @endif
        @yield('content')
    </div>
</main>
@include('/public/footer')
<script src="/assets/js/web.js"></script>
@stack('scripts')
</body>
</html>
