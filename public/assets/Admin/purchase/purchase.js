$(document).ready(function () {
    $('#productSelect').select2();

    //here i need to disable other option ofchange type more than one the option issingleVariant and ismultipleVariants
    const isSingleVariant = $('#singleVariant');
    const ismultipleVariants = $('#multipleVariants');


    ismultipleVariants.on('change', function () {
        if (ismultipleVariants.is(':checked')) {
            // disable ismultipleVariants bttuon
            $('#singleVariant').prop('disabled', true);

        }
    });
    isSingleVariant.on('change', function () {
        if (isSingleVariant.is(':checked')) {
            // disable ismultipleVariants bttuon
            $('#multipleVariants').prop('disabled', true);

        }
    });



    // reset the radio buttons when the form is submitted
    $('#productSelect').on('change', function () {
        isSingleVariant.prop('disabled', false);
        ismultipleVariants.prop('disabled', false);
    });


    function combineAttributes(attributes) {
        const grouped = attributes.reduce((acc, attr) => {
            acc[attr.name] = acc[attr.name] || [];
            acc[attr.name].push(attr.value);
            return acc;
        }, {});

        const keys = Object.keys(grouped);
        if (keys.length === 0) return [{}];

        return keys.reduce((acc, key) => {
            return acc.flatMap(obj => grouped[key].map(value => ({
                ...obj,
                [key]: value
            })));
        }, [{}]);
    }

    $('#addProductButton').on('click', function () {
        const productElement = $('#productSelect').find(':selected');
        const productCode = productElement.data('code');
        const productName = productElement.text();
        const productPrice = parseFloat(productElement.data('price'));

        const selectedAttributes = $('.attribute-checkbox:checked').map((_, el) => ({
            name: $(el).data('name'),
            value: el.value,
            attributeId: $(el).data('attribute-id'),
            optionId: $(el).data('option-id'),
        })).get();

        const isMultiple = $('#multipleVariants').is(':checked');
        const variants = isMultiple
            ? combineAttributes(selectedAttributes)
            : selectedAttributes.map(attr => ({ [attr.name]: attr.value }));

        const tbody = $('#variantTableBody');
        let total = parseFloat($('#totalAmount').text().replace('৳', ''));

        variants.forEach(variant => {
            const variantDescription = Object.entries(variant)
                .map(([key, value]) => `${key}: ${value}`)
                .join(' - ');

            // Handle attribute and option IDs based on variant type
            let attributeIds, optionIds;
            if (isMultiple) {
                // For multiple variants, include all selected attribute and option IDs
                attributeIds = selectedAttributes.map(attr => attr.attributeId).join(',');
                optionIds = selectedAttributes.map(attr => attr.optionId).join(',');
            } else {
                console.log(variant);
                console.log(selectedAttributes);

                // For single variants, only include the specific attribute and option ID

                const variantKey = Object.keys(variant)[0]; // This will give "color"
                const variantValue = variant[variantKey]; // This will give "red"


                const matchingAttribute = selectedAttributes.find(attr => attr.value === variantValue);

                attributeIds = matchingAttribute ? matchingAttribute.attributeId : '';
                optionIds = matchingAttribute ? matchingAttribute.optionId : '';
            }

            // Check if a row with the same variantDescription already exists
            const isDuplicate = tbody.find('tr').filter((_, row) => {
                return $(row).find('input[name="variant[]"]').val() === variantDescription;
            }).length > 0;

            if (!isDuplicate) {
                total += productPrice;
                tbody.append(`
                    <tr>
                        <td><input type="checkbox" class="select-row"></td>
                        <td>${tbody.children().length + 1}</td>
                        <td>${productCode}
                            <input type="hidden" name="product_id[]" value="${productElement.val()}">
                        </td>
                        <td>${productName}</td>
                        <td>${variantDescription}
                            <input type="hidden" name="variant[]" value="${variantDescription}">
                            <input type="hidden" name="attribute_ids[]" value="${attributeIds}">
                            <input type="hidden" name="option_ids[]" value="${optionIds}">
                        </td>
                        <td>
                         <input type="number" class="form-control" name="quantity[]" min="1" step="1" >
                           <span class="text-danger" id="quantity_error"></span>
                        </td>
                        <td><input type="number" class="form-control" name="price[]" min="0" step="0.01" >
                         <span class="text-danger" id="price_error"></span>
                        </td>
                        <td><button class="btn btn-sm btn-danger remove-row">Remove</button></td>
                    </tr>
                `);
            }
        });

        $('#totalAmount').text(`৳${total.toFixed(2)}`);
    });

    $(document).on('click', '.remove-row', function () {
        const row = $(this).closest('tr');
        const price = parseFloat(row.find('input[type="number"]').eq(1).val());
        let total = parseFloat($('#totalAmount').text().replace('৳', ''));
        total -= price;
        row.remove();
        $('#totalAmount').text(`৳${total.toFixed(2)}`);
    });
});

