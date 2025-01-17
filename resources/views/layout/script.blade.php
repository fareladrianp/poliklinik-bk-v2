<script>
    document.addEventListener('DOMContentLoaded', () => {
            const modalToggles = document.querySelectorAll('[data-modal-toggle]');
            const modals = document.querySelectorAll('[id^="default-modal"]');
    
            modalToggles.forEach(toggle => {
                toggle.addEventListener('click', () => {
                    const modalId = toggle.getAttribute('data-modal-target');
                    const modal = document.getElementById(modalId);
                    if (modal) {
                        modal.classList.toggle('hidden');
                        modal.classList.toggle('flex');
                    }
                });
            });
    
            const closeButtons = document.querySelectorAll('[data-modal-hide]');
            closeButtons.forEach(button => {
                button.addEventListener('click', () => {
                    const modal = button.closest('[id^="edit-modal-"]');
                    if (modal) {
                        modal.classList.add('hidden');
                        modal.classList.remove('flex');
                    }
                });
            });
        });

        document.addEventListener('DOMContentLoaded', function () {
        @if (session('success'))
            Swal.fire({
                title: 'Berhasil!',
                text: "{{ session('success') }}",
                icon: 'success',
                confirmButtonText: 'OK'
            });
        @elseif (session('error'))
            Swal.fire({
                title: 'Gagal!',
                text: "{{ session('error') }}",
                icon: 'error',
                confirmButtonText: 'OK'
            });
        @endif
    });

    document.querySelectorAll('form[action*="delete"]').forEach(form => {
        form.addEventListener('submit', function (e) {
            e.preventDefault(); // Cegah submit langsung
            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: "Data ini akan dihapus!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit(); // Lanjutkan submit jika dikonfirmasi
                }
            });
        });
    });
</script>
@yield('scripts')