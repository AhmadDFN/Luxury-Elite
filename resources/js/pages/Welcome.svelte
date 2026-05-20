<script lang="ts">
    import { Link, page } from '@inertiajs/svelte';
    import AppHead from '@/components/AppHead.svelte';
    import { fade, fly } from 'svelte/transition';
    import { onMount } from 'svelte';
    import Navbar from '@/components/layout/Navbar.svelte';
    import PlayerCard from '@/components/roster/PlayerCard.svelte';

    let { canRegister = true } = $props();
    const auth = $derived(page.props.auth);

    let visible = $state(false);
    onMount(() => {
        visible = true;
    });

    // 1. Data Roster Dinamis (Bisa kamu passing dari Props/API)
    // Coba hapus/tambah player di bawah ini untuk melihat keajaiban grid-nya!
    const players = [
        {
            nickname: 'iRzell`LX',
            role: 'Assault',
            image: '/images/irzell.png',
            status: 'Active',
        },
        {
            nickname: 'SHADOW',
            role: 'Recon',
            image: '/images/irzell.png',
            status: 'Active',
        },
        {
            nickname: 'REAPER',
            role: 'Medic',
            image: '/images/irzell.png',
            status: 'Trial',
        },
        {
            nickname: 'GHOST',
            role: 'Vehicle',
            image: '/images/irzell.png',
            status: 'Active',
        },
        {
            nickname: 'VIPER',
            role: 'Support',
            image: '/images/irzell.png',
            status: 'Active',
        },
        {
            nickname: 'BLAZE',
            role: 'Assault',
            image: '/images/irzell.png',
            status: 'Trial',
        },
        {
            nickname: 'STORM',
            role: 'Recon',
            image: '/images/irzell.png',
            status: 'Active',
        },
    ];

    // 2. Fungsi Logika Kalkulasi Grid
    function getGridSpanClass(index: number, total: number) {
        // Default: Mobile full (1 col), Tablet setengah (3/6), Desktop sepertiga (2/6)
        let spanClasses = 'col-span-1 md:col-span-3 lg:col-span-2';

        // Logika Tablet (MD): Jika sisa 1 (ganjil), item terakhir ambil full space (6/6)
        if (total % 2 !== 0 && index === total - 1) {
            spanClasses = spanClasses.replace('md:col-span-3', 'md:col-span-6');
        }

        // Logika Desktop (LG):
        const rem = total % 3;
        if (rem === 1 && index === total - 1) {
            // Sisa 1: Item terakhir ambil full (6/6 kolom)
            spanClasses = spanClasses.replace('lg:col-span-2', 'lg:col-span-6');
        } else if (rem === 2 && index >= total - 2) {
            // Sisa 2: Dua item terakhir ambil setengah-setengah (3/6 kolom)
            spanClasses = spanClasses.replace('lg:col-span-2', 'lg:col-span-3');
        }

        return spanClasses;
    }
</script>

<AppHead title="Luxury Elite - Official Website">
    <link rel="preconnect" href="https://rsms.me/" />
    <link rel="stylesheet" href="https://rsms.me/inter/inter.css" />
</AppHead>

