<nav class="-mx-3 flex  justify-center">
    @auth('admin')
        <a
            href="{{ url('/admin/dashboard') }}" wire:navigate
            class="rounded-md px-3 py-2 text-black ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20] dark:text-white dark:hover:text-white/80 dark:focus-visible:ring-white"
        >
            Admin Dashboard
        </a>
    @else
        <a
            href="{{ route('admin.login') }}" wire:navigate
            class="rounded-md px-3 py-2 text-black ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20] dark:text-white dark:hover:text-white/80 dark:focus-visible:ring-white"
        >
            Admin Log in
        </a>

        @if (Route::has('register'))
            <a
                href="{{ route('admin.register') }}" wire:navigate
                class="rounded-md px-3 py-2 text-black ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20] dark:text-white dark:hover:text-white/80 dark:focus-visible:ring-white"
            >
                Admin Register
            </a>
        @endif
    @endauth
</nav>
