<script lang="ts">
    import { Link, router } from '@inertiajs/svelte';
    import { Plus, Search, Eye, Edit2, Trash2 } from 'lucide-svelte';
    import Swal from 'sweetalert2'; // WAJIB DIIMPORT UNTUK POPUP KONFIRMASI KEKINIAN

    // Data dari Laravel
    export let players: Array<{
        id: number;
        nickname: string;
        real_name: string;
        uid_game: string;
        division: string;
        role: string;
        photo?: string;
    }> = [];

    // Fungsi menghapus dengan SweetAlert2 (Kekinian & Mewah)
    const deletePlayer = (id: number, name: string) => {
        Swal.fire({
            title: 'Terminate Contract?',
            html: `Are you sure you want to dismiss <strong>${name}</strong> from the roster? <br><br> <span class="text-xs text-rose-400">This action cannot be undone.</span>`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#e11d48', // Merah (Rose) untuk tombol bahaya
            cancelButtonColor: '#1f2937', // Abu-abu untuk batal
            confirmButtonText: 'Yes, Terminate',
            cancelButtonText: 'Cancel',
            background: '#0b101e', // Tema Dark
            color: '#fff',
            backdrop: 'rgba(0,0,0,0.85)', // Background belakang blur/gelap
            customClass: {
                popup: 'border border-[#2d344f] rounded-2xl shadow-2xl',
                confirmButton: 'rounded-xl font-bold px-6 py-2',
                cancelButton: 'rounded-xl font-bold px-6 py-2',
            },
        }).then((result) => {
            // Jika user klik "Yes, Terminate"
            if (result.isConfirmed) {
                // Inertia akan menembak rute delete di Laravel
                router.delete(`/dashboard/players/${id}`, {
                    preserveScroll: true,
                    // Kita TUNGGU Laravel merespon sukses
                    // Jika sukses, Laravel akan mengirim "message"
                    // Dan "Notification.svelte" global kita akan otomatis memunculkan Sonner!
                });
            }
        });
    };

    const icons = {
        add: `<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>`,
        search: `<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>`,
        show: `<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>`,
        edit: `<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>`,
        delete: `<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>`,
    };
</script>

