@extends('admin.master')

@section('main-content')

<!-- Summernote CSS -->
<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.20/dist/summernote-lite.min.css" rel="stylesheet">

<div class="page-content">

    @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif




    <form method="post" action="{{route('products.update', $product->id)}}" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="row">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h5 class="fw-500">Update Product</h5>

                    </div>
                    <div class="card-body">


                        <input type="text" name="product_id" value="{{$product->id}}" hidden>

                        <div class="col-md-12">
                            <label for="product_name" class="form-label">Product Name</label>
                            <input type="text" class="form-control" id="product_name" name="product_name"
                                value="{{ old('product_name', $product->product_name) }}">
                            @error('product_name')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-12 mt-2">
                            <label for="product_code" class="form-label">Product Code</label>
                            <input type="text" class="form-control" id="product_code" name="product_code"
                                value="{{ old('product_code', $product->product_code) }}">
                            @error('product_code')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>


                    </div>

                </div>

                <div class="card">
                    <div class="card-body">

                        <div class="col-md-12" hidden>
                            <label for="short_description" class="form-label">Short Description</label>
                            <textarea class="form-control" id="short_description" name="short_description"
                                rows="3">{{ old('short_description', $product->short_description) }}</textarea>

                            @error('short_description')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror


                        </div>

                        {{--

                        <div class="col-md-12 mt-2">
                            <label for="editor" class="form-label">Description</label>
                            <textarea class="form-control" id="editor" name="description"
                                rows="3">{{ old('description', $product->description) }}</textarea>

                        @error('description')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror


                    </div>



                    --}}

                    <div class="col-md-12 mt-2">
                        <label for="editor" class="form-label">Description</label>
                        <textarea class="form-control" id="summernote" name="description"
                            rows="3">{{ old('description', $product->description) }}</textarea>

                        @error('description')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror


                    </div>


                </div>

            </div>



            <div class="card">
                <div class="card-body">

                    <div class="mb-4">
                        <label for="tag-imput" class="form-label">Product Tags</label>
                        <input id="tags-input" type="text" name="product_tag[]"
                            placeholder="Type tags and separate with commas" class="form-control"
                            value="{{ old('product_tag[]', json_encode($tagValues)  ) }}">

                        @error('product_tag')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror


                    </div>




                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" role="switch" id="flexSwitchCheckDefault1"
                            checked>
                        <label class="form-check-label" for="flexSwitchCheckDefault1">Specification</label>
                    </div>

                    <!-- Specification Input Section -->


                    <div class=" mt-2" id="specification-section">
                        @if (!empty($specifications) && is_array($specifications))




                        @for ($i = 0; $i < count($specifications); $i +=2)

                            @if ($i===0)
                            <div class="col-md-2 ml-auto">
                            <button type="button" class="btn btn-primary px-5 btn-sm" id="add-specification">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="white"
                                    class="bi bi-plus-lg" viewBox="0 0 16 16">
                                    <path fill-rule="evenodd"
                                        d="M8 2a.5.5 0 0 1 .5.5v5h5a.5.5 0 0 1 0 1h-5v5a.5.5 0 0 1-1 0v-5h-5a.5.5 0 0 1 0-1h5v-5A.5.5 0 0 1 8 2" />
                                </svg>
                            </button>
                    </div>

                    @endif

                    <div class="row mt-3">
                        <div class="col-md-5">
                            <input type="text" class="form-control" name="specification[]"
                                value="{{ $specifications[$i] ?? '' }}" placeholder="Specification name" />
                        </div>
                        <div class="col-md-5">
                            <input type="text" class="form-control" name="specification[]"
                                value="{{ $specifications[$i + 1] ?? '' }}" placeholder="Specification description" />
                        </div>
                        <div class="col-md-2">
                            <button class="btn btn-danger px-3 remove-input">

                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="white" class="bi bi-trash3" viewBox="0 0 16 16">
                                    <path d="M6.5 1h3a.5.5 0 0 1 .5.5v1H6v-1a.5.5 0 0 1 .5-.5M11 2.5v-1A1.5 1.5 0 0 0 9.5 0h-3A1.5 1.5 0 0 0 5 1.5v1H1.5a.5.5 0 0 0 0 1h.538l.853 10.66A2 2 0 0 0 4.885 16h6.23a2 2 0 0 0 1.994-1.84l.853-10.66h.538a.5.5 0 0 0 0-1zm1.958 1-.846 10.58a1 1 0 0 1-.997.92h-6.23a1 1 0 0 1-.997-.92L3.042 3.5zm-7.487 1a.5.5 0 0 1 .528.47l.5 8.5a.5.5 0 0 1-.998.06L5 5.03a.5.5 0 0 1 .47-.53Zm5.058 0a.5.5 0 0 1 .47.53l-.5 8.5a.5.5 0 1 1-.998-.06l.5-8.5a.5.5 0 0 1 .528-.47M8 4.5a.5.5 0 0 1 .5.5v8.5a.5.5 0 0 1-1 0V5a.5.5 0 0 1 .5-.5" />
                                </svg>

                            </button>
                        </div>



                    </div>
                    @endfor
                    @else
                    <div class="row mt-2">
                        <div class="col-md-5">
                            <input type="text" class="form-control" name="specification[]" placeholder="Specification name" />
                        </div>
                        <div class="col-md-5">
                            <input type="text" class="form-control" name="specification[]" placeholder="Specification description" />
                        </div>
                        <div class="col-md-2">
                            <button type="button" class="btn btn-primary px-3" id="add-specification">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="white"
                                    class="bi bi-plus-lg" viewBox="0 0 16 16">
                                    <path fill-rule="evenodd"
                                        d="M8 2a.5.5 0 0 1 .5.5v5h5a.5.5 0 0 1 0 1h-5v5a.5.5 0 0 1-1 0v-5h-5a.5.5 0 0 1 0-1h5v-5A.5.5 0 0 1 8 2" />
                                </svg>
                            </button>
                        </div>
                    </div>
                    @endif
                </div>




                @error('specification')
                <div class="text-danger">{{ $message }}</div>
                @enderror

                <!-- Dynamic Input Fields Container -->
                <div id="dynamic-input-container">




                </div>






            </div>

        </div>


        <!-- <div class="card">
                    <div class="card-body">
                        <ul class="nav nav-tabs nav-primary" role="tablist">
                            @foreach($attributes as $key => $attribute)
                            <li class="nav-item" role="presentation">
                                <a class="nav-link @if($key === 0) active @endif" data-bs-toggle="tab"
                                    href="#{{ strtolower($attribute->name) }}" role="tab"
                                    aria-selected="{{ $key === 0 ? 'true' : 'false' }}">
                                    <div class="d-flex align-items-center">
                                        <div class="tab-icon"><i class="bx bx-tag-alt font-18 me-1"></i></div>
                                        <div class="tab-title">{{ $attribute->name }}</div>
                                    </div>
                                </a>
                            </li>
                            @endforeach
                        </ul>
                        <div class="tab-content py-3">
                            @foreach($attributes as $key => $attribute)
                            <div class="tab-pane fade @if($key === 0) show active @endif"
                                id="{{ strtolower($attribute->name) }}" role="tabpanel">
                                @foreach($attribute->attribute_option as $option)
                                @php
                                    // Find the matching product_attribute data
                                    $productAttribute = $product->product_attributes->firstWhere('attribute_option_id', $option->id);
                                @endphp
                                <div class="row row-cols-1 g-3 row-cols-lg-auto align-items-center mt-2">
                                    <div class="col">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox"
                                                id="option_{{ $option->id }}"
                                                name="attributes[{{ $attribute->id }}][]"
                                                value="{{ $option->id }}"
                                                @if($productAttribute) checked @endif>
                                            <label class="form-check-label" for="option_{{ $option->id }}"
                                                style="width: 120px;">{{ $option->name }}</label>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <input type="text" class="form-control"
                                            name="attribute_prices[{{ $option->id }}]"
                                            placeholder="Price"
                                            value="{{ $productAttribute->price ?? '' }}">
                                    </div>
                                    <div class="col">
                                        <input type="number" class="form-control"
                                            name="attribute_quantities[{{ $option->id }}]"
                                            placeholder="Quantity"
                                            value="{{ $productAttribute->quantity ?? '' }}">
                                    </div>
                                </div>
                                @endforeach
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div> -->
        <!-- Wrapper card -->
        <div class="card">
            <div class="card-body">
                <form id="attributeForm" method="POST">
                    @csrf


                    @if(isset($SingleAttribute))
                    <input type="hidden" id="singleAttributeData" value='@json($SingleAttribute)'>
                    @endif
                    @if(isset($productCombinations))
                    <input type="hidden" id="combinationsData" value='@json($productCombinations)'>
                    @endif

                    <!-- Attribute Selection Tabs -->
                    <ul class="nav nav-tabs nav-primary" role="tablist">
                        @foreach ($attributes as $key => $attribute)
                        <li class="nav-item" role="presentation">
                            <a class="nav-link @if ($key === 0) active @endif"
                                data-bs-toggle="tab" href="#{{ strtolower($attribute->name) }}"
                                role="tab" aria-selected="{{ $key === 0 ? 'true' : 'false' }}">
                                <div class="d-flex align-items-center">
                                    <div class="tab-icon"><i class="bx bx-tag-alt font-18 me-1"></i></div>
                                    <div class="tab-title">{{ $attribute->name }}</div>
                                </div>
                            </a>
                        </li>
                        @endforeach
                    </ul>

                    <!-- Attribute Options -->
                    <div class="tab-content py-3">
                        @foreach ($attributes as $key => $attribute)
                        <div class="tab-pane fade @if ($key === 0) show active @endif"
                            id="{{ strtolower($attribute->name) }}" role="tabpanel">
                            @foreach ($attribute->attribute_option as $option)
                            <div class="row row-cols-1 g-3 row-cols-lg-auto align-items-center mt-2">
                                <div class="col">
                                    <div class="form-check">
                                        <input class="form-check-input attributecheckmark" type="checkbox"
                                            id="option_{{ $option->id }}"
                                            name="attributes[{{ $attribute->id }}][]"
                                            value="{{ $option->id }}"
                                            data-attribute-id="{{ $attribute->id }}"
                                            data-attribute-name="{{ $attribute->name }}"
                                            data-option-id="{{ $option->id }}"
                                            data-option-name="{{ $option->name }}">
                                        <label class="form-check-label" for="option_{{ $option->id }}"
                                            style="width: 120px;">{{ $option->name }}</label>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                        @endforeach
                    </div>

                    <hr />

                    <!-- Tables Section -->
                    <div class="row">
                        <!-- Single Options Table -->
                        <div class="col-12 mb-4">
                            <div class="card">
                                <div class="card-header bg-light">
                                    <h6 class="mb-0">Single Options</h6>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-bordered" id="singleOptionsTable">
                                            <thead>
                                                <tr>
                                                    <th width="30%">Option</th>
                                                    <th>Price</th>
                                                    <th>Quantity</th>

                                                </tr>
                                            </thead>
                                            <tbody>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Combinations Table -->
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header bg-light">
                                    <h6 class="mb-0">Combinations</h6>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-bordered" id="combinationsTable">
                                            <thead>
                                                <tr>
                                                    <th width="30%">Combination</th>
                                                    <th>Price</th>
                                                    <th>Quantity</th>

                                                </tr>
                                            </thead>
                                            <tbody>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>


                </form>
            </div>
        </div>

        <script>
            document.addEventListener('DOMContentLoaded', function() {
                let selectedAttributes = {};
                let selectedOptions = new Map();
                let optionCounter = 0;
                let combinationCounter = 0;
                let existingSingleAttributes = [];
                let existingCombinations = [];

                function initializeExistingData() {
                    const singleAttributeData = document.getElementById('singleAttributeData');
                    const combinationsData = document.getElementById('combinationsData');

                    try {
                        if (singleAttributeData && singleAttributeData.value) {
                            existingSingleAttributes = JSON.parse(singleAttributeData.value);
                            existingSingleAttributes.forEach(attr => {
                                const checkbox = document.querySelector(
                                    `.attributecheckmark[data-attribute-id="${attr.attribute_id}"][value="${attr.attribute_option_id}"]`
                                );
                                if (checkbox) {
                                    checkbox.checked = true;
                                    const attributeId = attr.attribute_id.toString();
                                    const optionId = attr.attribute_option_id.toString();
                                    const attributeName = checkbox.dataset.attributeName;
                                    const optionName = checkbox.dataset.optionName;

                                    if (!selectedOptions.has(attributeId)) {
                                        selectedOptions.set(attributeId, []);
                                    }
                                    selectedOptions.get(attributeId).push({
                                        id: optionId,
                                        name: optionName,
                                        optionId: optionId,
                                        attributeName: attributeName,
                                        attributeId: attributeId,
                                        price: attr.price,
                                        quantity: attr.quantity,
                                        sold_quantity: attr.sold_quantity || 0,
                                        status: attr.status
                                    });

                                    if (!selectedAttributes[attributeId]) {
                                        selectedAttributes[attributeId] = [];
                                    }
                                    selectedAttributes[attributeId].push(optionName);
                                }
                            });
                        }

                        if (combinationsData && combinationsData.value) {
                            existingCombinations = JSON.parse(combinationsData.value);
                            existingCombinations.forEach(combo => {
                                if (combo.combination_string) {
                                    const combinationArray = JSON.parse(combo.combination_string);
                                    combinationArray.forEach(item => {
                                        const checkbox = document.querySelector(
                                            `.attributecheckmark[data-attribute-id="${item.attributeId}"][value="${item.optionId}"]`
                                        );
                                        if (checkbox && !checkbox.checked) {
                                            checkbox.checked = true;
                                            const event = new Event('change');
                                            checkbox.dispatchEvent(event);
                                        }
                                    });
                                }
                            });
                        }
                    } catch (e) {
                        console.error('Error parsing existing data:', e);
                    }

                    updateAllDisplays();
                }

                function findExistingAttributeData(attributeId, optionId) {
                    return existingSingleAttributes.find(attr =>
                        attr.attribute_id.toString() === attributeId.toString() &&
                        attr.attribute_option_id.toString() === optionId.toString()
                    );
                }

                function updateSingleOptionsDisplay() {
                    const displayArea = document.querySelector('#singleOptionsTable tbody');
                    if (!displayArea) return;

                    displayArea.innerHTML = '';
                    optionCounter = 0;

                    selectedOptions.forEach((options, attributeId) => {
                        options.forEach(option => {
                            const existingData = findExistingAttributeData(attributeId, option.id);

                            const row = document.createElement('tr');
                            row.innerHTML = `
                    <td>
                        <div class="form-check">
                            <input class="form-check-input single-option-checkbox"
                                type="checkbox"
                                name="singleOptions[${optionCounter}][selected]"
                                value="1"
                                data-attribute-id="${attributeId}"
                                data-option-id="${option.id}"
                                ${existingData ? 'checked' : ''}>
                            <input type="hidden"
                                name="singleOptions[${optionCounter}][attributeName]"
                                value="${option.attributeName}"
                                ${existingData ? '' : 'disabled'}>
                            <input type="hidden"
                                name="singleOptions[${optionCounter}][attributeId]"
                                value="${attributeId}"
                                ${existingData ? '' : 'disabled'}>
                            <input type="hidden"
                                name="singleOptions[${optionCounter}][optionId]"
                                value="${option.id}"
                                ${existingData ? '' : 'disabled'}>
                            <input type="hidden"
                                name="singleOptions[${optionCounter}][optionName]"
                                value="${option.name}"
                                ${existingData ? '' : 'disabled'}>
                            <input type="hidden"
                                name="singleOptions[${optionCounter}][sold_quantity]"
                                value="${existingData ? existingData.sold_quantity || 0 : 0}"
                                ${existingData ? '' : 'disabled'}>
                            <label class="form-check-label">
                                ${option.name}
                                ${existingData && existingData.sold_quantity > 0 ? 
                                    `<span class="text-muted">(${existingData.sold_quantity} sold)</span>` : ''}
                            </label>
                        </div>
                    </td>
                    <td>
                        <input type="number" class="form-control"
                            name="singleOptions[${optionCounter}][price]"
                            placeholder="Price"
                            step="0.01"
                            min="0"
                            value="${existingData ? existingData.price || '' : ''}"
                            ${existingData ? '' : 'disabled'}>
                    </td>
                    <td>
                        <input type="number" class="form-control"
                            name="singleOptions[${optionCounter}][quantity]"
                            placeholder="Quantity"
                            min="0"
                            value="${existingData ? existingData.quantity || '' : ''}"
                            ${existingData ? '' : 'disabled'}>
                    </td>
                `;
                            displayArea.appendChild(row);

                            const checkbox = row.querySelector('.single-option-checkbox');
                            const inputs = row.querySelectorAll('input:not(.single-option-checkbox)');

                            checkbox.addEventListener('change', function(e) {
                                inputs.forEach(input => {
                                    input.disabled = !e.target.checked;
                                });
                            });

                            optionCounter++;
                        });
                    });
                }

                function calculateCombinationTotals(combo) {
                    if (!combo.attributes || !Array.isArray(combo.attributes)) {
                        return {
                            totalPrice: 0,
                            totalQuantity: 0,
                            totalSoldQuantity: 0
                        };
                    }

                    const totals = combo.attributes.reduce((acc, attr) => {
                        acc.totalPrice += parseFloat(attr.price) || 0;
                        acc.totalQuantity += parseInt(attr.quantity) || 0;
                        acc.totalSoldQuantity += parseInt(attr.sold_quantity) || 0;
                        return acc;
                    }, {
                        totalPrice: 0,
                        totalQuantity: 0,
                        totalSoldQuantity: 0
                    });

                    // Calculate averages based on number of attributes
                    const attrCount = combo.attributes.length;
                    if (attrCount > 0) {
                        totals.totalPrice = totals.totalPrice / attrCount;
                        totals.totalQuantity = Math.floor(totals.totalQuantity / attrCount);
                        totals.totalSoldQuantity = Math.floor(totals.totalSoldQuantity / attrCount);
                    }

                    return totals;
                }

                function findExistingCombination(combination) {
                    return existingCombinations.find(combo => {
                        try {
                            const comboData = JSON.parse(combo.combination_string);
                            if (comboData.length !== combination.length) return false;

                            const sortedComboData = [...comboData].sort((a, b) =>
                                a.attributeId.toString().localeCompare(b.attributeId.toString())
                            );
                            const sortedCombination = [...combination].sort((a, b) =>
                                a.attributeId.toString().localeCompare(b.attributeId.toString())
                            );

                            return sortedComboData.every((item, index) => {
                                const combinationItem = sortedCombination[index];
                                return item.attributeId.toString() === combinationItem.attributeId.toString() &&
                                    item.optionId.toString() === combinationItem.optionId.toString();
                            });
                        } catch (e) {
                            console.error('Error parsing combination string:', e);
                            return false;
                        }
                    });
                }

                function updateCombinationsDisplay() {
                    const displayArea = document.querySelector('#combinationsTable tbody');
                    if (!displayArea) return;

                    displayArea.innerHTML = '';
                    combinationCounter = 0;

                    if (Object.keys(selectedAttributes).length < 2) return;

                    const attributeArrays = [];
                    selectedOptions.forEach((options, attributeId) => {
                        const optionsArray = options.map(opt => ({
                            attributeId: attributeId,
                            optionId: opt.id,
                            optionName: opt.name,
                            attributeName: opt.attributeName
                        }));
                        if (optionsArray.length > 0) {
                            attributeArrays.push(optionsArray);
                        }
                    });

                    const combinations = generateAllCombinations(attributeArrays);

                    combinations.forEach((combination) => {
                        const existingCombo = findExistingCombination(combination);
                        const sortedCombination = [...combination].sort((a, b) => {
                            const order = {
                                "Display": 1,
                                "Color": 2,
                                "FrontCamera": 3
                            };
                            return order[a.attributeName] - order[b.attributeName];
                        });

                        const displayName = sortedCombination.map(item => item.optionName).join(', ');

                        let totals = {
                            totalPrice: 0,
                            totalQuantity: 0,
                            totalSoldQuantity: 0
                        };
                        if (existingCombo) {
                            totals = calculateCombinationTotals(existingCombo);
                        }

                        const row = document.createElement('tr');
                        row.innerHTML = `
                <td>
                    <div class="form-check">
                        <input class="form-check-input combination-checkbox"
                            type="checkbox"
                            name="combinations[${combinationCounter}][selected]"
                            value="1"
                            ${existingCombo ? 'checked' : ''}>
                        <input type="hidden"
                            name="combinations[${combinationCounter}][combination_id]"
                            value="${existingCombo ? existingCombo.id : ''}"
                            ${existingCombo ? '' : 'disabled'}>
                        <input type="hidden"
                            name="combinations[${combinationCounter}][attributes]"
                            value='${JSON.stringify(sortedCombination)}'
                            ${existingCombo ? '' : 'disabled'}>
                        <input type="hidden"
                            name="combinations[${combinationCounter}][sold_quantity]"
                            value="${totals.totalSoldQuantity}"
                            ${existingCombo ? '' : 'disabled'}>
                        <label class="form-check-label">
                            ${displayName}
                            ${totals.totalSoldQuantity > 0 ? 
                                `<span class="text-muted">(${totals.totalSoldQuantity} sold)</span>` : ''}
                        </label>
                    </div>
                </td>
                <td>
                    <input type="number" class="form-control"
                        name="combinations[${combinationCounter}][price]"
                        placeholder="Price"
                        step="0.01"
                        min="0"
                        value="${totals.totalPrice.toFixed(2)}"
                        ${existingCombo ? '' : 'disabled'}>
                </td>
                <td>
                    <input type="number" class="form-control"
                        name="combinations[${combinationCounter}][quantity]"
                        placeholder="Quantity"
                        min="0"
                        value="${totals.totalQuantity}"
                        ${existingCombo ? '' : 'disabled'}>
                </td>
            `;
                        displayArea.appendChild(row);

                        const checkbox = row.querySelector('.combination-checkbox');
                        const inputs = row.querySelectorAll('input:not(.combination-checkbox)');

                        checkbox.addEventListener('change', function(e) {
                            inputs.forEach(input => {
                                input.disabled = !e.target.checked;
                            });
                        });

                        combinationCounter++;
                    });
                }

                function generateAllCombinations(arrays) {
                    if (arrays.length === 0) return [];

                    function combine(current, remainingArrays) {
                        if (remainingArrays.length === 0) {
                            return [current];
                        }

                        const results = [];
                        const currentArray = remainingArrays[0];
                        const rest = remainingArrays.slice(1);

                        currentArray.forEach(item => {
                            const newCurrent = [...current, item];
                            const subResults = combine(newCurrent, rest);
                            results.push(...subResults);
                        });

                        return results;
                    }

                    return combine([], arrays);
                }

                // Event listeners for attribute checkboxes
                document.querySelectorAll(".attributecheckmark").forEach(function(element) {
                    element.addEventListener('change', function(e) {
                        const optionId = e.target.value;
                        const attributeId = e.target.dataset.attributeId;
                        const attributeName = e.target.dataset.attributeName;
                        const optionName = e.target.dataset.optionName;

                        if (e.target.checked) {
                            if (!selectedOptions.has(attributeId)) {
                                selectedOptions.set(attributeId, []);
                            }
                            selectedOptions.get(attributeId).push({
                                id: optionId,
                                name: optionName,
                                optionId: optionId,
                                attributeName: attributeName,
                                attributeId: attributeId
                            });

                            if (!selectedAttributes[attributeId]) {
                                selectedAttributes[attributeId] = [];
                            }
                            selectedAttributes[attributeId].push(optionName);
                        } else {
                            const options = selectedOptions.get(attributeId);
                            if (options) {
                                const index = options.findIndex(opt => opt.id === optionId);
                                if (index > -1) options.splice(index, 1);
                                if (options.length === 0) {
                                    selectedOptions.delete(attributeId);
                                }
                            }

                            if (selectedAttributes[attributeId]) {
                                selectedAttributes[attributeId] = selectedAttributes[attributeId].filter(
                                    name => name !== optionName
                                );
                                if (selectedAttributes[attributeId].length === 0) {
                                    delete selectedAttributes[attributeId];
                                }
                            }
                        }

                        updateAllDisplays();
                    });
                });

                function updateAllDisplays() {
                    updateSingleOptionsDisplay();
                    updateCombinationsDisplay();
                }

                // Initialize the data when the page loads
                initializeExistingData();
            });
        </script>


