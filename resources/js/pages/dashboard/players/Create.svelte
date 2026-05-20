<script lang="ts">
    import { Link, useForm } from '@inertiajs/svelte';

    export let divisions: Array<{ id: number; name: string }> = [];
    export let roles: Array<{ id: number; name: string }> = [];
    export let game_roles: Array<{ id: number; name: string; slug: string }> =
        [];
    export let vehicles: Array<{ id: number; name: string; slug: string }> = [];

    let form = useForm({
        real_name: '',
        email: '',
        nickname: '',
        uid_game: '',
        whatsapp: '',
        bio: '',
        photo: null as File | null,
        stats_photo: null as File | null,

        division_id: '',
        role_id: '',
        status: 'trial',

        selected_game_roles: [] as number[],
        selected_vehicles: [] as number[],

        record_history: false,
        from_team: '',
        to_team: 'Luxury Elite',
        history_notes: '',
    });

    const submit = () => {
        form.post('/dashboard/players', {
            preserveScroll: true,
            forceFormData: true,
            onSuccess: () => form.reset(),
        });
    };

    $: hasVehicleRole = form.selected_game_roles.some((id) => {
        const role = game_roles.find((r) => r.id === id);
        return role && (role.name === 'Vehicle' || role.slug === 'vehicle');
    });

    $: if (!hasVehicleRole) form.selected_vehicles = [];
    $: if (!form.record_history) {
        form.from_team = '';
        form.to_team = 'Luxury Elite';
        form.history_notes = '';
    }

    const icons = {
        close: `<svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"></path></svg>`,
        user: `<svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>`,
        contact: `<svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>`,
        phone: `<svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>`,
        upload: `<svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path></svg>`,
        chevron: `<svg class="w-4 h-4 text-gray-400 pointer-events-none absolute right-4 top-1/2 -translate-y-1/2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"></path></svg>`,
    };
</script>

<div
    class="fixed inset-0 z-50 bg-[#050810]/95 backdrop-blur-lg overflow-y-auto py-16 px-4 ms-10 mt-4 sm:px-6 lg:px-8 custom-scrollbar"
