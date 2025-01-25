
    document.addEventListener('DOMContentLoaded', function () {
       
        document.querySelectorAll('.deleteButton').forEach(button => {
            button.addEventListener('click', function (e) {
                e.preventDefault();

             
                const deleteUrl = this.dataset.url;

               
                Swal.fire({
                    title: 'Are you sure?',
                    text: 'You won\'t be able to revert this!',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Yes, delete it!',
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Update the action attribute of the generic delete form
                        const deleteForm = document.getElementById('deleteForm');
                        deleteForm.action = deleteUrl;

                        // Submit the form
                        deleteForm.submit();
                    }
                });
            });
        });
    });
