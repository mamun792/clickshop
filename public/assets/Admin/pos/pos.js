document.addEventListener('DOMContentLoaded', function () {
    const attributeSelects = document.querySelectorAll('.attribute-select');

    attributeSelects.forEach(select => {
        select.addEventListener('change', function () {
            const productId = this.getAttribute('data-product-id');
            const selectedOptions = document.querySelectorAll(`.attribute-select[data-product-id="${productId}"] option:checked`);

            let totalAttributePrice = 0;
            let totalAttributeDiscount = 0;

            // Calculate total price and total discount for selected attributes
            selectedOptions.forEach(option => {
                const price = parseFloat(option.getAttribute('data-price')) || 0; // Default to 0 if invalid
                const discount = parseFloat(option.getAttribute('data-discount')) || 0; // Default to 0 if invalid or missing

                if (!isNaN(price)) {
                    totalAttributePrice += price;
                }
                if (!isNaN(discount)) {
                    totalAttributeDiscount += discount;
                }
            });

            // Get the base price of the product
            const priceDisplay = document.querySelector(`.price-display[data-product-id="${productId}"]`);
            const basePrice = parseFloat(priceDisplay.getAttribute('data-base-price')) || 0;

            if (isNaN(basePrice)) {
                return; // Skip if base price is not valid
            }

            // Get the campaign discount
            const campaignDiscount = parseFloat(priceDisplay.getAttribute('data-campaign-discount')) || 0;


            // Calculate the final price by adding base price and attributes price, then subtract discounts
            const finalPrice = basePrice + totalAttributePrice - totalAttributeDiscount - campaignDiscount;

            // Update the price display with the final price
            priceDisplay.textContent = finalPrice.toFixed(2);
        });
    });
});






// close shuvo vai code




