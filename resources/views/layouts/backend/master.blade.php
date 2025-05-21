<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <meta http-equiv="Cache-Control" content="no-store, no-cache, must-revalidate, max-age=0">
    <meta http-equiv="Pragma" content="no-cache">
    <meta http-equiv="Expires" content="0">
    <title>@yield('title') - {{ config('app.name', 'Laravel') }}</title>
    <link rel="preconnect" href="https://fonts.gstatic.com/" crossorigin>
    <meta name="msapplication-TileColor" content="#206bc4" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="theme-color" content="#206bc4" />
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent" />
    <meta name="apple-mobile-web-app-capable" content="yes" />
    <meta name="mobile-web-app-capable" content="yes" />
    <meta name="HandheldFriendly" content="True" />
    <meta name="MobileOptimized" content="320" />
    <meta name="robots" content="noindex,nofollow,noarchive" />
    <link rel="icon" href="{{ asset('favicon.ico') }}" type="image/x-icon" />
    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}" type="image/x-icon" />

    <!-- Font awesome -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css"
        integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">

    <!-- Tabler Core -->
    <link href="{{ asset('dist/css/tabler.min.css') }}" rel="stylesheet" />

    <!-- Tabler Plugins -->
    <link href="{{ asset('dist/css/demo.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('dist/libs/selectize/dist/css/selectize.css') }}" rel="stylesheet" />


    @stack('css')
</head>

<body class="antialiased">
    <!-- Sidebar -->
    @include('layouts.backend._sidebar')
    <div class="page">
        <!-- Navbar -->
        @include('layouts.backend._navbar')
        <div class="content bg-light">
            <!-- Content -->
            @yield('content')

            <!-- Footer -->
            @include('layouts.backend._footer')

            <!-- alert -->
            @include('sweetalert::alert')
        </div>
    </div>

    <!-- Libs JS -->
    <script src="{{ asset('dist/libs/bootstrap/dist/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('dist/libs/jquery/dist/jquery.slim.min.js') }}"></script>
    <script src="{{ asset('dist/libs/selectize/dist/js/standalone/selectize.min.js') }}"></script>


    <!-- Tabler Core -->
    <script src="{{ asset('backend/dist/js/tabler.min.js') }}"></script>

    <!-- SweetAlert -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script type="text/javascript">
        function deleteData(id) {
            const swalWithBootstrapButtons = Swal.mixin({
                customClass: {
                    confirmButton: 'btn btn-success',
                    cancelButton: 'btn btn-danger'
                },
                buttonsStyling: true
            })

            swalWithBootstrapButtons.fire({
                title: 'Are you sure want to delete this?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, delete it!',
                cancelButtonText: 'No, cancel!',
                reverseButtons: true
            }).then((result) => {
                if (result.value) {
                    event.preventDefault();
                    document.getElementById('delete-form-' + id).submit();

                } else if (
                    /* Read more about handling dismissals below */
                    result.dismiss === Swal.DismissReason.cancel
                ) {
                    swalWithBootstrapButtons.fire(
                        'Your data still save !',
                        '',
                        'error'
                    )
                }
            })
        }
    </script>

    <!-- Advance tag select -->
    <script>
        $(document).ready(function() {
            $('#select-tags-advanced').selectize({
                maxItems: 15,
                plugins: ['remove_button'],
            });
        });

        $(document).ready(function() {
    let seriesContainer = $('#series-container'); // Container untuk input hidden
    let totalPriceElement = $('#total-price');

    // Event handler untuk checkbox "All"
    $('#selectAll').change(function() {
        let isChecked = $(this).prop('checked');
        $('.item-checkbox').prop('checked', isChecked).trigger('change');
    });

    // Event handler untuk checkbox individual
    $('.item-checkbox').change(function() {
        let total = 0;
        let checkedValues = [];

        $('.item-checkbox:checked').each(function() {
            let row = $(this).closest('tr');

            // Ambil harga dari elemen dengan class "price"
            let priceText = row.find('.price').text().trim();
            let price = parseInt(priceText.replace(/[^0-9]/g, '')) || 0;
            total += price;

            // Ambil series_id dari input hidden dalam baris ini
            let seriesId = row.find('input[name="series_id[]"]').val();
            checkedValues.push(seriesId);

            // Jika belum ada input hidden untuk series_id ini, tambahkan
            if (!seriesContainer.find(`input[value="${seriesId}"]`).length) {
                seriesContainer.append(`<input type="hidden" name="series_id[]" value="${seriesId}">`);
            }
        });

        // Simpan data checkbox & total price ke sessionStorage
        sessionStorage.setItem('checkedItems', JSON.stringify(checkedValues));
        sessionStorage.setItem('totalPrice', total);

        // Update total harga di tampilan
        totalPriceElement.text('Rp ' + total.toLocaleString('id-ID'));

        // Hapus input hidden jika checkbox di-unchecked
        $('.item-checkbox:not(:checked)').each(function() {
            let row = $(this).closest('tr');
            let seriesId = row.find('input[name="series_id[]"]').val();
            seriesContainer.find(`input[value="${seriesId}"]`).remove();
        });

        // Update status checkbox "All"
        if ($('.item-checkbox').length === $('.item-checkbox:checked').length) {
            $('#selectAll').prop('checked', true);
        } else {
            $('#selectAll').prop('checked', false);
        }
    });

    function restoreCheckboxState() {
        let checkedItems = JSON.parse(sessionStorage.getItem('checkedItems')) || [];
        let savedTotal = sessionStorage.getItem('totalPrice') || 0;

        let total = 0;

        $('.item-checkbox').each(function() {
            let row = $(this).closest('tr');
            let seriesId = row.find('input[name="series_id[]"]').val();

            // Jika series_id ada di session, centang kembali checkbox-nya
            if (checkedItems.includes(seriesId)) {
                $(this).prop('checked', true);

                // Ambil harga kembali dari tabel
                let priceText = row.find('.price').text().trim();
                let price = parseInt(priceText.replace(/[^0-9]/g, '')) || 0;
                total += price;

                // Tambahkan input hidden kembali jika belum ada
                if (!seriesContainer.find(`input[value="${seriesId}"]`).length) {
                    seriesContainer.append(`<input type="hidden" name="series_id[]" value="${seriesId}">`);
                }
            }
        });

        // Update total harga sesuai data yang dipulihkan
        totalPriceElement.text('Rp ' + total.toLocaleString('id-ID'));

        // Jika semua checkbox item tercentang, centang juga checkbox "All"
        if ($('.item-checkbox').length === $('.item-checkbox:checked').length) {
            $('#selectAll').prop('checked', true);
        }
    }

    // Panggil restoreCheckboxState saat halaman dimuat
    restoreCheckboxState();
});

  
    </script>
    @stack('js')

</body>

</html>
