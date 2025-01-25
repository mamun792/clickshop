$(document).ready(function() {
    $('#productSelect').select2();

//here i need to disable other option ofchange type more than one the option issingleVariant and ismultipleVariants
        const isSingleVariant = $('#singleVariant');
        const ismultipleVariants = $('#multipleVariants');


        ismultipleVariants.on('change', function() {
            if (ismultipleVariants.is(':checked')) {
                // disable ismultipleVariants bttuon
                $('#singleVariant').prop('disabled', true);

            }
        });
        isSingleVariant.on('change', function() {
            if (isSingleVariant.is(':checked')) {
                // disable ismultipleVariants bttuon
                $('#multipleVariants').prop('disabled', true);

            }
        });



        // reset the radio buttons when the form is submitted
        $('#productSelect').on('change', function() {
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

    $('#addProductButton').on('click', function() {
        const productElement = $('#productSelect').find(':selected');
        const productCode = productElement.data('code');
        const productName = productElement.text();
        const productPrice = parseFloat(productElement.data('price'));

        const selectedAttributes = $('.attribute-checkbox:checked').map((_, el) => ({
            name: $(el).data('name'),
            value: el.value,
            attributeId: $(el).data('attribute-id'),
            optionId: $(el).attr('id').split('_')[1],
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
                // For single variants, only include the specific attribute and option ID
                const variantKey = Object.keys(variant)[0];
                const matchingAttribute = selectedAttributes.find(attr => attr.name === variantKey);
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
                        <td><input type="number" class="form-control" name="quantity[]" min="1" step="1"></td>
                        <td><input type="number" class="form-control" name="price[]" min="0" step="0.01"></td>
                        <td><button class="btn btn-sm btn-danger remove-row">Remove</button></td>
                    </tr>
                `);
            }
        });

        $('#totalAmount').text(`৳${total.toFixed(2)}`);
    });

    $(document).on('click', '.remove-row', function() {
        const row = $(this).closest('tr');
        const price = parseFloat(row.find('input[type="number"]').eq(1).val());
        let total = parseFloat($('#totalAmount').text().replace('৳', ''));
        total -= price;
        row.remove();
        $('#totalAmount').text(`৳${total.toFixed(2)}`);
    });
});

$('#selectAll').on('change', function() {
    const isChecked = $(this).is(':checked');
    $('.select-row').prop('checked', isChecked);
});

$('#submitSelectedButton').on('click', async function () {
    try {
        // Collect product data
        const selectedProducts = getSelectedProducts();

        // Prepare form data
        const formData = prepareFormData(selectedProducts);

        // Submit the data
        await submitFormData(formData);

        alert('Purchase submitted successfully');
    } catch (error) {
        console.error(error);
        alert('Failed to submit the purchase');
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
    formData.append('document', $('#document')[0]?.files[0] || ''); // Optional file handling
    formData.append('comment', $('#comment').val());
    formData.append('supplier_id', $('#supplier_id').val());
    formData.append('products', JSON.stringify(selectedProducts)); // Serialize products

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

    // Clear the selected rows
    $('.select-row:checked').closest('tr').remove();
    $('#totalAmount').text('৳0.00');
}

    // Submit the selected products to the server

    // Clear the selected rows