</div>
<div class="col-md-6">

    <div class="card">


        <div class="card-body">

            <div class="col-md-12">
                <label for="stock_option" class="form-label">Select Stock Option</label>
                <select id="stock_option" class="form-select" name="stock_option">


                    <option value="Manual" {{$product->stock_option == 'Manual' ? 'selected' : '' }}>Manual</option>

                    <option value="From Purchase" {{$product->stock_option == 'From Purchase' ? 'selected' : '' }}>From Purchase</option>





                </select>
                @error('stock_option')
                <div class="text-danger">{{ $message }}</div>
                @enderror

            </div>

            <div class="col-md-12 mt-2">
                <label for="quantity" class="form-label">Quantity</label>
                <div class="position-relative">
                    <input type="number" class="form-control" id="quantity" name="quantity"
                        value="{{ old('quantity', $product->quantity) }}">
                    <span class="position-absolute top-50 translate-middle-y"></span>
                </div>

                @error('quantity')
                <div class="text-danger">{{ $message }}</div>
                @enderror


            </div>

        </div>

    </div>

    <div class="card">


        <div class="card-body">



            <div class="col-md-12 mt-2">
                <label for="price" class="form-label">Price</label>
                <div class="position-relative">
                    <input type="number" class="form-control" id="price" name="price"
                        value="{{ old('price', $product->price) }}">
                    <span class="position-absolute top-50 translate-middle-y"></span>
                </div>

                @error('price')
                <div class="text-danger">{{ $message }}</div>
                @enderror


            </div>

            <div class="col-md-12 mt-2">
                <label for="previous_price" class="form-label">Previous Price</label>
                <div class="position-relative">
                    <input type="number" class="form-control" id="previous_price" name="previous_price"
                        value="{{ old('previous_price', $product->previous_price) }}">
                    <span class="position-absolute top-50 translate-middle-y"></span>
                </div>

                @error('previous_price')
                <div class="text-danger">{{ $message }}</div>
                @enderror


            </div>

        </div>

    </div>

    <div class="card">


        <div class="card-body">

            <div class="col-md-12">
                <label for="category" class="form-label">Category</label>
                <select id="category" class="form-select" name="category_id">
                    <option selected="">Choose...</option>
                    @foreach($categories as $item)
                    <option value="{{$item->id}}" {{$product->category_id == $item->id ? 'selected' : '' }}>{{$item->name}}</option>
                    @endforeach

                    @error('category_id')
                    <div class="text-danger">{{ $message }}</div>
                    @enderror





                </select>
            </div>

            <div class="col-md-12 mt-2">
                <label for="subcategory" class="form-label">Sub Category</label>
                <select id="subcategory" class="form-select" name="subcategory_id">
                    <option disabled>Choose...</option>

                    @foreach($sub_categories as $item)
                    <option value="{{$item->id}}" {{$product->category_id == $item->id ? 'selected' : ''}}>{{$item->name}}</option>
                    @endforeach


                </select>

                @error('subcategory_id')
                <div class="text-danger">{{ $message }}</div>
                @enderror



            </div>

            <div class="col-md-12 mt-2">
                <label for="input19" class="form-label">Brand</label>
                <select id="input19" class="form-select" name="brand_id">
                    <option selected disabled>Choose...</option>


                    @foreach($brands as $item)
                    <option value="{{$item->id}}" {{$product->brand_id == $item->id ? 'selected' : '' }}>{{$item->company}}</option>
                    @endforeach

                    @error('brand_id')
                    <div class="text-danger">{{ $message }}</div>
                    @enderror




                </select>
            </div>

        </div>

    </div>

  
    @include('admin.products.imageupdate')
    <div class="card">




        <div class="card-body">
            <h5 class="mt-2">SEO Information</h5>

            <div class="col-md-12">
                <label for="meta_title" class="form-label">Meta Title</label>
                <input type="text" class="form-control" id="meta_title" name="meta_title"
                    value="{{ old('meta_title', $product->meta_title) }}">

                @error('meta_title')
                <div class="text-danger">{{ $message }}</div>
                @enderror

            </div>



            <div class="col-md-12 mt-2">
                <label for="meta_description" class="form-label">Meta Description</label>
                <textarea class="form-control" name="meta_description" id="meta_description"
                    rows="3"> {{ old('meta_description', $product->meta_description) }} </textarea>

                @error('meta_description')
                <div class="text-danger">{{ $message }}</div>
                @enderror


            </div>


        </div>

    </div>


