<script lang="ts">
    import AppHead from '@/components/AppHead.svelte';
    import { Link } from '@inertiajs/svelte';
    import {
        ArrowLeft,
        Shield,
        Swords,
        Car,
        History,
        Mail,
        Phone,
        Fingerprint,
        Activity,
        Quote,
        Image as ImageIcon,
        User,
    } from 'lucide-svelte';

    export let player: any;

    // Fallback yang aman
    $: profile = player.player_profile || {};
    $: division = player.divisions?.[0] || {};
    $: membershipStatus =
        division.pivot?.membership_status || 'Trial / Unassigned';
</script>

<AppHead title={`${profile.nickname || player.name} - Elite Dossier`} />

<div
    class="p-4 sm:p-8 max-w-7xl mx-auto space-y-8 animate-in fade-in duration-700"
>
    <Link
        href="/dashboard/players"
        class="inline-flex items-center gap-2 text-gray-500 hover:text-[#dca34f] transition-all font-semibold uppercase tracking-wider text-sm group"
    >
        <div
            class="p-2 rounded-full bg-[#181f30] border border-[#2a3249] group-hover:border-[#dca34f]/50 transition-colors"
        >
            <ArrowLeft class="size-4" />
        </div>
        Return to Roster
    </Link>

    <div
        class="relative bg-[#131926]/90 backdrop-blur-xl border border-[#2a3249] shadow-2xl rounded-3xl overflow-hidden group mt-4"
    >
        <div
            class="absolute top-0 right-0 w-[400px] h-[400px] bg-[#dca34f]/10 rounded-full blur-[100px] pointer-events-none -translate-y-1/2 translate-x-1/3"
        ></div>
        <div
            class="absolute bottom-0 left-0 w-[300px] h-[300px] bg-[#00e5ff]/5 rounded-full blur-[80px] pointer-events-none translate-y-1/3 -translate-x-1/3"
        ></div>

        <div
            class="p-6 sm:p-10 flex flex-col md:flex-row items-center md:items-stretch gap-8 relative z-10"
        >
            <div
                class="w-56 h-72 sm:w-64 sm:h-80 shrink-0 rounded-2xl border border-[#2a3249] overflow-hidden bg-[#050810] shadow-[0_10px_40px_rgba(0,0,0,0.5)] group-hover:border-[#dca34f]/50 transition-all duration-500 relative"
            >
                <img
                    src={profile.photo
                        ? `/storage/${profile.photo}`
                        : `https://ui-avatars.com/api/?name=${profile.nickname || player.name}&background=dca34f&color=111827&bold=true`}
                    alt="Player Portrait"
                    class="w-full h-full object-cover object-center group-hover:scale-105 transition-transform duration-700"
                />
                <div
                    class="absolute inset-0 ring-1 ring-inset ring-white/10 pointer-events-none rounded-2xl"
                ></div>
                <div
                    class="absolute inset-x-0 bottom-0 h-1/3 bg-gradient-to-t from-[#050810] to-transparent opacity-80 pointer-events-none"
                ></div>
            </div>

            <div
                class="flex-1 flex flex-col justify-center text-center md:text-left w-full"
            >
                <div
                    class="flex flex-wrap justify-center md:justify-start gap-2 mb-6"
                >
                    <span
                        class="px-3 py-1.5 rounded-lg bg-[#181f30] border border-[#dca34f]/30 text-[#dca34f] text-[11px] font-black uppercase tracking-widest flex items-center gap-1.5 shadow-sm"
                    >
                        <Shield class="size-3.5" />
                        {division.name || 'Free Agent'}
                    </span>
                    <span
                        class="px-3 py-1.5 rounded-lg bg-[#181f30] border border-[#00e5ff]/30 text-[#00e5ff] text-[11px] font-black uppercase tracking-widest flex items-center gap-1.5 shadow-sm"
                    >
                        <Activity class="size-3.5" />
                        {membershipStatus}
                    </span>
                </div>

                <h1
                    class="text-5xl sm:text-6xl lg:text-7xl font-black text-white tracking-tight drop-shadow-lg leading-none mb-3"
                >
                    {profile.nickname || 'Unknown'}
                </h1>
                <p
                    class="text-[#dca34f] font-bold text-lg sm:text-xl tracking-wider opacity-90"
                >
                    {profile.real_name || player.name}
                </p>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
        <div class="lg:col-span-5 space-y-8">
            <div
                class="bg-[#131926]/80 rounded-3xl border border-[#2a3249] p-6 sm:p-8 shadow-xl relative overflow-hidden"
            >
                <div
                    class="absolute top-0 right-0 w-32 h-32 bg-[#dca34f]/5 rounded-full blur-2xl -translate-y-1/2 translate-x-1/2"
                ></div>

                <h3
                    class="text-sm font-black text-[#dca34f] uppercase tracking-widest mb-6 flex items-center gap-3"
                >
                    <Fingerprint class="size-5" /> Personnel Data
                </h3>

                <div class="space-y-3">
                    <div
                        class="flex items-center gap-4 p-3 rounded-2xl bg-[#181f30]/50 border border-[#2a3249]/50 hover:border-[#dca34f]/30 transition-colors"
                    >
                        <div
                            class="p-2.5 rounded-xl bg-[#1c2336] text-gray-400"
                        >
                            <User class="size-4" />
                        </div>
                        <div>
                            <p
                                class="text-[10px] text-gray-500 uppercase font-bold tracking-wider mb-0.5"
                            >
                                Nickname (IGN)
                            </p>
                            <p class="text-gray-200 font-semibold text-sm">
                                {profile.nickname || 'Unknown'}
                            </p>
                        </div>
                    </div>

                    <div
                        class="flex items-center gap-4 p-3 rounded-2xl bg-[#181f30]/50 border border-[#2a3249]/50 hover:border-[#dca34f]/30 transition-colors"
                    >
                        <div
                            class="p-2.5 rounded-xl bg-[#1c2336] text-gray-400"
                        >
                            <User class="size-4" />
                        </div>
                        <div>
                            <p
                                class="text-[10px] text-gray-500 uppercase font-bold tracking-wider mb-0.5"
                            >
                                Real Name
                            </p>
                            <p class="text-gray-200 text-sm">
                                {profile.real_name || player.name}
                            </p>
                        </div>
                    </div>

                    <div
                        class="flex items-center gap-4 p-3 rounded-2xl bg-[#181f30]/50 border border-[#2a3249]/50 hover:border-[#dca34f]/30 transition-colors"
                    >
                        <div
                            class="p-2.5 rounded-xl bg-[#1c2336] text-gray-400"
                        >
                            <Fingerprint class="size-4" />
                        </div>
                        <div>
                            <p
                                class="text-[10px] text-gray-500 uppercase font-bold tracking-wider mb-0.5"
                            >
                                In-Game UID
                            </p>
                            <p class="text-gray-200 font-mono text-sm">
                                {profile.uid_game || 'Not Registered'}
                            </p>
                        </div>
                    </div>

                    <div
                        class="flex items-center gap-4 p-3 rounded-2xl bg-[#181f30]/50 border border-[#2a3249]/50 hover:border-[#dca34f]/30 transition-colors"
                    >
                        <div
                            class="p-2.5 rounded-xl bg-[#1c2336] text-gray-400"
                        >
                            <Mail class="size-4" />
                        </div>
                        <div class="overflow-hidden">
                            <p
                                class="text-[10px] text-gray-500 uppercase font-bold tracking-wider mb-0.5"
                            >
                                System Email
                            </p>
                            <p class="text-gray-200 text-sm truncate">
                                {player.email}
                            </p>
                        </div>
                    </div>

                    <div
                        class="flex items-center gap-4 p-3 rounded-2xl bg-[#181f30]/50 border border-[#2a3249]/50 hover:border-[#dca34f]/30 transition-colors"
                    >
                        <div
                            class="p-2.5 rounded-xl bg-[#1c2336] text-gray-400"
                        >
                            <Phone class="size-4" />
                        </div>
                        <div>
                            <p
                                class="text-[10px] text-gray-500 uppercase font-bold tracking-wider mb-0.5"
                            >
                                Comms Line (WA)
                            </p>
                            <p class="text-gray-200 font-mono text-sm">
                                {profile.whatsapp || 'Classified'}
                            </p>
                        </div>
                    </div>
                </div>

                {#if profile.bio}
                    <div
                        class="mt-6 pt-6 border-t border-[#2a3249]/50 relative"
                    >
                        <Quote
                            class="absolute top-4 right-2 size-10 text-[#2a3249]/40"
                        />
                        <p
                            class="text-[10px] text-[#00e5ff] uppercase font-bold tracking-wider mb-3"
                        >
                            Operator Biography
                        </p>
                        <p
                            class="text-gray-300 text-sm leading-relaxed italic relative z-10"
                        >
                            "{profile.bio}"
                        </p>
                    </div>
                {/if}
            </div>

            <div
                class="bg-[#131926]/80 rounded-3xl border border-[#2a3249] p-6 sm:p-8 shadow-xl"
            >
                <h3
                    class="text-sm font-black text-[#dca34f] uppercase tracking-widest mb-6 flex items-center gap-3"
                >
                    <ImageIcon class="size-5" /> Combat Statistics
                </h3>

                {#if profile.stats_photo}
                    <div
                        class="rounded-2xl overflow-hidden border-2 border-[#2a3249] group relative aspect-video bg-[#050810]"
                    >
                        <img
                            src={`/storage/${profile.stats_photo}`}
                            alt="Player Game Stats"
                            class="w-full h-full object-cover opacity-80 group-hover:opacity-100 transition-opacity duration-300 group-hover:scale-105"
                        />
                        <div
                            class="absolute inset-0 ring-1 ring-inset ring-white/10 pointer-events-none"
                        ></div>
                    </div>
                {:else}
                    <div
                        class="aspect-video rounded-2xl border border-dashed border-[#2a3249] bg-[#181f30]/50 flex flex-col items-center justify-center text-center px-6"
                    >
                        <ImageIcon class="size-8 text-gray-600 mb-3" />
                        <p
                            class="text-sm font-bold text-gray-400 uppercase tracking-widest"
                        >
                            No Visual Data
                        </p>
                        <p class="text-xs text-gray-600 mt-2">
                            Operator statistics screenshot has not been uploaded
                            to the mainframe.
                        </p>
                    </div>
                {/if}
            </div>
        </div>

        <div class="lg:col-span-7 space-y-8">
            <div
                class="bg-[#131926]/80 rounded-3xl border border-[#2a3249] p-6 sm:p-8 shadow-xl"
            >
                <h3
                    class="text-sm font-black text-[#dca34f] uppercase tracking-widest mb-6 flex items-center gap-3"
                >
                    <Swords class="size-5" /> Tactical Arsenal
                </h3>

                <div class="flex flex-wrap gap-3">
                    {#each profile.game_roles || [] as role}
                        <div
                            class="px-5 py-3 bg-[#181f30] text-gray-200 rounded-xl text-sm font-bold border border-[#2a3249] flex items-center gap-3 hover:border-[#dca34f]/50 transition-colors shadow-sm"
                        >
                            <div
                                class="w-2 h-2 rounded-full bg-[#dca34f] shadow-[0_0_8px_#dca34f]"
                            ></div>
                            {role.name}
                        </div>
                    {:else}
                        <p class="text-sm text-gray-500 italic px-2">
                            No specific roles assigned.
                        </p>
                    {/each}
                </div>

                {#if profile.vehicle_specializations?.length > 0}
                    <h3
                        class="text-sm font-black text-[#00e5ff] uppercase tracking-widest mb-6 mt-10 flex items-center gap-3 pt-6 border-t border-[#2a3249]/50"
                    >
                        <Car class="size-5" /> Vehicle Specializations
                    </h3>
                    <div class="flex flex-wrap gap-3">
                        {#each profile.vehicle_specializations as vehicle}
                            <div
                                class="px-5 py-3 bg-[#181f30] text-gray-200 rounded-xl text-sm font-bold border border-[#2a3249] flex items-center gap-3 hover:border-[#00e5ff]/50 transition-colors shadow-sm"
                            >
                                <div
                                    class="w-2 h-2 rounded-full bg-[#00e5ff] shadow-[0_0_8px_#00e5ff]"
                                ></div>
                                {vehicle.name}
                            </div>
                        {/each}
                    </div>
                {/if}
            </div>

            <div
                class="bg-[#131926]/80 rounded-3xl border border-[#2a3249] p-6 sm:p-8 shadow-xl"
            >
                <h3
                    class="text-sm font-black text-[#dca34f] uppercase tracking-widest mb-8 flex items-center gap-3"
                >
                    <History class="size-5" /> Transfer Logs
                </h3>

                <div
                    class="space-y-8 relative before:absolute before:inset-0 before:ml-[11px] md:before:mx-auto md:before:translate-x-0 before:h-full before:w-[2px] before:bg-gradient-to-b before:from-[#dca34f] before:via-[#2a3249] before:to-transparent"
                >
                    {#each player.transfer_histories || [] as history}
                        <div
                            class="relative flex items-center justify-between md:justify-normal md:odd:flex-row-reverse group"
                        >
                            <div
                                class="flex items-center justify-center w-6 h-6 rounded-full border-4 border-[#131926] bg-[#dca34f] shadow-[0_0_15px_#dca34f] shrink-0 md:order-1 md:group-odd:-translate-x-1/2 md:group-even:translate-x-1/2 z-10 transition-transform group-hover:scale-125"
                            ></div>

                            <div
                                class="w-[calc(100%-2.5rem)] md:w-[calc(50%-2rem)] bg-[#181f30] p-5 rounded-2xl border border-[#2a3249] shadow-lg group-hover:border-[#dca34f]/40 transition-all duration-300"
                            >
                                <div class="flex flex-col mb-1.5">
                                    <span
                                        class="text-[10px] text-[#00e5ff] font-black uppercase tracking-wider mb-1"
                                        >Status Update</span
                                    >
                                    <span
                                        class="font-bold text-gray-200 text-sm md:text-base leading-tight"
                                    >
                                        <span class="text-gray-400 font-normal"
                                            >{history.from_team ||
                                                'Unknown Origin'}</span
                                        >
                                        <span class="mx-2 text-[#dca34f]"
                                            >→</span
                                        >
                                        {history.to_team}
                                    </span>
                                </div>
                                <p
                                    class="text-[10px] text-gray-500 font-mono font-medium mb-3 uppercase"
                                >
                                    Logged: {new Date(
                                        history.created_at,
                                    ).toLocaleDateString('en-US', {
                                        year: 'numeric',
                                        month: 'short',
                                        day: 'numeric',
                                    })}
                                </p>
                                {#if history.notes}
                                    <div
                                        class="p-3 rounded-xl bg-[#131926] border border-[#2a3249]/50"
                                    >
                                        <p
                                            class="text-xs text-gray-400 leading-relaxed italic"
                                        >
                                            "{history.notes}"
                                        </p>
                                    </div>
                                {/if}
                            </div>
                        </div>
                    {:else}
                        <p
                            class="text-sm text-gray-500 font-medium italic pl-10 md:pl-0 md:text-center"
                        >
                            No transfer history recorded in system databanks.
                        </p>
                    {/each}
                </div>
            </div>
        </div>
    </div>
</div>