<div class="max-w-7xl mx-auto space-y-8 py-8">
    <div
        class="flex flex-col md:flex-row justify-between items-start md:items-end gap-6"
    >
        <div class="space-y-2">
            <div
                class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-[#dca34f]/10 border border-[#dca34f]/30 text-[#dca34f] text-xs font-bold tracking-widest uppercase mb-2"
            >
                <span class="w-2 h-2 rounded-full bg-[#dca34f] animate-pulse"
                ></span>
                Official Team
            </div>
            <h1
                class="text-4xl md:text-5xl font-extrabold text-transparent bg-clip-text bg-gradient-to-r from-[#dca34f] to-[#f4d49a] tracking-tight"
            >
                Luxury Elite Roster
            </h1>
            <p class="text-gray-400 text-sm md:text-base max-w-lg">
                Manage your elite players, structure team divisions, and command
                the ultimate competitive roster.
            </p>
        </div>

        <div
            class="flex flex-col sm:flex-row items-center gap-4 w-full md:w-auto"
        >
            <div class="relative w-full sm:w-72 group">
                <div
                    class="absolute inset-y-0 left-0 flex items-center pl-4 text-gray-500 group-focus-within:text-[#dca34f] transition-colors duration-300"
                >
                    {@html icons.search}
                </div>
                <input
                    type="text"
                    placeholder="Search nickname or UID..."
                    class="block w-full rounded-2xl bg-[#15192b] border border-[#2d344f] text-gray-200 placeholder-gray-500 pl-11 pr-4 py-3 focus:border-[#dca34f] focus:ring-[#dca34f] focus:ring-1 sm:text-sm transition-all duration-300 shadow-inner"
                />
            </div>

            <Link
                href="/dashboard/players/create"
                class="relative group flex-shrink-0 flex items-center gap-2 bg-gradient-to-r from-[#dca34f] to-[#c78b30] hover:from-[#f4d49a] hover:to-[#dca34f] text-gray-950 font-bold py-3 px-6 rounded-2xl shadow-[0_0_20px_rgba(220,163,79,0.2)] hover:shadow-[0_0_30px_rgba(220,163,79,0.4)] transition-all duration-300 transform hover:-translate-y-1"
            >
                <span class="relative z-10 flex items-center gap-2">
                    {@html icons.add}
                    <span>Recruit Player</span>
                </span>
                <div
                    class="absolute inset-0 h-full w-full rounded-2xl opacity-0 group-hover:opacity-20 bg-white transition-opacity duration-300"
                ></div>
            </Link>
        </div>
    </div>

    <div class="relative group">
        <div
            class="absolute -inset-0.5 bg-gradient-to-b from-[#dca34f]/20 to-transparent rounded-[1.25rem] blur opacity-30 group-hover:opacity-50 transition duration-500"
        ></div>

        <div
            class="relative bg-[#1a1f33] rounded-2xl shadow-2xl border border-[#2d344f] overflow-hidden backdrop-blur-sm"
        >
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr
                            class="bg-[#111526]/80 text-gray-400 text-xs uppercase tracking-widest border-b border-[#2d344f]"
                        >
                            <th class="px-8 py-5 font-bold">Player Identity</th>
                            <th class="px-6 py-5 font-bold">In-Game UID</th>
                            <th class="px-6 py-5 font-bold">Division</th>
                            <th class="px-6 py-5 font-bold">Role</th>
                            <th class="px-8 py-5 font-bold text-right"
                                >Command</th
                            >
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-[#2d344f]/50 text-gray-300">
                        {#if players.length === 0}
                            <tr>
                                <td colspan="5" class="px-6 py-24 text-center">
                                    <div
                                        class="inline-flex items-center justify-center w-20 h-20 rounded-full bg-[#111526] border border-dashed border-[#dca34f]/30 text-[#dca34f] mb-5 shadow-[0_0_15px_rgba(220,163,79,0.1)]"
                                    >
                                        {@html icons.add}
                                    </div>
                                    <h3
                                        class="text-xl font-bold text-gray-100 mb-2"
                                    >
                                        Roster is Currently Empty
                                    </h3>
                                    <p class="text-gray-500 max-w-sm mx-auto">
                                        No elite players have been recruited
                                        yet. Add your first player to begin your
                                        path to victory.
                                    </p>
                                </td>
                            </tr>
                        {:else}
                            {#each players as player}
                                <tr
                                    class="hover:bg-gradient-to-r hover:from-[#dca34f]/5 hover:to-transparent transition-all duration-300 group/row"
                                >
                                    <td class="px-8 py-5 whitespace-nowrap">
                                        <div class="flex items-center gap-4">
                                            <div class="relative">
                                                {#if player.photo}
                                                    <img
                                                        src={player.photo}
                                                        alt={player.nickname}
                                                        class="w-12 h-12 rounded-xl object-cover ring-2 ring-[#dca34f]/30 group-hover/row:ring-[#dca34f] shadow-lg transition-all duration-300"
                                                    />
                                                {:else}
                                                    <div
                                                        class="w-12 h-12 rounded-xl bg-gradient-to-br from-[#111526] to-[#1f2642] ring-2 ring-[#dca34f]/30 group-hover/row:ring-[#dca34f] flex items-center justify-center text-[#dca34f] text-lg font-bold shadow-lg transition-all duration-300"
                                                    >
                                                        {player.nickname
                                                            .charAt(0)
                                                            .toUpperCase()}
                                                    </div>
                                                {/if}
                                                <div
                                                    class="absolute -bottom-1 -right-1 w-3.5 h-3.5 bg-emerald-500 border-2 border-[#1a1f33] rounded-full"
                                                ></div>
                                            </div>

                                            <div>
                                                <div
                                                    class="text-base font-bold text-gray-100 group-hover/row:text-[#dca34f] transition-colors duration-300"
                                                >
                                                    {player.nickname}
                                                </div>
                                                <div
                                                    class="text-xs text-gray-500 uppercase tracking-wide mt-0.5"
                                                >
                                                    {player.real_name}
                                                </div>
                                            </div>
                                        </div>
                                    </td>

                                    <td class="px-6 py-5 whitespace-nowrap">
                                        <div
                                            class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-black/40 border border-white/5 shadow-inner"
                                        >
                                            <svg
                                                class="w-3.5 h-3.5 text-gray-500"
                                                fill="none"
                                                stroke="currentColor"
                                                viewBox="0 0 24 24"
                                                ><path
                                                    stroke-linecap="round"
                                                    stroke-linejoin="round"
                                                    stroke-width="2"
                                                    d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4"
                                                ></path></svg
                                            >
                                            <span
                                                class="font-mono text-sm font-semibold text-gray-300 tracking-wider"
                                            >
                                                {player.uid_game ||
                                                    'UNREGISTERED'}
                                            </span>
                                        </div>
                                    </td>

                                    <td class="px-6 py-5 whitespace-nowrap">
                                        <span
                                            class="inline-flex items-center px-3 py-1.5 rounded-lg text-xs font-bold uppercase tracking-wider bg-indigo-500/10 text-indigo-400 border border-indigo-500/20 backdrop-blur-sm"
                                        >
                                            {player.division}
                                        </span>
                                    </td>

                                    <td class="px-6 py-5 whitespace-nowrap">
                                        <span
                                            class="inline-flex items-center px-3 py-1.5 rounded-lg text-xs font-bold uppercase tracking-wider bg-[#dca34f]/10 text-[#dca34f] border border-[#dca34f]/20 shadow-[0_0_10px_rgba(220,163,79,0.1)] backdrop-blur-sm"
                                        >
                                            {player.role}
                                        </span>
                                    </td>

                                    <td
                                        class="px-8 py-5 whitespace-nowrap text-right"
                                    >
                                        <div
                                            class="flex items-center justify-end gap-2 opacity-50 group-hover/row:opacity-100 transition-opacity duration-300"
                                        >
                                            <Link
                                                href={`/dashboard/players/${player.id}`}
                                                class="p-2 text-gray-400 hover:text-emerald-400 hover:bg-emerald-400/10 rounded-xl transition-all duration-200 hover:scale-110"
                                                title="View Intel"
                                            >
                                                {@html icons.show}
                                            </Link>

                                            <Link
                                                href={`/dashboard/players/${player.id}/edit`}
                                                class="p-2 text-gray-400 hover:text-[#dca34f] hover:bg-[#dca34f]/10 rounded-xl transition-all duration-200 hover:scale-110"
                                                title="Modify Specs"
                                            >
                                                {@html icons.edit}
                                            </Link>

                                            <button
                                                on:click={() =>
                                                    deletePlayer(
                                                        player.id,
                                                        player.nickname,
                                                    )}
                                                class="p-2 text-gray-400 hover:text-rose-400 hover:bg-rose-400/10 rounded-xl transition-all duration-200 hover:scale-110"
                                                title="Terminate Contract"
                                            >
                                                {@html icons.delete}
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            {/each}
                        {/if}
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