</div>




<button type="submit" class="w-100 btn btn-primary">Update</button>

</div>

</form>





</div>

@endsection

@push('scripts')

<!-----Tag script--->

<script>
    // Initialize Tagify on the input field
    var input = document.querySelector('#tags-input');
    var tagify = new Tagify(input, {
        delimiters: ",", // Comma will separate the tags
        whitelist: [], // No predefined tags (allow custom ones)
    });
</script>



<!---specification script------>

<script>
    $(document).ready(function() {
        // Toggle the Specification section based on checkbox
        $('#flexSwitchCheckDefault1').change(function() {
            if ($(this).prop('checked')) {
                $('#specification-section').show();
            } else {
                $('#specification-section').hide();
                $('#dynamic-input-container').empty(); // Clear dynamic inputs if unchecked
            }
        });

        // Add new dynamic input fields when the Add button is clicked
        $('#add-specification').click(function() {
            // Append a new input group (two text fields) to the dynamic input container
            var newInputField = `
                <div class="row mt-2">
                    <div class="col-md-5">
                        <input type="text" class="form-control" name="specification[]" placeholder="Specification name" />
                    </div>
                    <div class="col-md-5">
                        <input type="text" class="form-control" name="specification[]" placeholder="Specification Description" />
                    </div>
                    <div class="col-md-2">
                        <button class="btn btn-danger px-3 remove-input">

                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="white" class="bi bi-trash3" viewBox="0 0 16 16">
                                  <path d="M6.5 1h3a.5.5 0 0 1 .5.5v1H6v-1a.5.5 0 0 1 .5-.5M11 2.5v-1A1.5 1.5 0 0 0 9.5 0h-3A1.5 1.5 0 0 0 5 1.5v1H1.5a.5.5 0 0 0 0 1h.538l.853 10.66A2 2 0 0 0 4.885 16h6.23a2 2 0 0 0 1.994-1.84l.853-10.66h.538a.5.5 0 0 0 0-1zm1.958 1-.846 10.58a1 1 0 0 1-.997.92h-6.23a1 1 0 0 1-.997-.92L3.042 3.5zm-7.487 1a.5.5 0 0 1 .528.47l.5 8.5a.5.5 0 0 1-.998.06L5 5.03a.5.5 0 0 1 .47-.53Zm5.058 0a.5.5 0 0 1 .47.53l-.5 8.5a.5.5 0 1 1-.998-.06l.5-8.5a.5.5 0 0 1 .528-.47M8 4.5a.5.5 0 0 1 .5.5v8.5a.5.5 0 0 1-1 0V5a.5.5 0 0 1 .5-.5"/>
                            </svg>

                        </button>
                    </div>
                </div>
            `;
            $('#dynamic-input-container').append(newInputField);
        });

        // Remove dynamically added input fields
        $(document).on('click', '.remove-input', function() {
            $(this).closest('.row').remove();
        });
    });
