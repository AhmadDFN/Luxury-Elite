<script>
    import { router, page } from '@inertiajs/svelte';
    import { toast } from 'svelte-sonner';
    import { onMount, onDestroy } from 'svelte';

    let removeListener;

    // Fungsi tunggal untuk menampilkan toast
    const showToast = (flash) => {
        if (!flash) return;

        if (flash.message) {
            toast.success(flash.message, {
                description: 'Luxury Elite System',
            });
        }

        if (flash.error) {
            toast.error(flash.error, {
                description: 'System Error',
            });
        }
    };

    onMount(() => {
        // 1. Cek notifikasi saat halaman pertama kali dimuat (misal: baru masuk dashboard)
        showToast(page.props?.flash);

        // 2. Dengarkan event Inertia setiap kali ada request (misal: Save Edit, Delete) sukses
        removeListener = router.on('success', (event) => {
            // Ambil data flash terbaru dari response Laravel
            const newFlash = event.detail.page.props.flash;
            showToast(newFlash);
        });
    });

    onDestroy(() => {
        // Bersihkan listener saat komponen dihancurkan agar memori tidak bocor
        if (removeListener) removeListener();
    });
</script>

<slot />