>
    <div
        class="max-w-5xl mx-auto bg-[#131926]/60 border border-[#2a3249]/60 shadow-2xl rounded-2xl relative backdrop-blur-xl mt-4 mb-12"
    >
        <Link
            href="/dashboard/players"
            class="absolute top-6 right-6 text-gray-400 hover:text-white transition-all bg-[#1c2336] hover:bg-[#dca34f] hover:text-gray-950 p-2.5 rounded-xl border border-[#2a3249] shadow-lg group"
        >
            {@html icons.close}
        </Link>

        <div class="p-6 sm:p-10">
            <div class="mb-10 pb-6 border-b border-[#2a3249]/50">
                <h2
                    class="text-2xl font-bold text-white flex items-center gap-3 tracking-wide"
                >
                    <span class="p-2 bg-[#dca34f]/10 rounded-xl text-[#dca34f]"
                        >{@html icons.user}</span
                    >
                    <span>Recruit Elite Player</span>
                </h2>
                <p class="text-gray-400 mt-2 text-sm max-w-xl">
                    Fill in the deployment parameters to induct a new tactical
                    asset into the Luxury Elite active roster.
                </p>
            </div>

            <form on:submit|preventDefault={submit} class="space-y-8">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-x-10 gap-y-8">
                    <div class="space-y-6">
                        <h3
                            class="text-md font-semibold text-[#dca34f] tracking-wider uppercase text-xs flex items-center gap-2"
                        >
                            <span class="w-1.5 h-3 bg-[#dca34f] rounded-full"
                            ></span>
                            Personal Details
                        </h3>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label
                                    class="block text-xs font-medium text-gray-400 mb-2 uppercase tracking-wider"
                                    >Real Name</label
                                >
                                <input
                                    type="text"
                                    bind:value={form.real_name}
                                    class="block w-full h-12 px-4 rounded-xl bg-[#181f30] border-[#2a3249] text-gray-100 focus:border-[#dca34f] focus:ring-1 focus:ring-[#dca34f] transition-all duration-200"
                                />
                                {#if form.errors.real_name}
                                    <div class="text-red-400 text-xs mt-1.5">
                                        {form.errors.real_name}
                                    </div>
                                {/if}
                            </div>
                            <div>
                                <label
                                    class="block text-xs font-medium text-gray-400 mb-2 uppercase tracking-wider"
                                    >Nickname (IGN)</label
                                >
                                <input
                                    type="text"
                                    bind:value={form.nickname}
                                    class="block w-full h-12 px-4 rounded-xl bg-[#181f30] border-[#2a3249] text-gray-100 focus:border-[#dca34f] focus:ring-1 focus:ring-[#dca34f] transition-all duration-200"
                                />
                                {#if form.errors.nickname}
                                    <div class="text-red-400 text-xs mt-1.5">
                                        {form.errors.nickname}
                                    </div>
                                {/if}
                            </div>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label
                                    class="block text-xs font-medium text-gray-400 mb-2 uppercase tracking-wider flex items-center gap-1.5"
                                >
                                    <span>Email</span>
                                </label>
                                <div class="relative">
                                    <span
                                        class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-500"
                                        >{@html icons.contact}</span
                                    >
                                    <input
                                        type="email"
                                        bind:value={form.email}
                                        class="block w-full h-12 pl-10 pr-4 rounded-xl bg-[#181f30] border-[#2a3249] text-gray-100 focus:border-[#dca34f] focus:ring-1 focus:ring-[#dca34f] transition-all duration-200"
                                    />
                                </div>
                                {#if form.errors.email}
                                    <div class="text-red-400 text-xs mt-1.5">
                                        {form.errors.email}
                                    </div>
                                {/if}
                            </div>
                            <div>
                                <label
                                    class="block text-xs font-medium text-gray-400 mb-2 uppercase tracking-wider flex items-center gap-1.5"
                                >
                                    <span>Whatsapp</span>
                                </label>
                                <div class="relative">
                                    <input
                                        type="text"
                                        bind:value={form.whatsapp}
                                        placeholder="+6281xxxxx"
                                        class="block w-full h-12 px-4 rounded-xl bg-[#181f30] border-[#2a3249] text-gray-100 focus:border-[#dca34f] focus:ring-1 focus:ring-[#dca34f] transition-all duration-200"
                                    />
                                </div>
                                {#if form.errors.whatsapp}
                                    <div class="text-red-400 text-xs mt-1.5">
                                        {form.errors.whatsapp}
                                    </div>
                                {/if}
                            </div>
                        </div>

                        <div>
                            <label
                                class="block text-xs font-medium text-gray-400 mb-2 uppercase tracking-wider"
                                >In-Game UID</label
                            >
                            <input
                                type="text"
                                bind:value={form.uid_game}
                                class="block w-full h-12 px-4 rounded-xl bg-[#181f30] border-[#2a3249] text-gray-100 focus:border-[#dca34f] focus:ring-1 focus:ring-[#dca34f] transition-all duration-200"
                            />
                        </div>

                        <div>
                            <label
                                class="block text-xs font-medium text-gray-400 mb-2 uppercase tracking-wider"
                                >Player Bio <span class="text-gray-600"
                                    >(Optional)</span
                                ></label
                            >
                            <textarea
                                bind:value={form.bio}
                                rows="3"
                                class="block w-full p-4 rounded-xl bg-[#181f30] border-[#2a3249] text-gray-100 focus:border-[#dca34f] focus:ring-1 focus:ring-[#dca34f] transition-all duration-200 resize-none"
                            ></textarea>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label
                                    class="block text-xs font-medium text-gray-400 mb-2 uppercase tracking-wider"
                                    >Player Photo</label
                                >
                                <div
                                    class="relative flex items-center justify-center h-24 rounded-xl border border-dashed border-[#2a3249] bg-[#181f30] hover:border-[#dca34f]/50 transition-all group overflow-hidden"
                                >
                                    <input
                                        type="file"
                                        accept="image/*"
                                        on:input={(e) =>
                                            (form.photo = e.target.files[0])}
                                        class="absolute inset-0 opacity-0 cursor-pointer z-10"
                                    />
                                    <div
                                        class="text-center pointer-events-none space-y-1"
                                    >
                                        <span
                                            class="text-gray-400 group-hover:text-[#dca34f] transition-colors flex justify-center"
                                            >{@html icons.upload}</span
                                        >
                                        <span
                                            class="block text-xs text-gray-400 font-medium"
                                        >
                                            {form.photo
                                                ? form.photo.name
                                                : 'Select Photo Asset'}
                                        </span>
                                    </div>
                                </div>
                                {#if form.errors.photo}
                                    <div class="text-red-400 text-xs mt-1.5">
                                        {form.errors.photo}
                                    </div>
                                {/if}
                            </div>
                            <div>
                                <label
                                    class="block text-xs font-medium text-gray-400 mb-2 uppercase tracking-wider"
                                    >Stats Photo Asset</label
                                >
                                <div
                                    class="relative flex items-center justify-center h-24 rounded-xl border border-dashed border-[#2a3249] bg-[#181f30] hover:border-[#dca34f]/50 transition-all group overflow-hidden"
                                >
                                    <input
                                        type="file"
                                        accept="image/*"
                                        on:input={(e) =>
                                            (form.stats_photo =
                                                e.target.files[0])}
                                        class="absolute inset-0 opacity-0 cursor-pointer z-10"
                                    />
                                    <div
                                        class="text-center pointer-events-none space-y-1"
                                    >
                                        <span
                                            class="text-gray-400 group-hover:text-[#dca34f] transition-colors flex justify-center"
                                            >{@html icons.upload}</span
                                        >
                                        <span
                                            class="block text-xs text-gray-400 font-medium"
                                        >
                                            {form.stats_photo
                                                ? form.stats_photo.name
                                                : 'Select Stats File'}
                                        </span>
                                    </div>
                                </div>
                                {#if form.errors.stats_photo}
                                    <div class="text-red-400 text-xs mt-1.5">
                                        {form.errors.stats_photo}
                                    </div>
                                {/if}
                            </div>
                        </div>
                    </div>

                    <div class="space-y-6">
                        <h3
                            class="text-md font-semibold text-[#dca34f] tracking-wider uppercase text-xs flex items-center gap-2"
                        >
                            <span class="w-1.5 h-3 bg-[#dca34f] rounded-full"
                            ></span>
                            Clan Placement
                        </h3>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label
                                    class="block text-xs font-medium text-gray-400 mb-2 uppercase tracking-wider"
                                    >Division</label
                                >
                                <div class="relative">
                                    <select
                                        bind:value={form.division_id}
                                        class="block w-full h-12 px-4 rounded-xl bg-[#181f30] border-[#2a3249] text-gray-100 focus:border-[#dca34f] focus:ring-1 focus:ring-[#dca34f] appearance-none transition-all duration-200"
                                    >
                                        <option value="" disabled
                                            >-- Select Division --</option
                                        >
                                        {#each divisions as division}
                                            <option value={division.id}
                                                >{division.name}</option
                                            >
                                        {/each}
                                    </select>
                                    {@html icons.chevron}
                                </div>
                            </div>
                            <div>
                                <label
                                    class="block text-xs font-medium text-gray-400 mb-2 uppercase tracking-wider"
                                    >System Role</label
                                >
                                <div class="relative">
                                    <select
                                        bind:value={form.role_id}
                                        class="block w-full h-12 px-4 rounded-xl bg-[#181f30] border-[#2a3249] text-gray-100 focus:border-[#dca34f] focus:ring-1 focus:ring-[#dca34f] appearance-none transition-all duration-200"
                                    >
                                        <option value="" disabled
                                            >-- Select Role --</option
                                        >
                                        {#each roles as role}
                                            <option value={role.id}
                                                >{role.name}</option
                                            >
                                        {/each}
                                    </select>
                                    {@html icons.chevron}
                                </div>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label
                                    class="block text-xs font-medium text-gray-400 mb-2 uppercase tracking-wider"
                                    >Status</label
                                >
                                <div class="relative">
                                    <select
                                        bind:value={form.status}
                                        class="block w-full h-12 px-4 rounded-xl bg-[#181f30] border-[#2a3249] text-gray-100 focus:border-[#dca34f] focus:ring-1 focus:ring-[#dca34f] appearance-none transition-all duration-200"
                                    >
                                        <option value="trial">Trial</option>
                                        <option value="active"
                                            >Active Player</option
                                        >
                                        <option value="exit">Exit</option>
                                        <option value="transfer"
                                            >Transfer</option
                                        >
                                    </select>
                                    {@html icons.chevron}
                                </div>
                            </div>

                            <div class="flex items-center sm:pt-6">
                                <label
                                    class="flex items-center cursor-pointer group select-none"
                                >
                                    <input
                                        type="checkbox"
                                        bind:checked={form.record_history}
                                        class="w-5 h-5 rounded-lg border-[#2a3249] bg-[#181f30] text-[#dca34f] focus:ring-0 focus:ring-offset-0 checked:bg-[#dca34f] transition-all"
                                    />
                                    <span
                                        class="ml-3 text-xs font-medium text-gray-400 group-hover:text-white uppercase tracking-wider transition-colors"
                                    >
                                        Record History?
                                    </span>
                                </label>
                            </div>
                        </div>

                        {#if form.record_history}
                            <div
                                class="bg-[#101522] border border-[#2a3249] rounded-xl p-5 space-y-4 shadow-inner"
                            >
                                <div
                                    class="grid grid-cols-1 sm:grid-cols-2 gap-4"
                                >
                                    <div>
                                        <label
                                            class="block text-xs font-medium text-[#dca34f] mb-2 uppercase tracking-wider"
                                            >From Team</label
                                        >
                                        <input
                                            type="text"
                                            bind:value={form.from_team}
                                            placeholder="Ex: EVOS, Free Agent..."
                                            class="block w-full h-11 px-4 rounded-lg bg-[#181f30] border-[#2a3249] text-gray-200 text-sm focus:border-[#dca34f] focus:ring-0"
                                        />
                                        {#if form.errors.from_team}
                                            <div
                                                class="text-red-400 text-xs mt-1"
                                            >
                                                {form.errors.from_team}
                                            </div>
                                        {/if}
                                    </div>
                                    <div>
                                        <label
                                            class="block text-xs font-medium text-gray-400 mb-2 uppercase tracking-wider"
                                            >To Team</label
                                        >
                                        <input
                                            type="text"
                                            bind:value={form.to_team}
                                            class="block w-full h-11 px-4 rounded-lg bg-[#181f30] border-[#2a3249] text-gray-200 text-sm focus:border-[#dca34f] focus:ring-0"
                                        />
                                    </div>
                                </div>
                                <div>
                                    <label
                                        class="block text-xs font-medium text-gray-400 mb-2 uppercase tracking-wider"
                                        >Transfer Notes</label
                                    >
                                    <input
                                        type="text"
                                        bind:value={form.history_notes}
                                        placeholder="Ex: Mid-season strategic window transfer..."
                                        class="block w-full h-11 px-4 rounded-lg bg-[#181f30] border-[#2a3249] text-gray-200 text-sm focus:border-[#dca34f] focus:ring-0"
                                    />
                                </div>
                            </div>
                        {/if}

                        <div class="pt-4 border-t border-[#2a3249]/30">
                            <h3
                                class="text-md font-semibold text-[#dca34f] tracking-wider uppercase text-xs mb-4 flex items-center gap-2"
                            >
                                <span
                                    class="w-1.5 h-3 bg-[#dca34f] rounded-full"
                                ></span>
                                Tactical Expertise
                            </h3>

                            <div
                                class="bg-[#101522] border border-[#2a3249]/60 rounded-xl p-5 shadow-inner space-y-4"
                            >
                                <label
                                    class="block text-xs font-semibold text-gray-400 uppercase tracking-wider"
                                    >Select Combat Roles</label
                                >
                                <div class="grid grid-cols-2 gap-3">
                                    {#each game_roles as role}
                                        <label
                                            class="flex items-center gap-3 cursor-pointer group p-2 rounded-lg hover:bg-[#181f30] transition-all select-none"
                                        >
                                            <input
                                                type="checkbox"
                                                value={role.id}
                                                bind:group={
                                                    form.selected_game_roles
                                                }
                                                class="w-4 h-4 rounded border-[#2a3249] bg-[#141a29] text-[#dca34f] focus:ring-0"
                                            />
                                            <span
                                                class="text-sm text-gray-400 group-hover:text-[#dca34f] transition-colors"
                                                >{role.name}</span
                                            >
                                        </label>
                                    {/each}
                                </div>
                            </div>
                        </div>

                        {#if hasVehicleRole}
                            <div
                                class="bg-[#131926] border border-[#dca34f]/30 rounded-xl p-5 relative overflow-hidden transition-all duration-300"
                            >
                                <div
                                    class="absolute -right-6 -bottom-6 text-white/5 pointer-events-none scale-150"
                                ></div>
                                <label
                                    class="block text-xs font-semibold text-[#dca34f] uppercase tracking-wider mb-3"
                                    >Vehicle Specializations</label
                                >
                                <div
                                    class="grid grid-cols-2 gap-3 relative z-10"
                                >
                                    {#each vehicles as vehicle}
                                        <label
                                            class="flex items-center gap-3 cursor-pointer group p-2 rounded-lg hover:bg-[#1c2336] transition-all select-none"
                                        >
                                            <input
                                                type="checkbox"
                                                value={vehicle.id}
                                                bind:group={
                                                    form.selected_vehicles
                                                }
                                                class="w-4 h-4 rounded border-[#2a3249] bg-[#141a29] text-[#dca34f] focus:ring-0"
                                            />
                                            <span
                                                class="text-sm text-gray-400 group-hover:text-white transition-colors"
                                                >{vehicle.name}</span
                                            >
                                        </label>
                                    {/each}
                                </div>
                            </div>
                        {/if}
                    </div>
                </div>

                <div class="pt-6 border-t border-[#2a3249]/40 flex justify-end">
                    <button
                        type="submit"
                        disabled={form.processing}
                        class="w-full sm:w-auto min-w-[200px] flex justify-center items-center h-12 px-6 rounded-xl shadow-lg text-sm font-bold text-gray-950 bg-[#dca34f] hover:bg-[#e7b66a] focus:ring-2 focus:ring-[#dca34f]/50 disabled:opacity-40 transition-all duration-200 transform hover:-translate-y-0.5 active:translate-y-0"
                    >
                        {#if form.processing}
                            <span class="animate-pulse tracking-wide"
                                >Processing Recruitment Asset...</span
                            >
                        {:else}
                            <span
                                class="flex items-center gap-2 uppercase tracking-wider"
                                >Confirm Registration</span
                            >
                        {/if}
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
    /* Custom refined scrollbar utility */
    :global(.custom-scrollbar::-webkit-scrollbar) {
        width: 6px;
    }
    :global(.custom-scrollbar::-webkit-scrollbar-track) {
        background: #050810;
    }
    :global(.custom-scrollbar::-webkit-scrollbar-thumb) {
        background: #2a3249;
        border-radius: 999px;
    }
    :global(.custom-scrollbar::-webkit-scrollbar-thumb:hover) {
        background: #dca34f;
    }
</style>
