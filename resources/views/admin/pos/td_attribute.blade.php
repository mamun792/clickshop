<td class="product-attributes-cell" data-product-id="{{ $product->id }}">
    @if($product->product_attributes->count() > 0)
        @foreach ($product->product_attributes->groupBy('attribute.name') as $attributeName => $attributes)
            <div class="attribute-wrapper">
                <span>{{ $attributeName }}:</span>
                <select 
                    class="attribute-select"
                    data-product-id="{{ $product->id }}"
                    data-attribute-name="{{ $attributeName }}"
                    onchange="handleAttributeChange(this)">
                    @foreach ($attributes as $attribute)
                        <option 
                            value="{{ $attribute->id }}"
                            data-productattribute-id="{{ $attribute->id }}"
                            data-option-id="{{ $attribute->attribute_option->id }}"
                            @if($attribute->combination_id) 
                                data-combine-id="{{ $attribute->combination_id }}"
                            @endif
                        >
                            {{ $attribute->attribute_option->name }}
                            {{ $attribute->id }}
                        </option>
                    @endforeach
                </select>
            </div>
        @endforeach

        <script>
            function handleAttributeChange(selectElement) {
                const productId = selectElement.dataset.productId;
                const selectedOption = selectElement.options[selectElement.selectedIndex];
                const productContainer = selectElement.closest('.product-attributes-cell');
                
                // Reset all selects in this product container first
                resetSelectOptions(productContainer);
                
                if (selectedOption.dataset.combineId) {
                    handleCombination(selectElement, selectedOption, productContainer);
                }
                
                // Trigger any additional logic or events here if needed
                updateProductState(productContainer);
            }

            function resetSelectOptions(productContainer) {
                const allSelects = productContainer.querySelectorAll('.attribute-select');
                allSelects.forEach(select => {
                    Array.from(select.options).forEach(option => {
                        option.disabled = false;
                        option.style.display = '';
                    });
                });
            }

            function handleCombination(selectElement, selectedOption, productContainer) {
                const combineId = selectedOption.dataset.combineId;
                const allSelects = productContainer.querySelectorAll('.attribute-select');
                
                allSelects.forEach(otherSelect => {
                    if (otherSelect !== selectElement) {
                        let hasMatchingOption = false;
                        
                        Array.from(otherSelect.options).forEach(option => {
                            if (option.dataset.combineId === combineId) {
                                option.disabled = false;
                                option.style.display = '';
                                hasMatchingOption = true;
                                otherSelect.value = option.value; // Auto-select matching option
                            } else if (option.dataset.combineId) {
                                option.disabled = true;
                                option.style.display = 'none';
                            } else {
                                // Handle non-combination options
                                option.disabled = true;
                                option.style.display = 'none';
                            }
                        });

                        // If no matching combination found, reset to first available option
                        if (!hasMatchingOption) {
                            const firstAvailableOption = Array.from(otherSelect.options).find(opt => !opt.disabled);
                            if (firstAvailableOption) {
                                otherSelect.value = firstAvailableOption.value;
                            }
                        }
                    }
                });
            }

            function updateProductState(productContainer) {
                // Get all selected values
                const selectedValues = Array.from(productContainer.querySelectorAll('.attribute-select'))
                    .map(select => ({
                        name: select.dataset.attributeName,
                        value: select.value,
                        optionId: select.options[select.selectedIndex].dataset.optionId
                    }));
                
                // You can use selectedValues to update price, SKU, or other product details
                console.log('Selected attributes:', selectedValues);
            }

            // Initialize on page load
            document.addEventListener('DOMContentLoaded', function() {
                document.querySelectorAll('.product-attributes-cell').forEach(productContainer => {
                    const selects = productContainer.querySelectorAll('.attribute-select');
                    const displayedOptionIds = new Set();

                    // First pass: Handle single attributes and build displayed options set
                    selects.forEach(select => {
                        let hasCombinations = false;
                        
                        Array.from(select.options).forEach(option => {
                            if (option.dataset.combineId) {
                                hasCombinations = true;
                            }
                            
                            const optionId = option.dataset.optionId;
                            if (!displayedOptionIds.has(optionId) || option.dataset.combineId) {
                                displayedOptionIds.add(optionId);
                                option.style.display = '';
                            } else {
                                option.style.display = 'none';
                            }
                        });

                        // If no combinations exist, ensure all options are enabled
                        if (!hasCombinations) {
                            Array.from(select.options).forEach(option => {
                                option.disabled = false;
                                option.style.display = '';
                            });
                        }
                    });

                    // Second pass: Initialize combination handling if first select has a combination
                    const firstSelect = selects[0];
                    if (firstSelect) {
                        const firstSelectedOption = firstSelect.options[firstSelect.selectedIndex];
                        if (firstSelectedOption && firstSelectedOption.dataset.combineId) {
                            handleAttributeChange(firstSelect);
                        }
                    }
                });
            });
        </script>
    @else
        <div>No attributes available</div>
    @endif
</td>