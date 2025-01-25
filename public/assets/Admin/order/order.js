
//Bulk order script
$(document).ready(function () {
    // Select/Deselect all checkboxes
    $('#selectAll').on('change', function () {
        $('.order-checkbox').prop('checked', this.checked);
    });

    // Bulk order processing
    $('#bulkOrderButton').on('click', function () {
        const selectedOrders = $('.order-checkbox:checked').map(function () {
            return $(this).val();
        }).get();

        if (selectedOrders.length === 0) {
            alert('Please select at least one order.');
            return;
        }

        $.ajax({
            url: '/admin/orders/bulk-order',
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') // Dynamically fetch CSRF token
            },

            data: {
                orders: selectedOrders

            },
            success: function (response) {
                //alert(response.message);

                if (response.redirect_url) {
                    window.location.href = response.redirect_url;
                }
            },
            error: function () {
                alert('An error occurred while processing the orders.');
            }
        });
    });
});


//Bulk Invoice


$(document).ready(function () {
    // Handle "Select All" checkbox
    $('#selectAll').on('change', function () {
        $('.order-checkbox').prop('checked', this.checked);
    });

    // Handle "Download Invoice" button click
    $('#downloadInvoice').on('click', function () {
        $('#downloadInvoice').html('Loading...');
        // Get selected order IDs
        let selectedOrders = [];
        $('.order-checkbox:checked').each(function () {
            selectedOrders.push($(this).val());
        });

        if (selectedOrders.length === 0) {
            alert('Please select at least one order.');
            return;
        }

        // Send AJAX request to generate PDF
        $.ajax({
            url: '/admin/orders/generate-pdf',
            method: 'POST',

            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') // Dynamically fetch CSRF token
            },

            data: {
                order_ids: selectedOrders
            },
            xhrFields: {
                responseType: 'blob' // To handle binary PDF response
            },
            success: function (response) {
                // Create a Blob from the PDF stream
                const blob = new Blob([response], { type: 'application/pdf' });
                const link = document.createElement('a');
                link.href = window.URL.createObjectURL(blob);
                const today = new Date();
                const timenow = today.getHours() + "" + today.getMinutes() + "" + today.getSeconds();
                link.download = new today+timenow+'invoices.pdf';
                link.click();
                $('#downloadInvoice').html('Invoice');
            },
            error: function (xhr) {
                alert('Error generating PDF.');
            }
        });
    });
});

//Bulk csv steadfast

$(document).ready(function () {
    // Select/Deselect all checkboxes
    $('#selectAll').on('change', function () {
        $('.order-checkbox').prop('checked', this.checked);
    });

    // Bulk order processing
    $('#bulkCSVSteadfast').on('click', function () {
        const selectedOrders = $('.order-checkbox:checked').map(function () {
            return $(this).val();
        }).get();

        if (selectedOrders.length === 0) {
            alert('Please select at least one order.');
            return;
        }

        $.ajax({
            url: '/admin/orders/bulk-csv-steadfast',
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') // Dynamically fetch CSRF token
            },

            data: {
                orders: selectedOrders

            },
            success: function (response) {
                //alert(response.message);

                if (response.redirect_url) {
                    window.location.href = response.redirect_url;
                }
            },
            error: function () {
                alert('An error occurred while processing the Bulk CSV');
            }
        });
    });
});


//Bulk csv for pathao

$(document).ready(function () {
    // Select/Deselect all checkboxes
    $('#selectAll').on('change', function () {
        $('.order-checkbox').prop('checked', this.checked);
    });

    // Bulk order processing
    $('#bulkCSVPathao').on('click', function () {
        const selectedOrders = $('.order-checkbox:checked').map(function () {
            return $(this).val();
        }).get();

        if (selectedOrders.length === 0) {
            alert('Please select at least one order.');
            return;
        }

        $.ajax({
            url: '/admin/orders/bulk-csv-pathao',
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') // Dynamically fetch CSRF token
            },

            data: {
                orders: selectedOrders

            },
            success: function (response) {
                //alert(response.message);

                if (response.redirect_url) {
                    window.location.href = response.redirect_url;
                }
            },
            error: function () {
                alert('An error occurred while processing the Bulk CSV');
            }
        });
    });
});

//Bulk Status


