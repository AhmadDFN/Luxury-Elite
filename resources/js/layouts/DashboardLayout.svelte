<script lang="ts">
    import { Link, page } from '@inertiajs/svelte';
    import { fade, fly } from 'svelte/transition';
    import { Toaster } from 'svelte-sonner';
    import Notification from '@/components/Notification.svelte';

    export let title: string = 'Dashboard';
    export let user: any = null;

    let sidebarOpen = true;
    let dropdownOpen = false;

    // Warna brand (menyesuaikan landing page)
    const brandGold = '#dca34f';
    const brandCyan = '#00e5ff'; // Mengambil aksen biru dari tombol "Meet The Team"

    const navigation = [
        {
            title: 'Dashboard',
            href: '/dashboard',
            roles: ['owner', 'admin', 'coach', 'captain', 'player'],
            icon: `<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zm10 0a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zm10 0a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path></svg>`,
        },
        {
            title: 'Players',
            href: '/dashboard/players',
            roles: ['owner', 'admin', 'coach'],
            icon: `<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>`,
        },
        {
            title: 'Divisions',
            href: '/dashboard/divisions',
            roles: ['owner', 'admin'],
            icon: `<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>`,
        },
        {
            title: 'Scrims',
            href: '/dashboard/scrims',
            roles: ['owner', 'admin', 'coach', 'captain'],
            icon: `<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>`,
        },
        {
            title: 'VOD Library',
            href: '/dashboard/vods',
            roles: ['owner', 'admin', 'coach', 'captain', 'player'],
            icon: `<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"></path></svg>`,
        },
        {
            title: 'News',
            href: '/dashboard/news',
            roles: ['owner', 'admin'],
            icon: `<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"></path></svg>`,
        },
    ];

    function hasAccess(roles: string[]) {
        if (!user || !user.role) return true;
        return roles.includes(user.role);
    }
</script>

<svelte:head>
    <title>{title} | Luxury Elite</title>
</svelte:head>

<div
    class="flex h-screen bg-[#030610] text-slate-300 font-sans overflow-hidden selection:bg-[#00e5ff]/30 selection:text-white"
