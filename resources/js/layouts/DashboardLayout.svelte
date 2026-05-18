<script lang="ts">
    import { Link } from '@inertiajs/svelte';

    export let title: string = 'Dashboard';
    export let user: any = null;

    let sidebarOpen = true;

    const navigation = [
        {
            title: 'Dashboard',
            href: '/dashboard',
            roles: ['owner', 'admin', 'coach', 'captain', 'player'],
        },
        {
            title: 'Players',
            href: '/dashboard/players',
            roles: ['owner', 'admin', 'coach'],
        },
        {
            title: 'Divisions',
            href: '/dashboard/divisions',
            roles: ['owner', 'admin'],
        },
        {
            title: 'Scrims',
            href: '/dashboard/scrims',
            roles: ['owner', 'admin', 'coach', 'captain'],
        },
        {
            title: 'VOD Library',
            href: '/dashboard/vods',
            roles: ['owner', 'admin', 'coach', 'captain', 'player'],
        },
        {
            title: 'News',
            href: '/dashboard/news',
            roles: ['owner', 'admin'],
        },
        {
            title: 'Settings',
            href: '/dashboard/settings',
            roles: ['owner'],
        },
    ];

    function hasAccess(roles: string[]) {
        if (!user || !user.role) return false;

        return roles.includes(user.role);
    }
</script>

<svelte:head>
    <title>{title} - Luxury Elite</title>
</svelte:head>

<div class="dashboard-wrapper">
    <!-- Sidebar -->
    <aside class:collapsed={!sidebarOpen}>
        <div class="sidebar-header">
            <div>
                <h2>Luxury Elite</h2>
                <span>Internal Dashboard</span>
            </div>
        </div>

        <nav>
            {#each navigation as item}
                {#if hasAccess(item.roles)}
                    <Link href={item.href} class="nav-item">
                        {item.title}
                    </Link>
                {/if}
            {/each}
        </nav>
    </aside>

    <!-- Main -->
    <div class="main-content">
        <!-- Topbar -->
        <header>
            <div class="topbar-left">
                <button
                    class="toggle-button"
                    on:click={() => (sidebarOpen = !sidebarOpen)}
                >
                    ☰
                </button>

                <div>
                    <h1>{title}</h1>
                    <p>Luxury Elite Management System</p>
                </div>
            </div>

            <div class="topbar-right">
                <div class="user-box">
                    <div class="avatar">
                        {user?.name?.charAt(0) || 'U'}
                    </div>

                    <div>
                        <strong>{user?.name || 'Guest'}</strong>
                        <p>{user?.role || 'Unknown Role'}</p>
                    </div>
                </div>
            </div>
        </header>

        <!-- Content -->
        <main>
            <slot />
        </main>
    </div>
</div>

<style>
    :global(body) {
        margin: 0;
        background: #071120;
        color: white;
        font-family: Inter, sans-serif;
    }

    .dashboard-wrapper {
        display: flex;
        min-height: 100vh;
    }

    aside {
        width: 260px;
        background: #0b1729;
        border-right: 1px solid rgba(255, 255, 255, 0.08);
        transition: 0.3s ease;
        overflow: hidden;
    }

    aside.collapsed {
        width: 90px;
    }

    .sidebar-header {
        padding: 24px;
        border-bottom: 1px solid rgba(255, 255, 255, 0.08);
    }

    .sidebar-header h2 {
        margin: 0;
        font-size: 22px;
        color: #f3c623;
    }

    .sidebar-header span {
        font-size: 13px;
        opacity: 0.7;
    }

    nav {
        display: flex;
        flex-direction: column;
        padding: 18px;
        gap: 10px;
    }

    .nav-item {
        padding: 14px 16px;
        border-radius: 12px;
        text-decoration: none;
        color: rgba(255, 255, 255, 0.8);
        transition: 0.2s ease;
        font-weight: 500;
    }

    .nav-item:hover {
        background: rgba(243, 198, 35, 0.12);
        color: #f3c623;
    }

    .main-content {
        flex: 1;
        display: flex;
        flex-direction: column;
    }

    header {
        height: 80px;
        border-bottom: 1px solid rgba(255, 255, 255, 0.08);
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 0 24px;
        background: rgba(11, 23, 41, 0.95);
        backdrop-filter: blur(10px);
    }

    .topbar-left {
        display: flex;
        align-items: center;
        gap: 18px;
    }

    .topbar-left h1 {
        margin: 0;
        font-size: 24px;
    }

    .topbar-left p {
        margin: 0;
        opacity: 0.6;
        font-size: 14px;
    }

    .toggle-button {
        width: 42px;
        height: 42px;
        border-radius: 10px;
        border: none;
        background: rgba(255, 255, 255, 0.08);
        color: white;
        cursor: pointer;
        font-size: 18px;
    }

    .user-box {
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .avatar {
        width: 42px;
        height: 42px;
        border-radius: 50%;
        background: #f3c623;
        color: black;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: bold;
    }

    .user-box p {
        margin: 0;
        opacity: 0.7;
        font-size: 13px;
    }

    main {
        padding: 24px;
    }
</style>
