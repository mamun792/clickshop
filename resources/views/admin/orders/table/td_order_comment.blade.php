<td style="width: 5%" class="text-wrap">
    <div class="text-center" id="comment{{ $order->id }}">
        @if ($order->comment_id)
            {{ Str::limit($order->comment->name, 10, '...') }}
        @else
            <span>N/A</span>
        @endif
    </div>
    <div class="text-center">
        <button type="button" class="btn btn-dark btn-sm" data-bs-toggle="modal" 
                data-bs-target="#commentModal_{{ $order->id }}" 
                data-order-id="{{ $order->id }}">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                class="bi bi-pencil-square" viewBox="0 0 16 16">
                <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
                <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5z"/>
            </svg>
        </button>
    </div>

    <!-- Comment Modal -->
    <div class="modal fade" id="commentModal_{{ $order->id }}" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Manage Comments</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Add Comment -->
                    <form id="addCommentForm_{{ $order->id }}" method="POST">
                        @csrf
                        <div id="addCommentSuccessMessage_{{ $order->id }}" 
                             class="alert alert-success d-none"></div>
                        <div class="mb-3">
                            <label for="commentName_{{ $order->id }}" class="form-label">Add New Comment</label>
                            <input type="hidden" name="order_id" value="{{ $order->id }}">
                            <input type="text" name="name" class="form-control" id="commentName_{{ $order->id }}" placeholder="Enter comment name">
                            <div id="commentNameError_{{ $order->id }}" class="invalid-feedback"></div>
                        </div>
                        <button type="submit" class="btn btn-primary btn-sm">Add Comment</button>
                    </form>

                    <hr>

                    <!-- Select Comment -->
                    <form id="associateCommentForm_{{ $order->id }}" method="POST">
                        @csrf
                        <div id="associateCommentSuccessMessage_{{ $order->id }}" 
                             class="alert alert-success d-none"></div>
                        <input type="hidden" name="order_id" value="{{ $order->id }}">
                        <div class="mb-3">
                            <label for="commentSelect_{{ $order->id }}" class="form-label">Select Existing Comment</label>
                            <select class="form-select" name="comment_id" id="commentSelect_{{ $order->id }}">
                                <option selected disabled>Select or change a comment</option>
                                @foreach ($comments as $comment)
                                    <option value="{{ $comment->id }}">{{ $comment->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="text-end">
                            <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary btn-sm">Save Changes</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', () => {



            const setupFormHandler = (formId, successMessageId, inputId, route, successCallback) => {
    const form = document.getElementById(formId);
    if (!form) return;

    form.addEventListener('submit', function (e) {
        e.preventDefault();
        const formData = new FormData(this);
        const successMessage = document.getElementById(successMessageId);
        const inputField = document.getElementById(inputId);

        fetch(route, {
            method: "POST",
            headers: {
                "X-CSRF-TOKEN": "{{ csrf_token() }}"
            },
            body: formData
        })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Display the success message
                    successMessage.textContent = data.message;
                    successMessage.classList.remove("d-none");
                    setTimeout(() => successMessage.classList.add("d-none"), 3000);

                    // Call the success callback if provided
                    if (successCallback) successCallback(data);

                } else {
                    throw new Error(data.errors || "An error occurred");
                }
            })
            .catch(error => {
                console.error("Error:", error);
                inputField.classList.add("is-invalid");
            });
    });
};

// Add Comment Form
setupFormHandler(
    "addCommentForm_{{ $order->id }}",
    "addCommentSuccessMessage_{{ $order->id }}",
    "commentName_{{ $order->id }}",
    "{{ route('admin.orders.ordercommentadd') }}",
    (data) => {
    // Update the comment name dynamically
    const commentElement = document.getElementById(`comment{{ $order->id }}`);
    if (commentElement && data.data.length > 0) {
        const lastComment = data.data[data.data.length - 1]; // Get the last added comment
        const truncatedName = lastComment.name.substring(0, 10); // Limit to 10 characters
        commentElement.innerText = truncatedName; // Update the displayed comment name
    }

    // Update the commentSelect dynamically
    const commentSelect = document.getElementById(`commentSelect_{{ $order->id }}`);
    if (commentSelect) {
        // Clear existing options
        commentSelect.innerHTML = "";

        // Add default "Select or change a comment" option
        const defaultOption = document.createElement("option");
        defaultOption.textContent = "Select or change a comment";
        defaultOption.disabled = true;
        defaultOption.selected = true;
        commentSelect.appendChild(defaultOption);

        // Populate the dropdown with new data from data.data
        data.data.forEach((comment) => {
            const option = document.createElement("option");
            option.value = comment.id;
            option.textContent = comment.name;
            commentSelect.appendChild(option);
        });
    }
}

);

// Associate Comment Form
setupFormHandler(
        "associateCommentForm_{{ $order->id }}",
        "associateCommentSuccessMessage_{{ $order->id }}",
        "commentSelect_{{ $order->id }}",
        "{{ route('admin.orders.orderComment') }}",
        () => {
            // Get the selected comment text and update the display
            const commentSelect = document.getElementById(`commentSelect_{{ $order->id }}`);
            const selectedOption = commentSelect.options[commentSelect.selectedIndex];
            const commentElement = document.getElementById(`comment{{ $order->id }}`);

            if (commentElement && selectedOption) {
                commentElement.innerText = selectedOption.textContent;
            }
        }
    );

});

    </script>
</td>
