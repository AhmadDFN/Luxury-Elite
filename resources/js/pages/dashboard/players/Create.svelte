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

        // Logika Transfer History
        record_history: false,
        from_team: '',
        to_team: 'Luxury Elite', // Default ke tim kita karena form ini untuk rekrutmen
        history_notes: '',
    });

    const submit = () => {
        form.post('/dashboard/players', {
            preserveScroll: true,
            // Wajib true jika ada file upload (foto)
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
        close: `<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>`,
        user: `<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>`,
        contact: `<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>`,
        phone: `<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>`,
        upload: `<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path></svg>`,
    };
</script>

<div
    class="fixed inset-0 z-[100] bg-[#070b14]/80 backdrop-blur-md overflow-y-auto py-10 px-4 sm:px-6"
>
    <div
        class="max-w-5xl mx-auto bg-[#1f2438] border border-[#3e4460]/50 shadow-2xl rounded-2xl relative transition-all duration-300"
    >
        <Link
            href="/dashboard/players"
            class="absolute top-6 right-6 text-gray-400 hover:text-red-400 transition-colors bg-[#282d42] p-2 rounded-full border border-[#3e4460]/50 hover:bg-[#282d42]/80 z-10"
        >
            {@html icons.close}
        </Link>

        <div class="p-8 sm:p-10">
            <div class="mb-10 pb-4 border-b border-[#3e4460]/50">
                <h2
                    class="text-3xl font-bold text-gray-100 flex items-center gap-3"
                >
                    <span class="text-[#dca34f]">{@html icons.user}</span>
                    <span>Recruit Elite Player</span>
                </h2>
                <p class="text-gray-400 mt-2 text-sm">
                    Add a new player to the Luxury Elite roster. Fill in the
                    details below.
                </p>
            </div>

            <form on:submit|preventDefault={submit} class="space-y-10">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-x-12 gap-y-10">
                    <div class="space-y-6">
                        <h3
                            class="text-lg font-semibold text-gray-300 border-l-4 border-[#dca34f] pl-3"
                        >
                            Personal Details
                        </h3>

                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label
                                    class="block text-sm font-medium text-gray-400 mb-1.5"
                                    >Real Name</label
                                >
                                <input
                                    type="text"
                                    bind:value={form.real_name}
                                    class="block w-full rounded-xl bg-[#282d42] border-[#3e4460] text-gray-100 focus:border-[#dca34f] focus:ring-[#dca34f]"
                                />
                                {#if form.errors.real_name}
                                    <div class="text-red-400 text-xs mt-1">
                                        {form.errors.real_name}
                                    </div>
                                {/if}
                            </div>
                            <div>
                                <label
                                    class="block text-sm font-medium text-gray-400 mb-1.5"
                                    >Nickname (IGN)</label
                                >
                                <input
                                    type="text"
                                    bind:value={form.nickname}
                                    class="block w-full rounded-xl bg-[#282d42] border-[#3e4460] text-gray-100 focus:border-[#dca34f] focus:ring-[#dca34f]"
                                />
                                {#if form.errors.nickname}
                                    <div class="text-red-400 text-xs mt-1">
                                        {form.errors.nickname}
                                    </div>
                                {/if}
                            </div>
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label
                                    class="block text-sm font-medium text-gray-400 mb-1.5 flex items-center gap-2"
                                    >{@html icons.contact} Email</label
                                >
                                <input
                                    type="email"
                                    bind:value={form.email}
                                    class="block w-full rounded-xl bg-[#282d42] border-[#3e4460] text-gray-100 focus:border-[#dca34f] focus:ring-[#dca34f]"
                                />
                                {#if form.errors.email}
                                    <div class="text-red-400 text-xs mt-1">
                                        {form.errors.email}
                                    </div>
                                {/if}
                            </div>
                            <div>
                                <label
                                    class="block text-sm font-medium text-gray-400 mb-1.5 flex items-center gap-2"
                                    >{@html icons.phone} Whatsapp</label
                                >
                                <input
                                    type="text"
                                    bind:value={form.whatsapp}
                                    placeholder="+628..."
                                    class="block w-full rounded-xl bg-[#282d42] border-[#3e4460] text-gray-100 focus:border-[#dca34f] focus:ring-[#dca34f]"
                                />
                                {#if form.errors.whatsapp}
                                    <div class="text-red-400 text-xs mt-1">
                                        {form.errors.whatsapp}
                                    </div>
                                {/if}
                            </div>
                        </div>

                        <div>
                            <label
                                class="block text-sm font-medium text-gray-400 mb-1.5"
                                >In-Game UID</label
                            >
                            <input
                                type="text"
                                bind:value={form.uid_game}
                                class="block w-full rounded-xl bg-[#282d42] border-[#3e4460] text-gray-100 focus:border-[#dca34f] focus:ring-[#dca34f]"
                            />
                        </div>

                        <div>
                            <label
                                class="block text-sm font-medium text-gray-400 mb-1.5"
                                >Player Bio (Optional)</label
                            >
                            <textarea
                                bind:value={form.bio}
                                rows="3"
                                class="block w-full rounded-xl bg-[#282d42] border-[#3e4460] text-gray-100 focus:border-[#dca34f] focus:ring-[#dca34f] resize-none"
                            ></textarea>
                        </div>

                        <div class="grid grid-cols-2 gap-4 pt-2">
                            <div>
                                <label
                                    class="block text-sm font-medium text-gray-400 mb-1.5 flex items-center gap-2"
                                    >{@html icons.upload} Player Photo</label
                                >
                                <input
                                    type="file"
                                    accept="image/*"
                                    on:input={(e) =>
                                        (form.photo = e.target.files[0])}
                                    class="block w-full text-sm text-gray-400 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-sm file:font-semibold file:bg-[#dca34f] file:text-gray-900 hover:file:bg-[#e7b66a] transition-all cursor-pointer bg-[#282d42] rounded-xl border border-[#3e4460]"
                                />
                                {#if form.errors.photo}
                                    <div class="text-red-400 text-xs mt-1">
                                        {form.errors.photo}
                                    </div>
                                {/if}
                            </div>
                            <div>
                                <label
                                    class="block text-sm font-medium text-gray-400 mb-1.5 flex items-center gap-2"
                                    >{@html icons.upload} Stats Photo</label
                                >
                                <input
                                    type="file"
                                    accept="image/*"
                                    on:input={(e) =>
                                        (form.stats_photo = e.target.files[0])}
                                    class="block w-full text-sm text-gray-400 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-sm file:font-semibold file:bg-[#3e4460] file:text-gray-200 hover:file:bg-[#4a5173] transition-all cursor-pointer bg-[#282d42] rounded-xl border border-[#3e4460]"
                                />
                                {#if form.errors.stats_photo}
                                    <div class="text-red-400 text-xs mt-1">
                                        {form.errors.stats_photo}
                                    </div>
                                {/if}
                            </div>
                        </div>
                    </div>

                    <div class="space-y-6">
                        <h3
                            class="text-lg font-semibold text-gray-300 border-l-4 border-[#dca34f] pl-3"
                        >
                            Clan Placement
                        </h3>

                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label
                                    class="block text-sm font-medium text-gray-400 mb-1.5"
                                    >Division</label
                                >
                                <select
                                    bind:value={form.division_id}
                                    class="block w-full rounded-xl bg-[#282d42] border-[#3e4460] text-gray-100 focus:border-[#dca34f] focus:ring-[#dca34f]"
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
                            </div>
                            <div>
                                <label
                                    class="block text-sm font-medium text-gray-400 mb-1.5"
                                    >System Role</label
                                >
                                <select
                                    bind:value={form.role_id}
                                    class="block w-full rounded-xl bg-[#282d42] border-[#3e4460] text-gray-100 focus:border-[#dca34f] focus:ring-[#dca34f]"
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
                            </div>
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label
                                    class="block text-sm font-medium text-gray-400 mb-1.5"
                                    >Membership Status</label
                                >
                                <select
                                    bind:value={form.status}
                                    class="block w-full rounded-xl bg-[#282d42] border-[#3e4460] text-gray-100 focus:border-[#dca34f] focus:ring-[#dca34f]"
                                >
                                    <option value="trial">Trial</option>
                                    <option value="active">Active Player</option
                                    >
                                    <option value="exit">Exit</option>
                                    <option value="transfer">Transfer</option>
                                </select>
                            </div>

                            <div class="flex items-center pt-6">
                                <label
                                    class="flex items-center cursor-pointer group"
                                >
                                    <input
                                        type="checkbox"
                                        bind:checked={form.record_history}
                                        class="w-5 h-5 rounded border-[#3e4460] bg-[#1f2438] text-[#dca34f] focus:ring-[#dca34f] transition-colors"
                                    />
                                    <span
                                        class="ml-3 text-sm text-gray-300 group-hover:text-white transition-colors"
                                        >Record Previous Team / Transfer
                                        History?</span
                                    >
                                </label>
                            </div>
                        </div>

                        {#if form.record_history}
                            <div
                                class="bg-[#282d42] border border-[#3e4460] rounded-xl p-5 space-y-5 shadow-inner"
                            >
                                <div class="grid grid-cols-2 gap-4">
                                    <div>
                                        <label
                                            class="block text-sm font-medium text-[#dca34f] mb-1.5"
                                            >From Team</label
                                        >
                                        <input
                                            type="text"
                                            bind:value={form.from_team}
                                            placeholder="Ex: EVOS, Elite Esport, Free Agent..."
                                            class="block w-full rounded-lg bg-[#1f2438] border-[#3e4460] text-gray-200 text-sm focus:border-[#dca34f] focus:ring-[#dca34f]"
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
                                            class="block text-sm font-medium text-gray-400 mb-1.5"
                                            >To Team</label
                                        >
                                        <input
                                            type="text"
                                            bind:value={form.to_team}
                                            class="block w-full rounded-lg bg-[#1f2438] border-[#3e4460] text-gray-400 text-sm focus:border-[#dca34f] focus:ring-[#dca34f]"
                                        />
                                    </div>
                                </div>
                                <div>
                                    <label
                                        class="block text-sm font-medium text-gray-400 mb-1.5"
                                        >Transfer Notes (Optional)</label
                                    >
                                    <input
                                        type="text"
                                        bind:value={form.history_notes}
                                        placeholder="Ex: Acquired during mid-season transfer window..."
                                        class="block w-full rounded-lg bg-[#1f2438] border-[#3e4460] text-gray-200 text-sm focus:border-[#dca34f] focus:ring-[#dca34f]"
                                    />
                                </div>
                            </div>
                        {/if}

                        <h3
                            class="text-lg font-semibold text-gray-300 border-l-4 border-[#dca34f] pl-3 pt-4 mt-6 border-t border-[#3e4460]/50"
                        >
                            In-Game Expertise
                        </h3>

                        <div
                            class="bg-[#282d42] border border-[#3e4460]/50 rounded-xl p-4 shadow-inner"
                        >
                            <label
                                class="block text-sm font-medium text-gray-400 mb-3"
                                >Select Game Roles</label
                            >
                            <div class="grid grid-cols-2 gap-3">
                                {#each game_roles as role}
                                    <label
                                        class="flex items-center gap-3 cursor-pointer group"
                                    >
                                        <input
                                            type="checkbox"
                                            value={role.id}
                                            bind:group={
                                                form.selected_game_roles
                                            }
                                            class="w-4 h-4 rounded border-[#3e4460] bg-[#1f2438] text-[#dca34f] focus:ring-[#dca34f]"
                                        />
                                        <span
                                            class="text-sm text-gray-300 group-hover:text-[#dca34f]"
                                            >{role.name}</span
                                        >
                                    </label>
                                {/each}
                            </div>
                        </div>

                        {#if hasVehicleRole}
                            <div
                                class="bg-[#1f2438] border border-[#dca34f]/30 rounded-xl p-4 relative overflow-hidden"
                            >
                                <label
                                    class="block text-sm font-medium text-[#dca34f] mb-3"
                                    >Vehicle Specializations</label
                                >
                                <div
                                    class="grid grid-cols-2 gap-3 relative z-10"
                                >
                                    {#each vehicles as vehicle}
                                        <label
                                            class="flex items-center gap-3 cursor-pointer group"
                                        >
                                            <input
                                                type="checkbox"
                                                value={vehicle.id}
                                                bind:group={
                                                    form.selected_vehicles
                                                }
                                                class="w-4 h-4 rounded border-[#3e4460] bg-[#282d42] text-indigo-500 focus:ring-indigo-500"
                                            />
                                            <span
                                                class="text-sm text-gray-300 group-hover:text-white"
                                                >{vehicle.name}</span
                                            >
                                        </label>
                                    {/each}
                                </div>
                            </div>
                        {/if}
                    </div>
                </div>

                <div class="pt-6 border-t border-[#3e4460]/50">
                    <button
                        type="submit"
                        disabled={form.processing}
                        class="w-full flex justify-center py-4 px-6 rounded-xl shadow-xl text-md font-bold text-gray-950 bg-[#dca34f] hover:bg-[#e7b66a] focus:ring-2 focus:ring-[#dca34f] disabled:opacity-50 transition-all duration-200 transform hover:-translate-y-0.5"
                    >
                        {#if form.processing}
                            <span class="animate-pulse"
                                >Uploading Data & Processing...</span
                            >
                        {:else}
                            <span class="flex items-center gap-2"
                                >{@html icons.user} Confirm Registration</span
                            >
                        {/if}
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