<div class="min-h-screen bg-[#020612] text-white font-sans overflow-x-hidden">
    {#if visible}
        <Navbar />
    {/if}

    <section
        class="relative min-h-screen flex items-center pt-20 px-6 md:px-12"
    >
        <div class="absolute inset-0 z-0 overflow-hidden pointer-events-none">
            <div
                class="absolute top-0 left-[-5%] w-[55%] h-full bg-gradient-to-br from-blue-950/40 to-transparent transform skew-x-[-12deg] border-r border-blue-500/10"
            ></div>
            <div
                class="absolute top-[-10%] right-[-5%] w-[600px] h-[600px] bg-cyan-600/10 rounded-full blur-[120px] animate-pulse"
            ></div>
        </div>

        <div
            class="container mx-auto flex flex-col md:flex-row items-center relative z-10 w-full"
        >
            <div
                class="w-full md:w-1/2 flex justify-center items-center relative h-[50vh] md:h-[80vh]"
            >
                {#if visible}
                    <img
                        in:fade={{ duration: 2000, delay: 500 }}
                        src="/images/logo-lx.png"
                        alt="LX Logo Background"
                        class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 w-[90%] opacity-10 blur-[8px] z-0"
                    />
                    <div
                        in:fly={{ y: 50, duration: 1500, delay: 200 }}
                        class="float-anim z-10"
                    >
                        <img
                            src="/images/logo-lx.png"
                            alt="LX Main Visual"
                            class="max-h-[500px] md:max-h-[600px] object-contain drop-shadow-[0_0_50px_rgba(6,182,212,0.3)]"
                        />
                    </div>
                {/if}
            </div>

            <div
                class="w-full md:w-1/2 flex flex-col items-start space-y-6 mt-10 md:mt-0"
            >
                {#if visible}
                    <div in:fly={{ x: 30, duration: 1000, delay: 400 }}>
                        <h2
                            class="text-cyan-400 font-mono tracking-[0.5em] text-sm md:text-base mb-2 uppercase"
                        >
                            // Tactical Delta Force
                        </h2>
                        <h1
                            class="text-4xl sm:text-5xl md:text-5xl lg:text-6xl xl:text-8xl font-black leading-none tracking-tighter break-words"
                        >
                            WELCOME TO <br />
                            <span class="gold-shimmer italic">LUXURY ELITE</span
                            >
                        </h1>
                    </div>

                    <p
                        in:fly={{ x: 30, duration: 1000, delay: 600 }}
                        class="text-base md:text-lg xl:text-xl text-gray-400 font-light max-w-xl leading-relaxed border-l-2 border-cyan-500 pl-4 sm:pl-6"
                    >
                        Uniting <span class="text-white font-medium"
                            >Ultimate Skill</span
                        >, Precision Strategy, and
                        <span class="text-white font-medium">Pure Elegance</span
                        >. Dominate the battlefield with the elite.
                    </p>

                    <div
                        in:fly={{ y: 20, duration: 1000, delay: 800 }}
                        class="flex flex-wrap gap-6 pt-4"
                    >
                        <button
                            class="group relative px-10 py-4 overflow-hidden rounded-sm bg-cyan-600 font-bold uppercase tracking-[0.2em] text-sm text-black transition-all"
                        >
                            <span class="relative z-10">Meet The Team</span>
                            <div
                                class="absolute inset-0 bg-white translate-y-[100%] group-hover:translate-y-0 transition-transform duration-300"
                            ></div>
                        </button>

                        {#if canRegister}
                            <Link
                                href="/register"
                                class="px-10 py-4 border border-yellow-500/50 text-yellow-500 font-bold uppercase tracking-[0.2em] text-sm rounded-sm hover:bg-yellow-500/10 transition-all duration-300 flex items-center gap-2"
                            >
                                Join Squad
                                <span class="text-xs">→</span>
                            </Link>
                        {/if}
                    </div>
                {/if}
            </div>
        </div>
    </section>

    <!-- ROSTER -->
    <section class="max-w-7xl mx-auto px-6 py-32 relative">
        <div
            class="absolute top-0 right-0 w-[500px] h-[500px] bg-cyan-500/5 rounded-full blur-[120px] -z-10 pointer-events-none"
        ></div>

        <div class="mb-20 text-center md:text-left">
            <p
                class="text-cyan-400 uppercase tracking-[0.6em] text-sm font-bold animate-pulse"
            >
                Luxury Elite Members
            </p>
            <h2
                class="text-7xl font-black mt-4 tracking-tighter uppercase italic"
            >
                LX <span
                    class="text-transparent"
                    style="-webkit-text-stroke: 1px white; opacity: 0.5;"
                    >ROSTER</span
                >
            </h2>
        </div>

        <!-- 
          Base grid diubah menjadi 6 kolom untuk menampung fraksi matematika yang fleksibel. 
          grid-cols-1 (Mobile), md:grid-cols-6 (Tablet/Desktop)
        -->
        <div class="grid grid-cols-1 md:grid-cols-6 gap-x-8 gap-y-12 mb-20">
            {#each players as player, i}
                <div
                    class="opacity-0 animate-[fadeInUp_0.5s_ease_forwards] flex justify-center w-full {getGridSpanClass(
                        i,
                        players.length,
                    )}"
                    style="animation-delay: {0.1 + i * 0.15}s;"
                >
                    <!-- Wrapper max-w-md untuk menjaga aspect ratio gambar agar tidak menjadi raksasa saat span 1 halaman penuh -->
                    <div class="w-full max-w-md transition-all duration-500">
                        <PlayerCard
                            nickname={player.nickname}
                            role={player.role}
                            image={player.image}
                            status={player.status}
                        />
                    </div>
                </div>
            {/each}
        </div>
    </section>
    <style>
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
</div>

<style>
    /* Efek kilauan emas pada teks */
    .gold-shimmer {
        background: linear-gradient(
            to right,
            #fde047 20%,
            #ca8a04 40%,
            #fde047 60%,
            #ca8a04 80%
        );
        background-size: 200% auto;
        color: transparent;
        -webkit-background-clip: text;
        background-clip: text;
        animation: shine 5s linear infinite;
    }

    @keyframes shine {
        to {
            background-position: 200% center;
        }
    }

    /* Efek mengapung halus untuk hero image */
    .float-anim {
        animation: floating 6s ease-in-out infinite;
    }

    @keyframes floating {
        0%,
        100% {
            transform: translateY(0px);
        }
        50% {
            transform: translateY(-20px);
        }
    }
</style>