$(document).ready(function () {
    const cartTableHead = document.querySelector('#cart-table thead');
    const cartTableBody = document.querySelector('#cart-table tbody');
    const discountInput = document.getElementById('discount-input');

    // Initialize Select2 for user search
    $('#user-search').select2({
        placeholder: 'Select User (Phone/Email)',
        allowClear: true,
        ajax: {
            url: '/search-user',
            dataType: 'json',
            delay: 250,
            data: params => ({ query: params.term || '' }),
            processResults: data => ({
                results: data.map(user => ({
                    id: user.id,
                    text: `${user.name} (${user.email} / ${user.phone || 'No phone'})`
                }))
            })
        }
    });

    // Fetch cart data
    async function fetchCart(userId) {
        try {
            const response = await axios.get('/admin/pos/get-cart-items', { params: { user_id: userId } });
            return response.data; // Return cart data
        } catch (error) {
            console.error('Error fetching cart data:', error);
            return [];
        }
    }

    // Render cart table
    const renderCartTable = (cartData, discount = 0) => {
        if (!Array.isArray(cartData) || cartData.length === 0) {
            cartTableHead.innerHTML = '';
            cartTableBody.innerHTML = '<tr><td colspan="5">No items in the cart for the selected user.</td></tr>';
            return;
        }

        // Render table header
        cartTableHead.innerHTML = `
        <tr>
            <th>Items</th>
            <th>Attribute Name</th>
            <th>Price</th>
            <th>Quantity</th>
            <th>Total</th>
            <th>Action</th>
        </tr>
    `;


        // Populate table body
        cartTableBody.innerHTML = '';
        let subtotal = 0;


        cartData.forEach(item => {



            const attributes = (item.attributes || [])
                .filter(attr => attr.attribute_name && attr.attribute_option && attr.attribute_option !== 'N/A') // Filter valid attributes
                .map(attr => `${attr.attribute_name}: ${attr.attribute_option} `)
                .join(', ') || 'N/A';

            console.log('Processed attributes:', attributes);
            console.log('attributes attributes:', item.attributes);




            const price = parseFloat(item.individual_price.replace(/,/g, '')) || 0;

            const itemTotal = price * item.quantity;
            subtotal += itemTotal;

            //shuvo
            const productName = item.product.product_name;
            // Truncate the product name to 11 characters for display
            const truncatedName = productName.length > 11 ? productName.substring(0, 8) + '...' : productName;




            cartTableBody.insertAdjacentHTML('beforeend', `
            <tr data-cart-id="${item.id}">

               <td data-product_id="${item.product.id}" title="${productName}">${truncatedName}</td>

                   <td data-attribute-option-id="${item.attributes.map(attr => attr.product_attr_id).join(', ')}">${attributes}</td>
                <td>${price.toFixed(2)}</td>
                <td >
                    <button  class="btn btn-sm btn-secondary px-3 decrease-quantity" data-cart-id="${item.id}">-</button>
                    <span  class="quantity-display  px-3 btn-sm">${item.quantity}</span>
                    <button  class="btn btn-sm btn-secondary increase-quantity px-3" data-cart-id="${item.id}">+</button>
                </td>
                <td>${itemTotal.toFixed(2)}</td>
                <td>
                    <button class="btn btn-sm btn-danger delete-item" data-cart-id="${item.id}">Delete</button>
                </td>
            </tr>
        `);



        });

        // Render subtotal and total
        const total = Math.max(subtotal - discount, 0);
        cartTableBody.insertAdjacentHTML('beforeend', `
        <tr>
            <td>SubTotal</td>
            <td colspan="4"></td>
            <td>${subtotal.toFixed(2)}</td>
        </tr>

        <tr>
            <td>Discount</td>
            <td colspan="4"></td>
            <td>${discount.toFixed(2)}</td>
        </tr>
        <tr>
            <td>Total</td>
            <td colspan="4"></td>
            <td>${total.toFixed(2)}</td>
        </tr>
    `);
    };


    // Refresh cart and render
    async function refreshCart(userId, discount = 0) {
        const cartData = await fetchCart(userId);
        renderCartTable(cartData, discount);
    }

    // Handle user selection
    $('#user-search').on('change', function () {
        const userId = $(this).val();
        if (userId) {
            refreshCart(userId);
        } else {
            cartTableBody.innerHTML = '<tr><td colspan="5">Please select a user.</td></tr>';
        }
    });

    // Add product to cart
    // Add product to cart
    $('.add-product-btn').on('click', async function (e) {
        e.preventDefault();
        const userId = $('#user-search').val();
        const productId = $(this).data('product-id');
        const campaignId = $(`.product-campaign[data-product-id="${productId}"]`).data('id') || null;
        const campaignDiscount = $(`.product-campaign[data-product-id="${productId}"]`).data('discount') || null;
        const quantity = 1;

        const attributeValues = $(`.attribute-select[data-product-id="${productId}"]`).map(function () {
            return $(this).val();
        }).get();



        if (!userId) {


            // Show a toast notification
            showToast('error', 'Please select a user first.');

            return;
        }


        // Validate attributes (e.g., check if required attributes are selected)

        if (attributeValues.includes('')) {
            showToast('error', 'Please select all required attributes.');
            return;
        }
        //  console playlod
        console.log('Payload:', { userId, productId, quantity, attributeValues, campaignId, campaignDiscount });
        try {


            const response = await axios.post('/admin/pos/add-to-cart', {
                user_id: userId,
                product_id: productId,
                quantity,
                attribute_values: attributeValues,
                campaign_id: campaignId,
                campaign_discount: campaignDiscount
            });

            console.log('Response:', response.data);




            if (response.data.data.original && response.data.data.original.error) {
                showToast('error', response.data.data.original.error);
            } else {
                const audio= new Audio('/public_audio_add-tocart.mp3');
                audio.play();
                showToast('success', 'Product added to cart successfully.');
                refreshCart(userId);
            }


        } catch (error) {
            console.error('Error adding product to cart:', error.response?.data || error);

            Swal.fire({
                toast: true,
                icon: 'error',
                text: error.response?.data?.message || "An error occurred while adding the product to the cart.",
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

    });


    // Apply discount on "Enter" key press
    discountInput.addEventListener('keypress', function (e) {
        if (e.key === 'Enter') {
            const discount = parseFloat(discountInput.value) || 0;
            const userId = $('#user-search').val();

            if (userId) {
                refreshCart(userId, discount);
            }
        }
    });




    // Handle quantity changes using event delegation
    $('#cart-table').on('click', '.increase-quantity, .decrease-quantity', async function () {
        const button = $(this);
        // console.log('Button HTML:', button.prop('outerHTML')); // Debugging
        const cartId = button.data('cart-id');
        // console.log('cartId:', cartId);

        const userId = $('#user-search').val();
        if (!userId) {
            alert('Please select a user first.');
            return;
        }

        const change = button.hasClass('increase-quantity') ? 1 : -1;
        // console.log('Quantity change:', change);

        if (!cartId) {
            alert('Invalid cart ID.');
            return;
        }


        const product_ids = $(this).closest('tr').find('td').eq(0).attr('data-product_id');

        try {
            const response = await axios.post('/admin/pos/update-cart-item', {
                cart_id: cartId,
                quantity: change,
                user_id: userId,
                product_id: product_ids
            });

            if (response.data.success) {
                console.log(response.data.message);
                refreshCart(userId);
            } else {
                showToast('error', 'Not enough stock available.');
            }
        } catch (error) {
            showToast('error', 'An error occurred while updating the quantity.', error);
        }


    });

    // Handle item deletion

    $('#cart-table').on('click', '.delete-item', async function () {
        const cartId = $(this).data('cart-id');
        const userId = $('#user-search').val();
        if (!userId) {
            alert('Please select a user first.');
            return;
        }

        if (!cartId) {
            alert('Invalid cart ID.');
            return;
        }


        try {
            Swal.fire({
                title: 'Are you sure?',
                text: 'Do you want to delete this item from the cart?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!',
                cancelButtonText: 'No, cancel!',
            }).then(async (result) => {
                const response = await axios.post('/admin/pos/remove-cart-item', {
                    cart_id: cartId,
                    user_id: userId
                });

                if (response.data.success) {
                    console.log(response.data.message);
                    refreshCart(userId);
                }


            });
        } catch (error) {
            console.error('Error deleting item from cart:', error);
            alert('An error occurred while deleting the item from the cart.');
        }
    });





    // checkout management





});

async function handleCheckout() {
    // Collect user ID
    const userId = $('#user-search').val();
    if (!userId) {
        alert('Please select a user first.');
        return;
    }

    // Collect phone number and address
    const phoneNumber = document.getElementById('phone-number').value;
    const address = document.getElementById('address').value;

    // Validate phone number and address
    if (!phoneNumber || !address) {
        alert('Please provide both phone number and address.');
        return;
    }

    // Validate phone number length (must be 13 digits)
    if (phoneNumber.length < 11 || phoneNumber.length > 13 || !/^\d+$/.test(phoneNumber)) {
        alert('Phone number must be between 11 and 13 digits.');
        return;
    }




    // Collect cart data
    const cartData = [];
    $('#cart-table tbody tr[data-cart-id]').each(function () {
        const cartId = $(this).data('cart-id');
        const productId = $(this).find('td[data-product_id]').data('product_id');

        // Accessing the attributeOptionId from the correct <td> element
        const attributeOptionId = $(this).find('td[data-attribute-option-id]').data('attribute-option-id');

        // If attributeOptionId is undefined or null, fallback to 'N/A'
        const attributeValue = attributeOptionId || 'N/A';

        const individualPrice = parseFloat($(this).find('td').eq(2).text());
        const quantity = parseInt($(this).find('.quantity-display').text());
        const total = parseFloat($(this).find('td').eq(4).text());



        // Validate row data and add it to cartData
        if (cartId && productId && individualPrice && quantity && total) {

            const itemDiscount = parseFloat($('#discount-input').val()) || 0;


            const phoneNumber = document.getElementById('phone-number').value;
            const address = document.getElementById('address').value;

            cartData.push({
                cart_id: cartId,
                product_id: productId,
                attributeOptionId: attributeValue,

                individual_price: individualPrice,

                quantity,
                total,


            });
        }
    });

    console.log(cartData);


    if (cartData.length === 0) {
        alert('Cart is empty. Please add items before checking out.');
        return;
    }

    // Collect discount and delivery charge
     const discount = parseFloat($('#discount-input').val()) || 0;

    const deliveryCharge = parseFloat($('#shipping-location').val());

    // Validate discount and delivery charge
    if (discount < 0 || deliveryCharge < 0) {
        alert('Invalid discount or delivery charge.');
        return;
    }



    const checkoutData = {
        user_id: userId,
        items: JSON.stringify(cartData),
        discounts: discount,
        delivery_charge: deliveryCharge,
        phone_number: phoneNumber,
        address: address
    };





    // Log data for debugging
    console.log('Checkout data:', checkoutData);

    // Send checkout data to server
    try {


        const response = await axios.post('/admin/orders/checkout', checkoutData);

        console.log(response)
        if (response.data.succcess) {
            console.log(response.data.succcess);
            showToast('success', 'Checkout successful.');
            //clear cart

            clearCart();



        } else {
            alert('Failed to checkout');
        }



    //     // return redire







    } catch (error) {
        console.error('Error during checkout:', error.response?.data || error.message);
        alert('An error occurred during checkout. Please try again.');
    }




}

function clearCart() {

    document.querySelector('#cart-table tbody').innerHTML = ``;

}


async function handleclearCart() {
    const userId = $('#user-search').val();
    if (!userId) {
        alert('Please select a user first.');
        return;
    }

    Swal.fire({
        title: 'Are you sure?',
        text: 'Do you want to clear the cart?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, clear it!',
        cancelButtonText: 'No, cancel!',
    }).then(async (result) => {
        if (result.isConfirmed) {
            try {
                const response = await axios.post('/admin/pos/clear-cart', { user_id: userId });
                clearCart();
                if (response.data.success) {
                    console.log(response.data.message);
                    window.location.reload();
                }
            } catch (error) {
                console.error('Error clearing cart:', error);
                alert('An error occurred while clearing the cart.');
            }
        }
    });



}

// Reusable function to show a toast notification
function showToast(icon, text) {
    Swal.fire({
        toast: true,
        icon: icon,
        text: text,
        animation: false,
        position: 'top-right',
        showConfirmButton: false,
        timer: 3000,
        timerProgressBar: true,
        didOpen: (toast) => {
            toast.addEventListener('mouseenter', Swal.stopTimer);
            toast.addEventListener('mouseleave', Swal.resumeTimer);
        }
    });
}





    $('#register-form').on('submit', function (e) {
        e.preventDefault();

        const formData = $(this).serialize();

        $.ajax({
            url: $(this).attr('action'),
            type: 'POST',
            data: formData,
            success: function (response) {

                if (response.success) {
                    // Close the modal
                    $('#examplePrimaryModal').modal('hide');

                    // Add the new user to the Select2 dropdown
                    const newUser = new Option(
                        `${response.user.name} (${response.user.email})`,
                        response.user.id,
                        true,
                        true
                    );
                    $('#user-search').append(newUser).trigger('change');

                    // Show a success message
                    showToast('success', 'User registered successfully.');

                    // clear the form
                    $('#register-form').trigger('reset');
                }else {
                    console.log(response);
                    alert('An error occurred. Please try again! '+response.message);
                }
            },
            error: function (xhr) {
                console.error(xhr.responseJSON);
                alert('An error occurred. Please try again.');
            },
        });
    });



    function refreshUserList() {
        $('#user-search').empty();
        $.ajax({
            url: '/search-user',
            method: 'GET',
            success: function (data) {
                data.forEach(user => {
                    const newOption = new Option(`${user.name} (${user.email})`, user.id, false, false);
                    $('#user-search').append(newOption);
                });
                $('#user-search').trigger('change');
            }
        });
    }








