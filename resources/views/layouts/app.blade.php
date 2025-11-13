<!DOCTYPE html>
<html lang="pt-br">

<head>
    <title>OldTags Bookstore</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">    
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/@supabase/supabase-js@2"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>

<body class="text-gray-800 bg-white">
    @yield('content')
    @stack('scripts')
</body>

</html>