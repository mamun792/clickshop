@extends('admin.master')

@section('main-content')
<div class="page-content">
    

  

@include('admin.orders.card')
@include('admin.orders.filter')
@include('admin.orders.table')









</div>



</div>
@endsection

@push('scripts')
<script>
   $(document).ready(function() {
    // Check if DataTable already exists
    if (!$.fn.DataTable.isDataTable('#cexample')) {
        // Initialize DataTable
        $('#cexample').DataTable({
    pageLength: 10, // Number of rows per page
    searching: true,
    ordering: false,
    pagingType: 'full_numbers' // Pagination controls style
});
    }
});


    document.addEventListener('DOMContentLoaded', function() {
        // Use event delegation for dynamically added buttons
        document.addEventListener('click', function(e) {
            if (e.target.closest('.deleteButton')) {
                e.preventDefault();

                Swal.fire({
                    title: 'Are you sure?',
                    text: 'You won\'t be able to revert this!',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Get the href from the clicked button
                        const deleteUrl = e.target.closest('.deleteButton').getAttribute(
                            'href');

                        // Create and submit a form programmatically
                        const form = document.createElement('form');
                        form.method = 'POST';
                        form.action = deleteUrl;

                        // Add CSRF token if using Laravel
                        const csrfToken = document.querySelector('meta[name="csrf-token"]')
                            ?.getAttribute('content');
                        if (csrfToken) {
                            const csrfInput = document.createElement('input');
                            csrfInput.type = 'hidden';
                            csrfInput.name = '_token';
                            csrfInput.value = csrfToken;
                            form.appendChild(csrfInput);
                        }

                        // Add method spoofing for DELETE request
                        const methodInput = document.createElement('input');
                        methodInput.type = 'hidden';
                        methodInput.name = '_method';
                        methodInput.value = 'GET';
                        form.appendChild(methodInput);

                        document.body.appendChild(form);
                        form.submit();
                    }
                });
            }
        });
    });
</script>
<script>
    $(document).ready(function() {
        $('#toggleCard').on('click', function() {
            $('#filterForm').slideToggle();
        });
    });
</script>

<script src="{{ asset('assets/Admin/order/order.js') }}"></script>

<script>
    // When a card is clicked
    document.querySelectorAll('.card.status-card').forEach(card => {
        card.addEventListener('click', function() {
            // Remove 'active' class from all cards
            document.querySelectorAll('.card').forEach(c => c.classList.remove('active'));

            // Add 'active' class to the clicked card
            this.classList.add('active');

            // Get the status from the card's data-status attribute
            let status = this.getAttribute('data-status');

            // Update the URL query parameter with the selected status
            updateStatusFilter(status);
        });
    });

    // Function to update the status filter in the URL
    function updateStatusFilter(status) {
        const url = `../admin/orders?status=${status}`;
        window.location.href = url; // Redirect to the URL
    }

    // Example function to fetch data via AJAX (you can adapt this based on your needs)
    function fetchFilteredData(status) {
        // Assuming you have an API or route that accepts 'status' as a query parameter
        fetch(`admin/orders/filter?status=${status}`)
            .then(response => response.json())
            .then(data => {

                const url = `/orders ?status=${status}`;
                window.location.href = url; // Redirect to the URL
            })
            .catch(error => console.error('Error fetching filtered data:', error));
    }

    // Optional: Reset Active Card (if the page is directly loaded with a filter status)
    document.addEventListener('DOMContentLoaded', function() {
        let urlParams = new URLSearchParams(window.location.search);
        let status = urlParams.get('status');

        if (status) {
            document.querySelectorAll('.card').forEach(card => {
                if (card.getAttribute('data-status') === status) {
                    card.classList.add('active');
                }
            });
        }
    });
</script>
@endpush