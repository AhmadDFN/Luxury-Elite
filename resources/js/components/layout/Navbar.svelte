<script lang="ts">
    import { Link } from '@inertiajs/svelte';
    import { fade, fly } from 'svelte/transition';
</script>

<nav
    in:fade={{ duration: 1000 }}
    class="absolute top-0 w-full z-50 flex items-center justify-between px-8 md:px-12 py-6 bg-gradient-to-b from-black/90 to-transparent backdrop-blur-[2px]"
>
    <div class="flex items-center gap-0 cursor-pointer group">
        <img
            src="/images/logo-lx.png"
            alt="Logo Luxury Elite"
            class="h-16 md:h-20 w-auto object-contain transition-transform duration-500 group-hover:scale-110"
        />
        <span
            class="text-lg md:text-xl font-light tracking-[0.3em] text-gray-200 hidden lg:block -ml-2"
        >
            LUXURY <span class="font-bold text-yellow-500">ELITE</span>
        </span>
    </div>

    <div
        class="hidden md:flex gap-8 text-[11px] font-bold tracking-[0.2em] uppercase text-gray-400"
    >
        {#each ['Home', 'Roster', 'Matches', 'News'] as item, i}
            <a
                href="#"
                class="hover:text-cyan-400 transition-colors duration-300 {i ===
                0
                    ? 'text-cyan-400 border-b border-cyan-400'
                    : ''}"
            >
                {item}
            </a>
        {/each}
    </div>

    <div class="flex gap-4">
        <Link
            href="/login"
            class="px-6 py-2 border border-yellow-600/30 rounded-full text-xs font-bold text-yellow-500 hover:bg-yellow-500 hover:text-black transition-all duration-500 uppercase tracking-widest"
        >
            Login
        </Link>
    </div>
</nav>