$(document).ready(function () {
    // Select All Functionality
    $('#selectAll').on('change', function () {
        $('.order-checkbox').prop('checked', $(this).prop('checked'));
    });

    // Bulk Update
    $('.bulk-update').on('click', function (e) {
        e.preventDefault();

        // Get selected order IDs
        let selectedOrders = [];
        $('.order-checkbox:checked').each(function () {
            selectedOrders.push($(this).val());
        });

        if (selectedOrders.length === 0) {
            alert('Please select at least one order.');
            return;
        }

        // Get status
        let status = $(this).data('status');

        // AJAX Request
        $.ajax({
            url: '/admin/orders/bulk-status-update', // Your bulk update route
            method: "POST",

            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') // Dynamically fetch CSRF token
            },

            data: {
                order_ids: selectedOrders,
                status: status
            },
            success: function (response) {
                if (response.success) {
                    alert('Order statuses updated successfully!');
                    location.reload(); // Reload the page to reflect changes
                } else {
                    alert('An error occurred. Please try again.');
                }
            },
            error: function () {
                alert('An error occurred for status. Please try again.');
            }
        });
    });
});

//bulk delete

$(document).ready(function () {

    // Select All Functionality
    $('#selectAll').on('change', function () {
        $('.order-checkbox').prop('checked', $(this).prop('checked'));
    });


    $('#bulkDeleteButton').on('click', function () {
        // Gather selected order IDs
        let selectedOrderIds = [];

        $('.order-checkbox:checked').each(function () {
            selectedOrderIds.push($(this).val());
        });

        if (selectedOrderIds.length === 0) {
            alert('Please select at least one order.');
            return;
        }




        // Confirm deletion
        if (!confirm('Are you sure you want to delete the selected orders?')) {
            return;
        }

        // Make AJAX request
        $.ajax({
            url: '/admin/orders/bulk-delete', // Your route URL
            method: 'POST',

            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') // Dynamically fetch CSRF token
            },


            data: {
                order_ids: selectedOrderIds,

            },
            success: function (response) {
                if (response.success) {
                    alert(response.message);
                    // Optionally refresh the page or update the UI to reflect deletions
                    location.reload();
                }
            },
            error: function (xhr) {
                alert('An error occurred: ' + xhr.responseText);
            }
        });
    });
});


//Bulk Steadfast


$(document).ready(function () {
    $('#bulkSteadfast').on('click', function () {
        // Get all checked checkboxes
        const selectedIds = $('.order-checkbox:checked').map(function () {
            return $(this).val();
        }).get();

        if (selectedIds.length === 0) {
            alert('Please select at least one order.');
            return;
        }

        // Send the selected IDs via an AJAX request
        $.ajax({
            url: "/admin/orders/bulkSteadfast",
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') // Dynamically fetch CSRF token
            },
            contentType: 'application/json',
            data: JSON.stringify({ ids: selectedIds }),
            success: function (response) {
                if (response.success) {
                    alert(response.message || 'Orders sent successfully!');
                    window.location.reload();
                    // Optionally refresh the table or update UI
                } else {
                    alert(response.message || 'Something went wrong!');
                }
            },
            error: function (xhr, status, error) {
                console.error('Error:', error);
                alert('An error occurred for steadfast couriar. Please try again.');
            }
        });
    });
});

//Bulk Redx

$(document).ready(function () {

    $('#bulkRedx').on('click', function () {

        // Get all checked checkboxes
        const selectedIds = $('.order-checkbox:checked').map(function () {
            return $(this).val();
        }).get();

        if (selectedIds.length === 0) {
            alert('Please select at least one order.');
            return;
        }

        // Send the selected IDs via an AJAX request
        $.ajax({
            url: "/admin/orders/bulkredx",
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') // Dynamically fetch CSRF token
            },
            contentType: 'application/json',
            data: JSON.stringify({ ids: selectedIds }),
            success: function (response) {
                if (response.success) {
                    //swit alert
                    Swal.fire({
                        toast: true,
                        icon: 'success',
                        text: 'Redux Order sent successfully',
                        animation: false,
                        position: 'top-right',
                        showConfirmButton: false,
                        timer: 3000,
                        timerProgressBar: true,
                        didOpen: (toast) => {
                            toast.addEventListener('mouseenter', Swal.stopTimer)
                            toast.addEventListener('mouseleave', Swal.resumeTimer)
                        }
                    })


                    // Optionally refresh the table or update UI
                } else {
                    alert(response.message || 'Something went wrong!');
                }
            }
        });
    }
    );
});






//mamun vai code


