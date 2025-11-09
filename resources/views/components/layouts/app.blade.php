<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>n8n ad refactor tool</title>
    @vite('resources/js/app.js')
    @livewireStyles
</head>
<body class="bg-gray-50 text-gray-900">
<nav class="p-4 bg-indigo-600 text-white font-bold text-lg">n8n ad refactor tool</nav>
<main class="p-6 max-w-4xl mx-auto">
    {{ $slot }}
</main>
@livewireScripts
</body>
</html>
