<!doctype html>
<html lang="en" class="light-theme">




<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!--favicon-->
    {{-- <link rel="icon" href="{{ asset('assets/images/favicon-32x32.png') }}" type="image/png" /> --}}
    <link rel="icon" href="{{ asset( getMedia('favicon')) }}" type="image/png" />


    <!--plugins-->
    <link href="{{ asset('assets/plugins/simplebar/css/simplebar.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/plugins/perfect-scrollbar/css/perfect-scrollbar.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/plugins/metismenu/css/metisMenu.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/plugins/datatable/css/dataTables.bootstrap5.min.css') }}" rel="stylesheet" />
    <link rel="stylesheet" href="{{asset('assets/plugins/notifications/css/lobibox.min.css')}}" />

    <!-- loader
    <link href="{{ asset('assets/css/pace.min.css') }}" rel="stylesheet" />
    <script src="{{ asset('assets/js/pace.min.js') }}"></script> -->

    <!-- Bootstrap CSS -->
    <link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/bootstrap-extended.css') }}" rel="stylesheet">

    <!-- Select2 CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" />
    <link rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" />

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&amp;display=swap" rel="stylesheet">

    <!-- App Styles -->
    <link href="{{ asset('assets/css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/icons.css') }}" rel="stylesheet">

    <!-- Theme Style CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/dark-theme.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/semi-dark.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/header-colors.css') }}" />
 <!-- Custom Style CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/custom.css') }}" />

    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.css" rel="stylesheet">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <!-- Froala Editor Stylesheet -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/froala-editor@latest/css/froala_editor.pkgd.min.css" />

    <!-- Tagify CSS -->
    <link href="https://cdn.jsdelivr.net/npm/@yaireo/tagify/dist/tagify.css" rel="stylesheet">

    <!-- Include Toastr CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css" rel="stylesheet" />

    <!-- SweetAlert2 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">





    <title>
        {{ siteInfo('app_name') }}
    </title>
<style>
  .sidebar-header img.logo-icon {
    width: 100px;
}


.wrapper.toggled .sidebar-header img.logo-icon {
    width: 50px;
}


  /* Base styles */
:root {
  --sidebar-width: 260px;
  --sidebar-width-collapsed: 206px;
}

td.last2 {
  grid-row-gap: 10px;
  grid-column-gap: 10px;
}

@media (max-width: 1440px) {
  .sidebar-wrapper {
    width: 200px;
  }
  .sidebar-header {
    width: 200px;
  }
  td.last2 {
    display: grid;
  }
}

/* Medium devices (tablets) */
@media (max-width: 991px) {
  .wrapper {
    padding-left: 0;
  }

  .sidebar-wrapper {
    width: var(--sidebar-width);
    transform: translateX(-100%);
    transition: transform 0.3s ease-out;
  }

  .sidebar-wrapper.show {
    transform: translateX(0);
  }

  .page-wrapper {
    margin-left: 0 !important;
    width: 100%;
  }

  .my-table,
  .my-table2 {
    font-size: 14px;
  }

  .table-responsive {
    overflow-x: auto;
    -webkit-overflow-scrolling: touch;
  }
}

/* Extra small devices */
@media (max-width: 575px) {
  .header-wrapper {
    padding: 0.5rem;
  }

  .page-wrapper {
    padding: 0.5rem;
  }

  .card {
    margin-bottom: 0.5rem;
  }
}

/* Print styles */
@media print {
  .sidebar-wrapper,
  .header-wrapper,
  .back-to-top,
  .overlay {
    display: none !important;
  }

  .page-wrapper {
    margin: 0;
    padding: 0;
  }

  .card {
    break-inside: avoid;
  }
}

@media screen and (max-width: 1024px) {
  .wrapper.toggled:not(.sidebar-hovered) .sidebar-wrapper {
    width: 70px !important;
  }
  .wrapper.toggled:not(.sidebar-hovered) .sidebar-wrapper .menu-title {
    display: none;
}
  .wrapper.toggled .page-wrapper {
    margin-left: 70px !important;
  }
}

.singleattibute-container {
  display: none;
}

.combineattibute-container {
  display: none;
}

/* Small devices (phones) */
@media (max-width: 1440px) {
  .page-wrapper {
    margin-left: 200px;
  }
  .sidebar-wrapper .metismenu a .menu-title {
    font-size: 12px;
    margin-left: 8px;
  }

  .status-card {
    margin-bottom: 1rem;
  }

  .status-card h4 {
    font-size: 16px;
  }

  .pastel-button {
    padding: 8px;
    font-size: 12px;
    width: 100%;
    margin: 0.25rem 0;
  }

  .my-table,
  .my-table2 {
    font-size: 12px;
  }

  .my-table thead tr th,
  .my-table2 thead tr th,
  .my-table tbody tr td,
  .my-table2 tbody tr td {
    padding: 6px 4px;
  }
}
</style>

<style>
   .tableSearchber {
    width: 280px !important;
}
    </style>

