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




    <form method="post" action="{{ route('products.store') }}" enctype="multipart/form-data">
        @csrf

        <div class="row">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h5 class="fw-500">Insert Product</h5>

                    </div>
                    <div class="card-body">




                        <div class="col-md-12">
                            <label for="product_name" class="form-label">Product Name <span
                                    style="font-weight:bold; color: red">*</span></label>
                            <input type="text" class="form-control" id="product_name" name="product_name"
                                value="{{ old('product_name') ?? 'test product' }} ">
                            @error('product_name')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-12 mt-2">
                            <label for="product_code" class="form-label">Product Code <span
                                    style="font-weight:bold; color: red">*</span> </label>
                            <input type="text" class="form-control" id="product_code" name="product_code"
                                value="{{ old('product_code') ?? 'uniquecodwe90909' }}">

                            <div class="input-group mb-3" id="purchase_product_code_group" style="display: none">
                                <input type="text" class="form-control" id="purchase_product_code"
                                    placeholder="Enter Product Code" name="purchase_product_code"
                                    aria-label="Product Code" aria-describedby="button-addon2">
                                <button class="btn btn-primary" type="button" id="loadButton">Load</button>
                            </div>

                            @error('product_code')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>


                    </div>

                </div>

                <div class="card">
                    <div class="card-body">

                        <div class="col-md-12" hidden>
                            <label for="short_description" class="form-label">Short Description <span
                                    style="font-weight:bold; color: red">*</span> </label>
                            <textarea class="form-control" id="short_description" name="short_description" rows="3">{{ old('short_description') ?? 'asdgjhasgdjhasg' }}</textarea>

                            @error('short_description')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror


                        </div>



                        <div class="form-group" style="margin-top: 10px">
                            <label for="content">Description</label>
                            <textarea id="summernote" name="description" class="form-control">
                            {{ old('description') }}
                            test Desasdasd
                            </textarea>
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
                                value="{{ old('product_tag[]') }}">

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
                        <div class="row mt-2" id="specification-section">
                            <div class="col-md-5">
                                <input type="text" class="form-control" name="specification[]"
                                    placeholder="Specification name" />
                            </div>
                            <div class="col-md-5">
                                <input type="text" class="form-control" name="specification[]"
                                    placeholder="Specification description" />
                            </div>
                            <div class="col-md-2">
                                <button type="button" class="btn btn-primary px-3" id="add-specification">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                        fill="white" class="bi bi-plus-lg" viewBox="0 0 16 16">
                                        <path fill-rule="evenodd"
                                            d="M8 2a.5.5 0 0 1 .5.5v5h5a.5.5 0 0 1 0 1h-5v5a.5.5 0 0 1-1 0v-5h-5a.5.5 0 0 1 0-1h5v-5A.5.5 0 0 1 8 2" />
                                    </svg>
                                </button>
                            </div>
                        </div>

                        @error('specification')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror

                        <!-- Dynamic Input Fields Container -->
                        <div id="dynamic-input-container"></div>






                    </div>

                </div>



                <div class="card" id="attributeForm">
                    <div class="card">
                        <div class="card-body" >


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

                            <div class="col-md-12 mt-2">
                                <button type="button" class="btn btn-primary " id="singleButton">Single</button>
                                <button type="button" class="btn btn-primary" id="CombineButton">Combinations</button>
                            </div>
                            <script>
                                document.querySelector('#singleButton').addEventListener('click', function() {
                                    document.querySelector('.singleattibute-container').style.display = 'block';
                                    document.querySelector('.combineattibute-container').style.display = 'none';
                                    document.querySelector('#CombineButton').disabled = true;
                                });
                                document.querySelector('#CombineButton').addEventListener('click', function() {
                                    document.querySelector('.singleattibute-container').style.display = 'none';
                                    document.querySelector('.combineattibute-container').style.display = 'block';
                                    document.querySelector('#singleButton').disabled = true;
                                });
                            </script>


                            <hr />

                            <div class="row" id="purchaseDetails" style="display: none;">



                                <!-- Single Options Table -->
                                <div class="col-12 mb-4 singleattibute-container">
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
                                <div class="col-12 combineattibute-container">
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



                        </div>

                    </div>

                    <script>
                        document.addEventListener('DOMContentLoaded', function() {
                            let selectedAttributes = {};
                            let selectedOptions = new Map();
                            let optionCounter = 0;
                            let combinationCounter = 0;

                            // Handle attribute checkbox changes
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

                                        selectedAttributes[attributeId] = selectedAttributes[attributeId].filter(
                                            name => name !== optionName
                                        );
                                        if (selectedAttributes[attributeId].length === 0) {
                                            delete selectedAttributes[attributeId];
                                        }
                                    }

                                    updateAllDisplays();
                                });
                            });

                            function updateAllDisplays() {
                                updateSingleOptionsDisplay();
                                updateCombinationsDisplay();
                            }

                            function updateSingleOptionsDisplay() {
                                const displayArea = document.querySelector('#singleOptionsTable tbody');
                                displayArea.innerHTML = '';
                                optionCounter = 0;

                                selectedOptions.forEach((options, attributeId) => {
                                    options.forEach(option => {
                                        const row = document.createElement('tr');
                                        row.innerHTML = `
                    <td>
                        <div class="form-check">
                            <input class="form-check-input single-option-checkbox"
                                type="checkbox"
                                name="singleOptions[${optionCounter}][selected]"
                                value="1"
                                data-attribute-id="${attributeId}"
                                data-option-id="${option.id}">
                            <input type="hidden"
                                name="singleOptions[${optionCounter}][attributeName]"
                                value="${option.attributeName}"
                                disabled>
                            <input type="hidden"
                                name="singleOptions[${optionCounter}][attributeId]"
                                value="${attributeId}"
                                disabled>
                            <input type="hidden"
                                name="singleOptions[${optionCounter}][optionId]"
                                value="${option.id}"
                                disabled>
                            <input type="hidden"
                                name="singleOptions[${optionCounter}][optionName]"
                                value="${option.name}"
                                disabled>
                            <label class="form-check-label">
                                ${option.name}
                            </label>
                        </div>
                    </td>
                    <td>
                        <input type="number" class="form-control"
                            name="singleOptions[${optionCounter}][price]"
                            placeholder="Price"
                            disabled>
                    </td>
                    <td>
                        <input type="number" class="form-control"
                            name="singleOptions[${optionCounter}][quantity]"
                            placeholder="Quantity"
                            disabled>
                    </td>
                `;
                                        displayArea.appendChild(row);

                                        const checkbox = row.querySelector('.single-option-checkbox');
                                        const inputs = row.querySelectorAll('input');
                                        checkbox.addEventListener('change', function(e) {
                                            inputs.forEach(input => {
                                                if (input !== checkbox) {
                                                    input.disabled = !e.target.checked;
                                                    if (!e.target.checked && input.type === 'number') {
                                                        input.value = '';
                                                    }
                                                }
                                            });
                                        });
                                        optionCounter++;
                                    });
                                });
                            }

                            function generateAllPossibleCombinations(arrays) {
                                const results = [];

                                // Generate combinations of different lengths
                                for (let i = 2; i <= arrays.length; i++) {
                                    // Get all possible combinations of i arrays
                                    const arrayCombinations = getCombinations(arrays, i);

                                    // For each combination of arrays, generate the product
                                    arrayCombinations.forEach(arraySet => {
                                        const combinations = generateCombinations(arraySet);
                                        results.push(...combinations);
                                    });
                                }

                                return results;
                            }

                            function getCombinations(arr, len) {
                                const combinations = [];

                                function backtrack(start, curr) {
                                    if (curr.length === len) {
                                        combinations.push([...curr]);
                                        return;
                                    }

                                    for (let i = start; i < arr.length; i++) {
                                        curr.push(arr[i]);
                                        backtrack(i + 1, curr);
                                        curr.pop();
                                    }
                                }

                                backtrack(0, []);
                                return combinations;
                            }

                            function generateCombinations(arrays) {
                                if (arrays.length === 0) return [];
                                if (arrays.length === 1) return arrays[0];

                                return arrays.reduce((acc, curr) => {
                                    if (acc.length === 0) return curr;

                                    const combinations = [];
                                    acc.forEach(a => {
                                        curr.forEach(b => {
                                            combinations.push(`${a}_${b}`);
                                        });
                                    });
                                    return combinations;
                                });
                            }

                            function getCombinationAttributes(combination) {
                                const names = combination.split('_');
                                const attributes = [];

                                selectedOptions.forEach((options, attributeId) => {
                                    options.forEach(option => {
                                        if (names.includes(option.name)) {
                                            attributes.push({
                                                attributeId: parseInt(attributeId),
                                                optionId: parseInt(option.id),
                                                optionName: option.name
                                            });
                                        }
                                    });
                                });

                                return attributes;
                            }

                            function updateCombinationsDisplay() {
                                const displayArea = document.querySelector('#combinationsTable tbody');
                                displayArea.innerHTML = '';
                                combinationCounter = 0;

                                if (Object.keys(selectedAttributes).length < 2) return;

                                const attributeArrays = Object.values(selectedAttributes);
                                const combinations = generateAllPossibleCombinations(attributeArrays);

                                combinations.forEach((combination) => {
                                    const row = document.createElement('tr');
                                    const attributes = getCombinationAttributes(combination);
                                    const combinationId = attributes.map(attr => attr.optionId).join('_');

                                    row.innerHTML = `
                <td>
                    <div class="form-check">
                        <input class="form-check-input combination-checkbox"
                            type="checkbox"
                            name="combinations[${combinationCounter}][selected]"
                            value="1">
                        <input type="hidden"
                            name="combinations[${combinationCounter}][combinationName]"
                            value="${combination}"
                            disabled>
                        <input type="hidden"
                            name="combinations[${combinationCounter}][combination_id]"
                            value="${combinationId}"
                            disabled>
                        <input type="hidden"
                            name="combinations[${combinationCounter}][attributes]"
                            value='${JSON.stringify(attributes)}'
                            disabled>
                        <label class="form-check-label">
                            ${combination}
                        </label>
                    </div>
                </td>
                <td>
                    <input type="number" class="form-control"
                        name="combinations[${combinationCounter}][price]"
                        placeholder="Price"
                        disabled>
                </td>
                <td>
                    <input type="number" class="form-control"
                        name="combinations[${combinationCounter}][quantity]"
                        placeholder="Quantity"
                        disabled>
                </td>
            `;
                                    displayArea.appendChild(row);

                                    const checkbox = row.querySelector('.combination-checkbox');
                                    const inputs = row.querySelectorAll('input');
                                    checkbox.addEventListener('change', function(e) {
                                        inputs.forEach(input => {
                                            if (input !== checkbox) {
                                                input.disabled = !e.target.checked;
                                                if (!e.target.checked && input.type === 'number') {
                                                    input.value = '';
                                                }
                                            }
                                        });
                                    });
                                    combinationCounter++;
                                });
                            }

                            // Add form submit handler to process data before submission
                            const form = document.getElementById('attributeForm');
                            if (form) {
                                form.addEventListener('submit', function(e) {
                                    e.preventDefault();

                                    const formData = new FormData(form);
                                    const processedData = {
                                        singleOptions: [],
                                        combinations: []
                                    };

                                    // Process single options
                                    const singleOptions = {};
                                    for (let [key, value] of formData.entries()) {
                                        if (key.startsWith('singleOptions[')) {
                                            const matches = key.match(/singleOptions\[(\d+)\]\[(\w+)\]/);
                                            if (matches) {
                                                const index = matches[1];
                                                const field = matches[2];
                                                if (!singleOptions[index]) {
                                                    singleOptions[index] = {};
                                                }
                                                singleOptions[index][field] = value;
                                            }
                                        }
                                    }

                                    // Process combinations
                                    const combinations = {};
                                    for (let [key, value] of formData.entries()) {
                                        if (key.startsWith('combinations[')) {
                                            const matches = key.match(/combinations\[(\d+)\]\[(\w+)\]/);
                                            if (matches) {
                                                const index = matches[1];
                                                const field = matches[2];
                                                if (!combinations[index]) {
                                                    combinations[index] = {};
                                                }
                                                combinations[index][field] = value;
                                            }
                                        }
                                    }

                                    // Convert to arrays and filter out unselected items
                                    processedData.singleOptions = Object.values(singleOptions)
                                        .filter(option => option.selected)
                                        .map(option => ({
                                            attributeName: option.attributeName,
                                            attributeId: option.attributeId,
                                            optionId: option.optionId,
                                            optionName: option.optionName,
                                            price: option.price,
                                            quantity: option.quantity
                                        }));

                                    processedData.combinations = Object.values(combinations)
                                        .filter(combo => combo.selected)
                                        .map(combo => ({
                                            combinationName: combo.combinationName,
                                            combination_id: combo.combination_id,
                                            attributes: combo.attributes,
                                            price: combo.price,
                                            quantity: combo.quantity
                                        }));

                                    // Here you can send the processed data to your server
                                    console.log(processedData);

                                    // Submit the form normally or use fetch/axios to send the data
                                    // form.submit();
                                });
                            }
                        });
                    </script>

                </div>
            </div>
            <div class="col-md-6">

                <div class="card">


                    <div class="card-body">



                        <div class="col-md-12">
                            <label for="stock_option" class="form-label">Select Stock Option
                                <span style="font-weight:bold; color: red">*</span>
                            </label>
                            <select id="stock_option" class="form-select" name="stock_option">
                                <option value="Manual">Manual</option>
                                <option value="From Purchase">From Purchase</option>
                            </select>
                            @error('stock_option')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-12 mt-2" >
                            <label for="quantity" class="form-label">Quantity <span
                                    style="font-weight:bold; color: red">*</span></label>
                            <div class="position-relative">
                                <input type="number" class="form-control quantity_hidden"  name="quantity"
                                    value="{{ old('quantity') ?? 0 }}">
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
                            <label for="price" class="form-label">Price <span
                                    style="font-weight:bold; color: red">*</span> </label>
                            <div class="position-relative">
                                <input type="number" class="form-control" id="price" name="price"
                                    value="{{ old('price') ?? '100' }}">
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
                                    value="{{ old('previous_price') ?? '200' }}">
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
                            <label for="category" class="form-label">Category <span
                                    style="font-weight:bold; color: red">*</span></label>
                            <select id="category" class="form-select" name="category_id">
                                <option selected="">Choose...</option>
                                @foreach ($categories as $item)
                                <option value="{{ $item->id }}" selected>{{ $item->name }}</option>
                                @endforeach

                                @error('category_id')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror





                            </select>
                        </div>

                        <div class="col-md-12 mt-2">
                            <label for="subcategory" class="form-label">Sub Category</label>
                            <select id="subcategory" class="form-select" name="subcategory_id">
                                <option selected="" disabled>Choose...</option>
                            </select>

                            @error('subcategory_id')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror



                        </div>

                        <div class="col-md-12 mt-2">
                            <label for="input19" class="form-label">Brand</label>
                            <select id="input19" class="form-select" name="brand_id">
                                <option selected disabled>Choose...</option>


                                @foreach ($brands as $item)
                                <option value="{{ $item->id }}">{{ $item->company }}</option>
                                @endforeach

                                @error('brand_id')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror




                            </select>
                        </div>

                    </div>

                </div>

                @include('admin.products.imageupload')

                <div class="card">




                    <div class="card-body">
                        <h5 class="mt-2">SEO Information</h5>

                        <div class="col-md-12">
                            <label for="meta_title" class="form-label">Meta Title</label>
                            <input type="text" class="form-control" id="meta_title" name="meta_title"
                                value="{{ old('meta_title') }}">

                            @error('meta_title')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror

                        </div>



                        <div class="col-md-12 mt-2">
                            <label for="meta_description" class="form-label">Meta Description</label>
                            <textarea class="form-control" name="meta_description" id="meta_description" rows="3"> {{ old('meta_description') }} </textarea>

                            @error('meta_description')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror


                        </div>


                    </div>

                </div>


            </div>

            <button type="submit" class="w-100 btn btn-primary" id="submit">Submit</button>

        </div>

    </form>





</div>

@endsection

@push('scripts')
<!-- Summernote JS -->
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.20/dist/summernote-lite.min.js"></script>



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
                            subcategoryDropdown.append(
                                `<option value="${subcategory.id}">${subcategory.name}</option>`
                            );
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



    document.addEventListener('DOMContentLoaded', function() {
    const stockOptionSelect = document.getElementById('stock_option');
    const attributeForm = document.getElementById('attributeForm');
    const quantityInput = document.querySelector('.quantity_hidden');
    stockOptionSelect.addEventListener('change', function() {
        if (stockOptionSelect.value === 'From Purchase') {
            attributeForm.style.display = 'none';
            quantityInput.setAttribute('type', 'hidden');
        } else {
            attributeForm.style.display = 'block';
            quantityInput.setAttribute('type', 'number');
        }
    });
});

</script>
@endpush
