<script lang="ts">
    // Menggunakan Svelte 5 Runes
    let { nickname = '', role = '', image = '', status = 'Active' } = $props();

    // Logika warna status
    const statusColor =
        status === 'Active'
            ? 'bg-cyan-500 shadow-[0_0_15px_rgba(6,182,212,0.5)]'
            : 'bg-yellow-500 shadow-[0_0_15px_rgba(234,179,8,0.5)]';
</script>

<div
    class="group relative bg-white/5 border border-white/10 rounded-[2rem] overflow-hidden transition-all duration-500 hover:border-cyan-400/50 hover:shadow-[0_0_40px_rgba(6,182,212,0.15)]"
>
    <div
        class="absolute -inset-px bg-gradient-to-br from-cyan-500/20 to-purple-500/20 opacity-0 group-hover:opacity-100 transition-opacity duration-500 z-0"
    ></div>

    <div class="relative z-10">
        <div class="relative overflow-hidden aspect-[4/5]">
            <img
                src={image}
                alt={nickname}
                class="w-full h-full object-cover grayscale group-hover:grayscale-0 group-hover:scale-110 transition-all duration-1000 ease-out"
            />

            <div
                class="absolute inset-0 bg-gradient-to-t from-[#0a0a0a] via-transparent to-transparent opacity-90"
            ></div>

            <div class="absolute top-6 right-6">
                <span
                    class="{statusColor} text-black text-[10px] px-4 py-1.5 rounded-full uppercase tracking-[0.2em] font-black italic transition-transform duration-500 group-hover:scale-110"
                >
                    {status}
                </span>
            </div>
        </div>

        <div class="p-8 relative">
            <div
                class="absolute top-0 left-8 w-12 h-[2px] bg-cyan-500 transition-all duration-500 group-hover:w-24"
            ></div>

            <p
                class="text-cyan-400 uppercase text-[11px] tracking-[0.4em] font-medium mb-1"
            >
                {role}
            </p>

            <h2
                class="text-4xl font-black text-white tracking-tighter italic uppercase group-hover:text-cyan-400 transition-colors duration-300"
            >
                {nickname}
            </h2>

            <div
                class="mt-4 h-1 w-full bg-white/5 rounded-full overflow-hidden"
            >
                <div
                    class="h-full bg-cyan-500 w-0 group-hover:w-full transition-all duration-700 delay-100"
                ></div>
            </div>
        </div>
    </div>
</div>

<style>
    /* Tambahan font jika diperlukan, tapi Tailwind font-black biasanya sudah cukup gahar */
</style>