>
    <aside
        class="{sidebarOpen
            ? 'w-64'
            : 'w-20'} flex flex-col bg-[#080d1a]/80 backdrop-blur-xl border-r border-white/5 transition-all duration-300 ease-in-out relative z-20 shadow-[4px_0_24px_rgba(0,0,0,0.5)]"
    >
        <div class="h-20 flex items-center justify-center px-4 relative z-10">
            <div
                class="flex items-center w-full {sidebarOpen
                    ? 'justify-start px-2'
                    : 'justify-center'} transition-all duration-300"
            >
                <div
                    class="flex-shrink-0 w-10 h-10 bg-gradient-to-br from-[#dca34f] to-[#a37024] rounded-lg flex items-center justify-center text-black font-extrabold text-xl shadow-[0_0_15px_rgba(220,163,79,0.3)] border border-white/20"
                >
                    LX
                </div>
                {#if sidebarOpen}
                    <div
                        class="ml-4 overflow-hidden whitespace-nowrap"
                        transition:fade={{ duration: 200 }}
                    >
                        <h2
                            class="text-white font-black text-lg tracking-wider uppercase italic leading-tight"
                        >
                            Luxury <span class="text-[#dca34f]">Elite</span>
                        </h2>
                        <span
                            class="text-[10px] text-[#00e5ff] font-bold tracking-widest uppercase"
                            >Internal System</span
                        >
                    </div>
                {/if}
            </div>

            <div
                class="absolute bottom-0 left-4 right-4 h-[1px] bg-gradient-to-r from-transparent via-white/10 to-transparent"
            ></div>
        </div>

        <nav
            class="flex-1 overflow-y-auto py-6 px-3 space-y-2 custom-scrollbar"
        >
            {#each navigation as item}
                {#if hasAccess(item.roles)}
                    {@const isActive =
                        (page.url.startsWith(item.href) &&
                            item.href !== '/dashboard') ||
                        (page.url === '/dashboard' &&
                            item.href === '/dashboard')}

                    <Link
                        href={item.href}
                        class="flex items-center px-3 py-3 rounded-xl transition-all duration-300 group relative
                        {isActive
                            ? 'bg-gradient-to-r from-[#00e5ff]/10 to-transparent text-white'
                            : 'text-slate-400 hover:bg-white/5 hover:text-white'}
                        {sidebarOpen ? 'justify-start' : 'justify-center'}"
                    >
                        {#if isActive}
                            <div
                                class="absolute left-0 top-1/2 -translate-y-1/2 w-1 h-8 bg-[#00e5ff] rounded-r-full shadow-[0_0_10px_#00e5ff]"
                            ></div>
                        {/if}

                        <span
                            class="flex-shrink-0 transition-colors duration-300 {isActive
                                ? 'text-[#00e5ff]'
                                : 'text-slate-500 group-hover:text-slate-300'}"
                        >
                            {@html item.icon}
                        </span>

                        {#if sidebarOpen}
                            <span
                                class="ml-3 font-semibold text-sm whitespace-nowrap transition-opacity duration-300"
                            >
                                {item.title}
                            </span>
                        {/if}
                    </Link>
                {/if}
            {/each}
        </nav>
    </aside>

    <div
        class="flex-1 flex flex-col min-w-0 bg-gradient-to-br from-[#030610] via-[#050a18] to-[#030610] relative"
    >
        <div
            class="absolute top-[-10%] left-[-10%] w-[40%] h-[40%] bg-[#dca34f]/5 rounded-full blur-[120px] pointer-events-none"
        ></div>
        <div
            class="absolute bottom-[-10%] right-[-10%] w-[40%] h-[40%] bg-[#00e5ff]/5 rounded-full blur-[120px] pointer-events-none"
        ></div>

        <header
            class="h-20 bg-[#080d1a]/60 backdrop-blur-md border-b border-white/5 flex items-center justify-between px-6 md:px-8 sticky top-0 z-30"
        >
            <div class="flex items-center gap-4">
                <button
                    on:click={() => (sidebarOpen = !sidebarOpen)}
                    class="p-2.5 rounded-xl bg-white/5 text-slate-400 hover:text-white hover:bg-white/10 transition-all focus:outline-none border border-white/5"
                >
                    <svg
                        class="w-5 h-5"
                        fill="none"
                        stroke="currentColor"
                        viewBox="0 0 24 24"
                        ><path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h7"
                        ></path></svg
                    >
                </button>

                <div>
                    <h1 class="text-xl font-bold text-white tracking-wide">
                        {title}
                    </h1>
                    <p
                        class="text-[11px] text-slate-400 font-medium hidden sm:block uppercase tracking-wider"
                    >
                        Luxury Elite <span class="text-[#00e5ff] mx-1">/</span>
                        {title}
                    </p>
                </div>
            </div>

            <div class="flex items-center gap-5">
                <button
                    class="relative p-2 text-slate-400 hover:text-white transition-colors"
                >
                    <svg
                        class="w-6 h-6"
                        fill="none"
                        stroke="currentColor"
                        viewBox="0 0 24 24"
                        ><path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"
                        ></path></svg
                    >
                    <span
                        class="absolute top-1.5 right-1.5 w-2.5 h-2.5 bg-[#00e5ff] rounded-full border-2 border-[#080d1a] shadow-[0_0_8px_#00e5ff]"
                    ></span>
                </button>

                <div class="w-px h-8 bg-white/10 mx-1"></div>

                <div class="relative">
                    <button
                        on:click={() => (dropdownOpen = !dropdownOpen)}
                        class="flex items-center gap-3 p-1.5 pr-4 rounded-full bg-white/5 hover:bg-white/10 border border-white/5 hover:border-white/20 transition-all focus:outline-none"
                    >
                        <div
                            class="w-10 h-10 rounded-full bg-gradient-to-tr from-[#00e5ff] to-blue-500 text-white font-bold flex items-center justify-center flex-shrink-0 shadow-inner border border-white/20"
                        >
                            {user?.name?.charAt(0).toUpperCase() || 'U'}
                        </div>
                        <div class="hidden md:block text-left">
                            <p
                                class="text-sm font-bold text-white leading-tight"
                            >
                                {user?.name || 'Guest User'}
                            </p>
                            <p
                                class="text-[10px] text-[#dca34f] uppercase tracking-widest font-bold mt-0.5"
                            >
                                {user?.role || 'Unknown'}
                            </p>
                        </div>
                        <svg
                            class="w-4 h-4 text-slate-400 ml-1 transition-transform duration-200 {dropdownOpen
                                ? 'rotate-180'
                                : ''}"
                            fill="none"
                            stroke="currentColor"
                            viewBox="0 0 24 24"
                            ><path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M19 9l-7 7-7-7"
                            ></path></svg
                        >
                    </button>

                    {#if dropdownOpen}
                        <button
                            class="fixed inset-0 w-full h-full cursor-default z-40"
                            on:click={() => (dropdownOpen = false)}
                            tabindex="-1"
                        ></button>
                    {/if}

                    {#if dropdownOpen}
                        <div
                            transition:fly={{ y: 10, duration: 200 }}
                            class="absolute right-0 mt-3 w-64 bg-[#0a101f]/95 backdrop-blur-xl rounded-2xl shadow-[0_10px_40px_rgba(0,0,0,0.8)] border border-white/10 z-40 overflow-hidden"
                        >
                            <div
                                class="px-5 py-4 border-b border-white/5 bg-gradient-to-br from-white/5 to-transparent"
                            >
                                <p class="text-xs text-slate-400 font-medium">
                                    Logged in as
                                </p>
                                <p
                                    class="text-sm font-bold text-[#00e5ff] truncate mt-0.5"
                                >
                                    {user?.email || 'player@luxuryelite.gg'}
                                </p>
                            </div>

                            <div class="py-2">
                                <Link
                                    href="/profile"
                                    class="flex items-center gap-3 px-5 py-3 text-sm text-slate-300 hover:text-white hover:bg-white/5 transition-colors"
                                >
                                    <svg
                                        class="w-4 h-4 text-slate-400"
                                        fill="none"
                                        stroke="currentColor"
                                        viewBox="0 0 24 24"
                                        ><path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            stroke-width="2"
                                            d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"
                                        ></path></svg
                                    >
                                    My Profile
                                </Link>
                                <Link
                                    href="/dashboard/settings"
                                    class="flex items-center gap-3 px-5 py-3 text-sm text-slate-300 hover:text-white hover:bg-white/5 transition-colors"
                                >
                                    <svg
                                        class="w-4 h-4 text-slate-400"
                                        fill="none"
                                        stroke="currentColor"
                                        viewBox="0 0 24 24"
                                        ><path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            stroke-width="2"
                                            d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"
                                        ></path><path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            stroke-width="2"
                                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"
                                        ></path></svg
                                    >
                                    Account Settings
                                </Link>
                            </div>

                            <div
                                class="border-t border-white/5 py-1 bg-red-500/5"
                            >
                                <Link
                                    href="/logout"
                                    method="post"
                                    as="button"
                                    class="w-full flex items-center gap-3 px-5 py-3 text-sm font-bold text-red-400 hover:text-red-300 hover:bg-red-500/10 transition-colors text-left"
                                >
                                    <svg
                                        class="w-4 h-4"
                                        fill="none"
                                        stroke="currentColor"
                                        viewBox="0 0 24 24"
                                        ><path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            stroke-width="2"
                                            d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"
                                        ></path></svg
                                    >
                                    Sign Out
                                </Link>
                            </div>
                        </div>
                    {/if}
                </div>
            </div>
        </header>

        <main
            class="flex-1 overflow-y-auto p-6 md:p-8 relative z-10 custom-scrollbar"
        >
            <slot />
        </main>
    </div>
</div>

<Notification />
<Toaster position="top-right" richColors theme="dark" />

<style>
    /* Styling scrollbar agar lebih estetis dan tidak merusak tema gelap */
    .custom-scrollbar::-webkit-scrollbar {
        width: 6px;
    }
    .custom-scrollbar::-webkit-scrollbar-track {
        background: transparent;
    }
    .custom-scrollbar::-webkit-scrollbar-thumb {
        background: rgba(255, 255, 255, 0.1);
        border-radius: 10px;
    }
    .custom-scrollbar::-webkit-scrollbar-thumb:hover {
        background: rgba(0, 229, 255, 0.5); /* Cyan hover */
    }
</style>