</script>


<!--dynamic dropdown subcategory --->

<script>
    $(document).ready(function() {
        $('#category').on('change', function() {
            const categoryId = $(this).val();
            const subcategoryDropdown = $('#subcategory');

            // Clear existing options
            subcategoryDropdown.empty().append('<option selected="" disabled>Choose...</option>');

            if (categoryId) {
                $.ajax({
                    url: `/admin/get-subcategories/${categoryId}`,
                    type: 'GET',
                    dataType: 'json',
                    success: function(data) {
                        // Populate subcategory dropdown
                        $.each(data, function(key, subcategory) {
                            subcategoryDropdown.append(`<option value="${subcategory.id}">${subcategory.name}</option>`);
                        });
                    },
                    error: function(xhr, status, error) {
                        console.error('Error fetching subcategories:', error);
                    }
                });
            }
        });
    });
</script>


<!--summernot editor script---->

<script>
    $(document).ready(function() {
        $('#summernote').summernote({
            height: 200, // set editor height
            toolbar: [
                ['style', ['style']],
                ['font', ['bold', 'italic', 'underline', 'clear']],
                ['fontsize', ['fontsize']],
                ['color', ['color']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['height', ['height']],
                ['insert', ['link', 'picture', 'video']],
                ['view', ['fullscreen', 'codeview', 'help']]
            ]
        });
    });
</script>




@endpush