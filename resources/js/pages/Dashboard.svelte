<script module lang="ts">
    import { dashboard } from '@/routes';

    export const layout = {
        breadcrumbs: [
            {
                title: 'Dashboard',
                href: dashboard(),
            },
        ],
    };
</script>

<script lang="ts">
    import AppHead from '@/components/AppHead.svelte';
    import { Link } from '@inertiajs/svelte';

    // Props yang nanti dikirim dari DashboardController
    export let stats: {
        total_players: number;
        active_scrims: number;
        trial_players: number;
        recent_transfers: Array<{
            nickname: string;
            from: string;
            date: string;
        }>;
    } = {
        total_players: 0,
        active_scrims: 0,
        trial_players: 0,
        recent_transfers: [],
    };
</script>

<AppHead title="Command Center" />

<div class="p-6 max-w-7xl mx-auto space-y-8">
    <div class="flex justify-between items-end">
        <div>
            <h1 class="text-3xl font-bold text-white tracking-tight">
                Command Center
            </h1>
            <p class="text-gray-400 mt-1">
                Welcome back, Admin. Here's your clan's current status.
            </p>
        </div>
        <div class="hidden sm:block">
            <span
                class="text-xs text-gray-500 uppercase tracking-widest font-bold"
                >System Status: <span class="text-emerald-500">Operational</span
                ></span
            >
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div
            class="bg-[#1f2438] p-6 rounded-2xl border border-[#3e4460]/50 shadow-lg hover:border-[#dca34f]/30 transition-all"
        >
            <p class="text-gray-400 text-sm mb-1">Total Roster</p>
            <h3 class="text-4xl font-bold text-white">{stats.total_players}</h3>
            <div
                class="mt-4 text-xs text-[#dca34f] font-medium uppercase tracking-wider"
            >
                Active Members
            </div>
        </div>
        <div
            class="bg-[#1f2438] p-6 rounded-2xl border border-[#3e4460]/50 shadow-lg hover:border-[#dca34f]/30 transition-all"
        >
            <p class="text-gray-400 text-sm mb-1">Active Scrims</p>
            <h3 class="text-4xl font-bold text-white">{stats.active_scrims}</h3>
            <div
                class="mt-4 text-xs text-[#dca34f] font-medium uppercase tracking-wider"
            >
                Scheduled Today
            </div>
        </div>
        <div
            class="bg-[#1f2438] p-6 rounded-2xl border border-[#3e4460]/50 shadow-lg hover:border-[#dca34f]/30 transition-all"
        >
            <p class="text-gray-400 text-sm mb-1">Players in Trial</p>
            <h3 class="text-4xl font-bold text-white">{stats.trial_players}</h3>
            <div
                class="mt-4 text-xs text-amber-500 font-medium uppercase tracking-wider"
            >
                Awaiting Decision
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <div
            class="lg:col-span-2 bg-[#1f2438] rounded-2xl border border-[#3e4460]/50 shadow-xl overflow-hidden"
        >
            <div
                class="p-6 border-b border-[#3e4460]/50 flex justify-between items-center"
            >
                <h2 class="text-lg font-semibold text-white">
                    Recent Transfers
                </h2>
                <Link
                    href="/dashboard/players"
                    class="text-sm text-[#dca34f] hover:underline"
                    >View All</Link
                >
            </div>
            <div class="divide-y divide-[#3e4460]/30">
                {#each stats.recent_transfers as transfer}
                    <div
                        class="p-4 flex justify-between items-center hover:bg-[#282d42]/50 transition-colors"
                    >
                        <div class="flex items-center gap-3">
                            <div
                                class="w-2 h-2 rounded-full bg-[#dca34f]"
                            ></div>
                            <span class="font-medium text-gray-200"
                                >{transfer.nickname}</span
                            >
                        </div>
                        <div class="text-sm text-gray-400">
                            From: <span class="text-white">{transfer.from}</span
                            >
                        </div>
                        <div class="text-xs text-gray-500">{transfer.date}</div>
                    </div>
                {:else}
                    <div class="p-8 text-center text-gray-500 italic">
                        No recent transfer activities.
                    </div>
                {/each}
            </div>
        </div>

        <div
            class="bg-[#1f2438] rounded-2xl border border-[#3e4460]/50 shadow-xl p-6 flex flex-col gap-4"
        >
            <h2 class="text-lg font-semibold text-white mb-2">Quick Actions</h2>

            <Link
                href="/dashboard/players/create"
                class="w-full bg-[#dca34f] text-gray-950 font-bold p-4 rounded-xl text-center hover:bg-[#e7b66a] transition-all transform hover:-translate-y-1"
            >
                Recruit Player
            </Link>

            <Link
                href="/dashboard/scrims/create"
                class="w-full bg-[#282d42] border border-[#3e4460] text-gray-200 font-medium p-4 rounded-xl text-center hover:bg-[#353b54] transition-all"
            >
                Schedule Scrim
            </Link>

            <div class="mt-auto pt-6 border-t border-[#3e4460]/50">
                <p class="text-xs text-gray-500 text-center">
                    System v1.0.4 - Luxury Elite Management
                </p>
            </div>
        </div>
    </div>
</div>
