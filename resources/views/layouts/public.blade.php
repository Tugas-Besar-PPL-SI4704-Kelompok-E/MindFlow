<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'MindFlow - Jaga Kesehatan Mental Anda')</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        /* ===== CSS Reset & Variables ===== */
        *, *::before, *::after {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        :root {
            --primary-50: #f8f5fa;
            --primary-100: #eee8f3;
            --primary-200: #dbcee4;
            --primary-300: #c4acd1;
            --primary-400: #A881C2;
            --primary-500: #996db5;
            --primary-600: #8A64A4;
            --primary-700: #714f88;
            --primary-800: #5c416e;
            --primary-900: #4e385c;

            --gray-50: #f9fafb;
            --gray-100: #f3f4f6;
            --gray-200: #e5e7eb;
            --gray-300: #d1d5db;
            --gray-400: #9ca3af;
            --gray-500: #6b7280;
            --gray-600: #4b5563;
            --gray-700: #374151;
            --gray-800: #1f2937;
            --gray-900: #111827;

            --danger: #ef4444;
            --warning: #f59e0b;
            --success: #10b981;
        }

        body {
            font-family: 'Inter', sans-serif;
            color: var(--gray-800);
            line-height: 1.6;
            -webkit-font-smoothing: antialiased;
        }

        a {
            text-decoration: none;
            color: inherit;
        }

        img {
            max-width: 100%;
            display: block;
        }
    </style>
    @yield('styles')
</head>
<body>
    @yield('body')
</body>
</html>