$(document).ready(function () {

    // Delete button click handler
    $(".remove-item").on('click', function () {

        const data_item_id=$(this).data('item-id');
        const data_item_attr_option=$(this).data('item-attr-option-id');
        const quantity=$(this).data('item-quantity');
        ajexDelete(data_item_id,quantity);

    });
    ajexDelete = (data_item_id,quantity) => {

        $.ajax({
            url: '/admin/orders/delete-item',
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: {
                item_id: data_item_id,
                quanity: quantity
            },
            success: function (response) {
                if (response.success) {

                    window.location.reload();
                } else {
                    alert(response.message);
                }
            },
            error: function (xhr) {
                alert('An error occurred while deleting the item.');
            }
        });
    }





    $(".decrease-btn").on('click', function () {
        const row = $(this).closest('tr');
        const quantityDisplay = row.find(".quantity-display");
        const quantityInput = row.find(".quantity-input");
        let currentQuantity = parseInt(quantityDisplay.text());

        if (currentQuantity > 1) {
            currentQuantity -= 1;
            quantityDisplay.text(currentQuantity);
            quantityInput.val(currentQuantity);
            updateTotalPrice();
        }
    });

    // Increase button click handler
    $(".increase-btn").on('click', function () {
        const row = $(this).closest('tr');
        const quantityDisplay = row.find(".quantity-display");
        const quantityInput = row.find(".quantity-input");
        let currentQuantity = parseInt(quantityDisplay.text());

        currentQuantity += 1;
        quantityDisplay.text(currentQuantity);
        quantityInput.val(currentQuantity);
        updateTotalPrice();
    });

    // Delete button click handler
    $(".remove-item").on('click', function () {
        const data_item_id = $(this).data('item-id');
        const data_item_attr_option = $(this).data('item-attr-option-id');
        const quantity = $(this).data('item-quantity');
        ajexDelete(data_item_id, quantity);
    });

    // Add discount input handler
    $("input[name='discount']").on('input', function() {
        updateTotalPrice();
    });



    // Function to update total price dynamically
    function updateTotalPrice() {
        let subtotal = 0;

        // Calculate subtotal from all items
        $("tbody tr").each(function (index) {
            const quantity = parseInt($(this).find(".quantity-input").val());
            const price = parseFloat($(this).find(".product-price input[type='hidden']").val());

            if (!isNaN(quantity) && !isNaN(price)) {
                subtotal += quantity * price;
            }
        });

        // Get delivery charge
        const deliveryCharge = parseFloat($("#delivery").val()) || 0;

        // Get discount amount
        let discount = parseFloat($("input[name='discount']").val()) || 0;

        // Ensure the discount does not exceed the subtotal
        if (discount > subtotal) {
            discount = subtotal; // Cap the discount to the subtotal amount
            $("input[name='discount']").val(discount.toFixed(2)); // Update the input field with the adjusted discount
        }

        // Calculate final total
        const finalTotal = subtotal + deliveryCharge - discount;

        // Update total price displays
        $("#total-price").text(finalTotal.toFixed(2));
        $("#total-price-val").val(finalTotal.toFixed(2));
        $("#hiden_price").val(subtotal.toFixed(2));

        // Trigger change event for any dependent calculations
        $("#total-price-val").trigger('change');
    }



    // Optional: Add form validation before submit
    $("form").on('submit', function(e) {
        let isValid = true;
        const errors = [];

        // Check if quantities are valid
        $(".quantity-input").each(function() {
            const quantity = parseInt($(this).val());
            if (isNaN(quantity) || quantity < 1) {
                isValid = false;
                errors.push("All quantities must be at least 1");
                return false; // Break the loop
            }
        });

        // Check if attributes are selected where required
        $("select[name^='items'][name*='attributes']").each(function() {
            if ($(this).val() === '') {
                isValid = false;
                errors.push("All attributes must be selected");
                return false; // Break the loop
            }
        });

        if (!isValid) {
            e.preventDefault();
            alert('Please correct the following errors:\n' + errors.join('\n'));
        }
    });

    // Initialize total price on page load
    updateTotalPrice();

    // Optional: Add event listeners for attribute changes
    $("select[name^='items'][name*='attributes']").on('change', function() {
        // You can add custom logic here if attributes affect pricing
        updateTotalPrice();
    });
});


$(document).ready(function() {
    $('#examples').DataTable({
        pageLength: 3,
        lengthMenu: [3, 5, 10, 25, 50, 75, 100, 200, 500],
    });
});


//dynamic dropdown zone based


