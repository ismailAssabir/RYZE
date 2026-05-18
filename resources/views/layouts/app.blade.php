<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description" content="@yield('meta_description', 'RYZE, boutique sportive premium: football, running, gym, musculation et nutrition.')">
    <title>@yield('title', 'RYZE') - Sport Performance</title>
    <link rel="icon" href="{{ asset('images/ryze-logo.jpeg') }}">
    <link rel="manifest" href="{{ asset('manifest.json') }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-white text-zinc-950 antialiased dark:bg-black dark:text-white">
    <div class="min-h-screen">
        <header class="sticky top-0 z-40 border-b border-zinc-200/70 bg-white/90 backdrop-blur dark:border-zinc-800 dark:bg-black/85">
            <nav class="mx-auto flex max-w-7xl items-center justify-between px-4 py-3 bg-green-600">

                <a href="{{ route('home') }}" class="flex items-center gap-3">
                    <img src="{{ asset('images/ryze-logo.jpeg') }}" class="h-10 w-10 rounded object-cover" alt="RYZE">
                    <span class="text-xl font-black tracking-wide">RYZE</span>
                </a>
                <div class="hidden items-center gap-6 text-sm font-semibold md:flex">
                    <a href="{{ route('shop') }}" class="hover:text-red-600">Shop</a>
                    <a href="{{ route('page', 'categories') }}" class="hover:text-red-600">Categories</a>
                    <a href="{{ route('blog') }}" class="hover:text-red-600">Blog</a>
                    <a href="{{ route('page', 'contact') }}" class="hover:text-red-600">Contact</a>
                </div>
                <div class="flex items-center gap-1 sm:gap-2">
                    <!-- Language Dropdown (Vanilla JS) -->
                    <div class="relative z-50">
                        <button id="lang-toggle" class="flex h-9 items-center gap-1 rounded-lg px-2 text-sm font-bold text-white hover:bg-white/20 focus:outline-none transition-colors" title="Langue">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-5 w-5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 21a9.004 9.004 0 0 0 8.716-6.747M12 21a9.004 9.004 0 0 1-8.716-6.747M12 21c2.485 0 4.5-4.03 4.5-9S14.485 3 12 3m0 18c-2.485 0-4.5-4.03-4.5-9S9.515 3 12 3m0 0a8.997 8.997 0 0 1 7.843 4.582M12 3a8.997 8.997 0 0 0-7.843 4.582m15.686 0A11.953 11.953 0 0 1 12 10.5c-2.998 0-5.74-1.1-7.843-2.918m15.686 0A8.959 8.959 0 0 1 21 12c0 .778-.099 1.533-.284 2.253m0 0A17.919 17.919 0 0 1 12 16.5c-3.162 0-6.133-.815-8.716-2.247m0 0A9.015 9.015 0 0 1 3 12c0-1.605.42-3.113 1.157-4.418" /></svg>
                            <span class="hidden sm:inline">FR</span>
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" /></svg>
                        </button>
                        <div id="lang-menu" class="hidden absolute right-0 mt-2 w-32 origin-top-right rounded-lg border border-zinc-200 bg-white shadow-xl dark:border-zinc-700 dark:bg-zinc-800">
                            <div class="p-1">
                                <a href="?lang=ar" class="block rounded-md px-4 py-2 text-sm text-zinc-700 hover:bg-zinc-100 hover:text-green-600 dark:text-zinc-200 dark:hover:bg-zinc-700 dark:hover:text-green-400">العربية</a>
                                <a href="?lang=fr" class="block rounded-md px-4 py-2 text-sm font-bold text-green-600 bg-green-50 dark:bg-green-900/30 dark:text-green-400">Français</a>
                                <a href="?lang=en" class="block rounded-md px-4 py-2 text-sm text-zinc-700 hover:bg-zinc-100 hover:text-green-600 dark:text-zinc-200 dark:hover:bg-zinc-700 dark:hover:text-green-400">English</a>
                            </div>
                        </div>
                    </div>

                    <!-- Mode Toggle -->
                    <button id="theme-toggle" class="flex h-9 w-9 items-center justify-center rounded-lg text-white hover:bg-white/20 focus:outline-none transition-colors" title="Changer le thème">
                        <!-- Sun Icon for Light Mode (shown when dark mode is active) -->
                        <svg id="theme-toggle-light-icon" class="hidden h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 3v2.25m6.364.386-1.591 1.591M21 12h-2.25m-.386 6.364-1.591-1.591M12 18.75V21m-4.773-4.227-1.591 1.591M5.25 12H3m4.227-4.773L5.636 5.636M15.75 12a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0Z" /></svg>
                        <!-- Moon Icon for Dark Mode (shown when light mode is active) -->
                        <svg id="theme-toggle-dark-icon" class="hidden h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M21.752 15.002A9.72 9.72 0 0 1 18 15.75c-5.385 0-9.75-4.365-9.75-9.75 0-1.33.266-2.597.748-3.752A9.753 9.753 0 0 0 3 11.25C3 16.635 7.365 21 12.75 21a9.753 9.753 0 0 0 9.002-5.998Z" /></svg>
                    </button>

                    <!-- Cart -->
                    <a href="{{ route('cart.index') }}" class="flex h-9 w-9 items-center justify-center rounded-lg text-white hover:bg-white/20 transition-colors" title="Panier">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-5 w-5"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 10.5V6a3.75 3.75 0 1 0-7.5 0v4.5m11.356-1.993 1.263 12c.07.665-.45 1.243-1.119 1.243H4.25a1.125 1.125 0 0 1-1.12-1.243l1.264-12A1.125 1.125 0 0 1 5.513 7.5h12.974c.576 0 1.059.435 1.119 1.007ZM8.625 10.5a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm7.5 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Z" /></svg>
                    </a>

                    <!-- Auth -->
                    @auth
                        <div class="hidden items-center gap-2 sm:flex ml-2 border-l border-white/20 pl-4">
                            <a href="{{ auth()->user()->isAdmin() ? route('admin.dashboard') : route('dashboard') }}" class="rounded-lg bg-white px-4 py-2 text-sm font-bold text-green-700 shadow-sm transition-colors hover:bg-zinc-100">Mon Compte</a>
                            <form method="POST" action="{{ route('logout') }}" class="m-0">
                                @csrf
                                <button type="submit" class="rounded-lg bg-red-600 px-4 py-2 text-sm font-bold text-white shadow-sm hover:bg-red-700 transition-colors">Déconnexion</button>
                            </form>
                        </div>
                    @else
                        <div class="hidden items-center gap-2 sm:flex ml-2 border-l border-white/20 pl-4">
                            <a href="{{ route('login') }}" class="text-sm font-bold text-white hover:text-zinc-200 transition-colors">Connexion</a>
                            <a href="{{ route('register') }}" class="rounded-lg bg-white px-4 py-2 text-sm font-bold text-green-700 shadow-sm transition-colors hover:bg-zinc-100">Inscription</a>
                        </div>
                    @endauth
                </div>
            </nav>
        </header>

        @if(session('success'))
            <div class="mx-auto mt-4 max-w-7xl px-4"><div class="rounded border border-emerald-500/30 bg-emerald-500/10 p-3 text-sm text-emerald-700 dark:text-emerald-300">{{ session('success') }}</div></div>
        @endif

        <main>@yield('content')</main>

        <footer class="mt-16 border-t border-zinc-200 bg-zinc-950 text-white dark:border-zinc-800">
            <div class="mx-auto grid max-w-7xl gap-8 px-4 py-10 md:grid-cols-4">
                <div><div class="text-2xl font-black">RYZE</div><p class="mt-3 text-sm text-zinc-400">Performance gear pour athlètes, clubs et passionnés.</p></div>
                <div><h3 class="font-bold">Shop</h3><p class="mt-3 text-sm text-zinc-400">Football, Basketball, Running, Gym, Nutrition</p></div>
                <div><h3 class="font-bold">Support</h3><p class="mt-3 text-sm text-zinc-400">FAQ, livraison, retours, paiement securise</p></div>
                <div><h3 class="font-bold">Newsletter</h3><input class="mt-3 w-full rounded border-0 bg-white/10 px-3 py-2 text-sm" placeholder="email@ryze.ma"></div>
            </div>
        </footer>
    </div>
    <!-- SweetAlert2 for professional alerts -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- Vanilla JS Interactivity to bypass build issues -->
    <script>
        (function() {
            // SweetAlert Delete Logic
            const deleteForms = document.querySelectorAll('.delete-confirm-form');
            deleteForms.forEach(form => {
                form.addEventListener('submit', function (e) {
                    e.preventDefault();
                    if(typeof Swal !== 'undefined') {
                        Swal.fire({
                            title: 'Êtes-vous sûr ?',
                            text: "Cette action est irréversible !",
                            icon: 'warning',
                            showCancelButton: true,
                            confirmButtonColor: '#0891b2',
                            cancelButtonColor: '#ef4444',
                            confirmButtonText: 'Oui, supprimer !',
                            cancelButtonText: 'Annuler',
                            background: document.documentElement.classList.contains('dark') ? '#18181b' : '#ffffff',
                            color: document.documentElement.classList.contains('dark') ? '#ffffff' : '#18181b',
                        }).then((result) => {
                            if (result.isConfirmed) {
                                form.submit();
                            }
                        });
                    } else {
                        if(confirm('Êtes-vous sûr de vouloir supprimer cet élément ?')) {
                            form.submit();
                        }
                    }
                });
            });

            // Theme Toggle Logic
            const themeToggleBtn = document.getElementById('theme-toggle');
            const darkIcon = document.getElementById('theme-toggle-dark-icon');
            const lightIcon = document.getElementById('theme-toggle-light-icon');

            if (themeToggleBtn && darkIcon && lightIcon) {
                // Set initial state
                if (localStorage.theme === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
                    document.documentElement.classList.add('dark');
                    lightIcon.classList.remove('hidden');
                } else {
                    document.documentElement.classList.remove('dark');
                    darkIcon.classList.remove('hidden');
                }

                // Toggle on click
                themeToggleBtn.addEventListener('click', function() {
                    darkIcon.classList.toggle('hidden');
                    lightIcon.classList.toggle('hidden');

                    if (document.documentElement.classList.contains('dark')) {
                        document.documentElement.classList.remove('dark');
                        localStorage.theme = 'light';
                    } else {
                        document.documentElement.classList.add('dark');
                        localStorage.theme = 'dark';
                    }
                });
            }

            // Language Dropdown Logic
            const langToggle = document.getElementById('lang-toggle');
            const langMenu = document.getElementById('lang-menu');

            if (langToggle && langMenu) {
                langToggle.addEventListener('click', function(e) {
                    e.stopPropagation();
                    langMenu.classList.toggle('hidden');
                });

                document.addEventListener('click', function(e) {
                    if (!langToggle.contains(e.target) && !langMenu.contains(e.target)) {
                        langMenu.classList.add('hidden');
                    }
                });
            }
        })();
    </script>
</body>
</html>