</head>

<body>
    <!--wrapper-->
    <div class="wrapper">
        <!--sidebar wrapper -->
        @include('admin.section.sidebar')

        <!--start header -->
        @include('admin.section.header')

        <!--start page wrapper -->
        <div class="page-wrapper">
            @yield('main-content')

        </div>
        <!--end page wrapper -->
        <!--start overlay-->
        <div class="overlay toggle-icon"></div>
        <!--end overlay-->
        <!--Start Back To Top Button--> <a href="javaScript:;" class="back-to-top"><i
                class='bx bxs-up-arrow-alt'></i></a>
        <!--End Back To Top Button-->
        @include('admin.section.footer')

    </div>


    <!-- search modal -->
    {{--

    @include('admin.section.search-modal')

    --}}



    <!--start switcher-->
    @include('admin.section.switcher')



    <!-- Bootstrap JS -->
    <script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>

    <!--plugins-->
    <script src="{{ asset('assets/js/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/simplebar/js/simplebar.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/metismenu/js/metisMenu.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/perfect-scrollbar/js/perfect-scrollbar.js') }}"></script>


    <script src="{{ asset('assets/plugins/apexcharts-bundle/js/apexcharts.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/apexcharts-bundle/js/apex-custom.js') }}"></script>



    <script src="{{ asset('assets/plugins/peity/jquery.peity.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/chartjs/js/chart.js') }}"></script>

    <script src="{{ asset('assets/plugins/datatable/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatable/js/dataTables.bootstrap5.min.js') }}"></script>

    <!--notification js -->
    <script src="{{asset('assets/plugins/notifications/js/lobibox.min.js')}}"></script>
    <script src="{{asset('assets/plugins/notifications/js/notifications.min.js')}}"></script>
    <script src="{{asset('assets/plugins/notifications/js/notification-custom-script.js')}}"></script>

    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.js"></script>







    <script>
        $(document).ready(function() {
            $('#example').DataTable({
            ordering: false,
            "lengthMenu": [
                [10, 25, 50, -1],
                [10, 25, 50, "All"]
            ]
        });
        });

    </script>
    <script>
        $(document).ready(function() {
            var table = $('#example2').DataTable({
                lengthChange: false
                , buttons: ['copy', 'excel', 'pdf', 'print']
            });

            table.buttons().container()
                .appendTo('#example2_wrapper .col-md-6:eq(0)');
        });

    </script>


    <script>
        $(document).ready(function() {
            $('.summernote').summernote({
                height: 300, // Set the height of the editor
                minHeight: 200, // Set minimum height
                maxHeight: 500, // Set maximum height
                focus: true // Set focus to editable area after initializing
            });
        });

    </script>




    <!-- Select2 JavaScript from CDN -->
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="{{ asset('assets/plugins/select2/js/select2-custom.js') }}"></script>



    <!-- Froala Editor Script -->
    <!-- Froala Editor JavaScript -->
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/froala-editor@latest/js/froala_editor.pkgd.min.js">
    </script>


    <script>
        // init Froala Editor
        new FroalaEditor('#editor');

    </script>





    <!--app JS-->
    <script src="{{ asset('assets/js/app.js') }}"></script>
    <script src="{{ asset('assets/js/index2.js') }}"></script>



    <!-- <script>
        new PerfectScrollbar('.product-list');
        new PerfectScrollbar('.customers-list');

    </script> -->



    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

    <!-- Tagify JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/@yaireo/tagify/dist/tagify.min.js"></script>

    <!-- Include Toastr JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
    <!-- jQuery and Summernote JS -->

    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.js"></script>

    <!-- SweetAlert2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>








    @if (session('success'))
    <script>
        Swal.fire({
    toast: true,
    icon: 'success',
    text: '{{ session('success') }}',
    animation: false,
    position: 'top-right',
    showConfirmButton: false,
    timer: 1000,
    timerProgressBar: true,
    didOpen: (toast) => {
      toast.addEventListener('mouseenter', Swal.stopTimer)
      toast.addEventListener('mouseleave', Swal.resumeTimer)
    }
  })


    </script>
    @endif

    @if (session('error'))
    <script>
        Swal.fire({
    toast: true,
    icon: 'error',
    text: '{{ session('error') }}',
    animation: false,
    position: 'top-right',
    showConfirmButton: false,
    timer: 1000,
    timerProgressBar: true,
    didOpen: (toast) => {
      toast.addEventListener('mouseenter', Swal.stopTimer)
      toast.addEventListener('mouseleave', Swal.resumeTimer)
    }
  })
    </script>
    @endif







    <script src="{{asset('assets/Admin/deletecommon/delete.js')}}"></script>


    @stack('scripts');
    <script>
        //check dark mode or light in the local storage and add into the html
        if (localStorage.getItem('theme') == 'dark') {
            document.documentElement.setAttribute('data-theme', 'dark');
        } else {
            document.documentElement.setAttribute('data-theme', 'light');
        }


    </script>

</body>


</html>