$('#selectAll').on('change', function () {
    const isChecked = $(this).is(':checked');
    $('.select-row').prop('checked', isChecked);
});

$('#submitSelectedButton').on('click', async function () {
    try {
        // Collect product data
        const selectedProducts = getSelectedProducts();

        // Prepare form data
        const formData = prepareFormData(selectedProducts);



        // Perform validation
        // if (!validateFormData(formData)) {
        //     return;
        // }

        // Submit the data
        await submitFormData(formData);


        // Clear the selected rows
         $('.select-row:checked').closest('tr').remove();

        alert('Purchase submitted successfully');
    } catch (error) {
        console.error(error);
        if (error.response && error.response.status === 422) {
            // Handle validation errors
            const validationErrors = error.response.data.errors;
            Object.keys(validationErrors).forEach(fieldName => {
                showError(fieldName, validationErrors[fieldName][0]);
                console.log('error', validationErrors[fieldName][0]);
            });
        } else {
            alert('Failed to submit the purchase. Please try again.');
        }
    }
});



// Function to collect selected product data
function getSelectedProducts() {
    return $('.select-row:checked').map((_, el) => {
        const row = $(el).closest('tr');
        return {
            productId: row.find('input[name="product_id[]"]').val(),
            variant: row.find('input[name="variant[]"]').val(),
            quantity: row.find('input[name="quantity[]"]').val(),
            price: row.find('input[name="price[]"]').val(),
            attributeIds: row.find('input[name="attribute_ids[]"]').val(),
            optionIds: row.find('input[name="option_ids[]"]').val(),
        };
    }).get();
}

// Function to prepare form data
function prepareFormData(selectedProducts) {
    const formData = new FormData();
    formData.append('purchase_name', $('#product').val());
    formData.append('purchase_date', $('#purchase_date').val());
    formData.append('invoice_number', $('#invoice_number').val());
    formData.append('document', $('#document')[0]?.files[0] || '');
    formData.append('comment', $('#comment').val());
    formData.append('supplier_id', $('#supplier_id').val());
    formData.append('products', JSON.stringify(selectedProducts));

    return formData;
}

// Function to submit form data
async function submitFormData(formData) {
    const response = await axios.post('/admin/purchase', formData, {
        headers: { 'Content-Type': 'multipart/form-data' },
    });


    if (response.status !== 200) {
        throw new Error('Failed to submit the purchase');
    }

    return response.data;


}


// Function to validate form data
function validateFormData(formData) {
    let isValid = true;

    // Clear previous error messages
    clearErrorMessages();

    // Purchase name validation
    if (formData.get('purchase_name') === '') {
        showError('purchase_name', 'Purchase name is required');
        isValid = false;
    }

    // Purchase date validation
    if (formData.get('purchase_date') === '') {
        showError('purchase_date', 'Purchase date is required');
        isValid = false;
    }

    // Invoice number validation
    if (formData.get('invoice_number') === '') {
        showError('invoice_number', 'Invoice number is required');
        isValid = false;
    }

    // Supplier ID validation
    if (formData.get('supplier_id') === '') {
        showError('supplier_id', 'Supplier ID is required');
        isValid = false;
    }

    // Products validation
    if (formData.get('products') === '') {
        showError('products', 'Products are required');
        isValid = false;
    }

    // Quantity validation
    const quantities = formData.getAll('quantity[]');
    quantities.forEach((quantity, index) => {
        const quantityErrorElement = document.querySelectorAll('#quantity_error')[index];
        if (quantity === '' || parseFloat(quantity) <= 0) {
            if (quantityErrorElement) {
                quantityErrorElement.innerText = `Invalid quantity for product ${index + 1}`;
            }
            isValid = false;
        }
    });

    //Price validation
    const prices = formData.getAll('price[]');
    prices.forEach((price, index) => {
        const priceErrorElement = document.querySelectorAll('#price_error')[index];
        if (price === '' || parseFloat(price) <= 0) {
            if (priceErrorElement) {
                priceErrorElement.innerText = `Invalid price for product ${index + 1}`;
            }
            isValid = false;
        }
    });

    return isValid;
}

function showError(fieldName, message) {
    const errorElement = document.getElementById(`${fieldName}_error`);
    if (errorElement) {
        errorElement.innerText = message;
    }
}

function clearErrorMessages() {
    const errorElements = document.querySelectorAll('.text-danger');
    errorElements.forEach(element => {
        element.innerText = '';
    });
}