$(document).ready(function () {
    $('#city').on('change', function () {
        let cityId = $(this).val(); // Get selected city ID
        let zoneDropdown = $('#zone'); // Zone dropdown element

        // Clear existing options
        zoneDropdown.html('<option value="">লোড হচ্ছে...</option>');

        if (cityId) {
            $.ajax({
                url: `/admin/orders/get-zones/${cityId}`, // Laravel route
                type: 'GET',

                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') // Dynamically fetch CSRF token
                },

                dataType: 'json',
                success: function (response) {
                    if (response.success) {
                        // Populate the zone dropdown with the received data
                        zoneDropdown.html('<option selected disabled>এলাকা নির্বাচন করুন</option>');
                        $.each(response.zones, function (index, zone) {
                            zoneDropdown.append(
                                `<option value="${zone.zone_id}">${zone.zone_name}</option>`
                            );
                        });
                    } else {
                        zoneDropdown.html('<option value="">কোনও এলাকা পাওয়া যায়নি</option>');
                    }
                },
                error: function (xhr, status, error) {
                    console.error('Error fetching zones:', error);
                    zoneDropdown.html('<option value="">ত্রুটি ঘটেছে</option>');
                }
            });
        } else {
            zoneDropdown.html('<option value="">এলাকা নির্বাচন করুন</option>');
        }
    });
});


//area based

$('#zone').change(function () {
    const zoneId = $(this).val();
    $('#area').html('<option>Loading...</option>'); // Show loading text

    if (zoneId) {
        $.ajax({
            url: '/admin/orders/get-areas', // Route to fetch areas
            method: 'GET',

            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') // Dynamically fetch CSRF token
            },

            data: { zone_id: zoneId },
            success: function (response) {
                let options = '<option selected disabled>স্থান নির্বাচন করুন</option>';
                response.forEach(area => {
                    options += `<option value="${area.area_id}">${area.area_name}</option>`;
                });
                $('#area').html(options); // Populate areas dropdown
            },
            error: function () {
                alert('Could not load areas. Please try again.');
                $('#area').html('<option>---</option>');
            }
        });
    }
});



//Bulk Select Pathao

$(document).ready(function () {

    // Select all orders
    $('#selectAll').on('change', function () {
        $('.order-checkbox').prop('checked', this.checked);
    });


    // Bulk send to Pathao
    $('#bulkPathao').on('click', function () {



        var selectedOrders = [];

        // Collect all selected order ids
        $('.order-checkbox:checked').each(function () {
            selectedOrders.push($(this).val());
        });

        if (selectedOrders.length > 0) {
            $.ajax({
                url: '/admin/orders/send-to-pathao', // Your route to handle the bulk action
                method: 'POST',

                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') // Dynamically fetch CSRF token
                },

                data: {
                    orders: selectedOrders,
                },

                success: function (response) {


                    Swal.fire({
                        toast: true,
                        icon: 'success',
                        text: 'Order has been created successfully',
                        animation: false,
                        position: 'top-right',
                        showConfirmButton: false,
                        timer: 3000,
                        timerProgressBar: true,
                        didOpen: (toast) => {
                            toast.addEventListener('mouseenter', Swal.stopTimer)
                            toast.addEventListener('mouseleave', Swal.resumeTimer)
                        }
                    })


                   // window.location.reload();
                    // Optionally reload the page or update the table
                },
                error: function (xhr) {
                    // Check if the response is in JSON format and contains a message
                    var response = xhr.responseJSON;
                    if (response && response.status === 'error') {
                        //alert(response.message); // Show the validation error message

                        Swal.fire({
                            toast: true,
                            icon: 'error',
                            text: `${response.message}`,  // Corrected here
                            animation: false,
                            position: 'top-right',
                            showConfirmButton: false,
                            timer: 3000,
                            timerProgressBar: true,
                            didOpen: (toast) => {
                                toast.addEventListener('mouseenter', Swal.stopTimer)
                                toast.addEventListener('mouseleave', Swal.resumeTimer)
                            }
                        })


                    } else {
                        //alert('An error occurred while sending the orders.');

                        Swal.fire({
                            toast: true,
                            icon: 'error',
                            text: 'An error occurred while sending the orders.',
                            animation: false,
                            position: 'top-right',
                            showConfirmButton: false,
                            timer: 3000,
                            timerProgressBar: true,
                            didOpen: (toast) => {
                                toast.addEventListener('mouseenter', Swal.stopTimer)
                                toast.addEventListener('mouseleave', Swal.resumeTimer)
                            }
                        })


                    }
                }
            });
        } else {
            alert('Please select at least one order.');
        }
    });

});
















