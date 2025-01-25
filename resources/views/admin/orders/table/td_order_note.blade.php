<!-- Order Note Cell -->
<td style="width: 10% ;text-align:center" class="text-wrap">
    <span class="badge px-3" style="font-weight: 200;color:black;text-align:center" 
          id="note{{ $order->id }}">   {{ Str::limit($order->note, 10, '...') }} </span>
    <div class="text-center">
        <button type="button" style="margin:auto" class="btn btn-dark btn-sm note-edit-btn" 
                data-bs-toggle="modal" data-bs-target="#ordernote_{{ $order->id }}" 
                data-order-id="{{ $order->id }}">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                class="bi bi-pencil-square" viewBox="0 0 16 16">
                <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
                <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5z"/>
            </svg>
        </button>
    </div>

<!-- Order Note Modal -->
<div class="modal fade" id="ordernote_{{ $order->id }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Order Note</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="orderNoteForm_{{ $order->id }}" method="post">
                @csrf
                <div id="orderNoteSuccessMessage_{{ $order->id }}" class="alert alert-success d-none"></div>
                <div class="modal-body">
                    <input type="hidden" name="order_id" value="{{ $order->id }}">
                    <div class="mb-3">
                        <textarea name="note" class="form-control" id="noteText_{{ $order->id }}" 
                                cols="30" rows="5" placeholder="Enter your note here">{{ $order->note }}</textarea>
                        <div id="noteError_{{ $order->id }}" class="invalid-feedback"></div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary btn-sm" id="submitButton_{{ $order->id }}">{{ $order->note ? 'update' : 'save' }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('orderNoteForm_{{ $order->id }}');
    let isSubmitting = false; // Flag to prevent multiple submissions

    function displaySuccessMessage(orderId, message) {
        const container = document.getElementById(`orderNoteSuccessMessage_${orderId}`);
        if (container) {
            container.textContent = message;
            container.classList.remove('d-none');
            setTimeout(() => {
                container.classList.add('d-none');
            }, 3000);
        }
    }

    function updateNoteDisplay(orderId, noteText) {
        const noteElement = document.getElementById(`note${orderId}`);
        if (noteElement) {
            noteElement.innerText = noteText.substring(0, 10) || '';
        }
    }

    if (form) {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            
            // Prevent multiple submissions
            if (isSubmitting) {
                return;
            }

            isSubmitting = true;
            const orderId = this.querySelector('input[name="order_id"]').value;
            const submitButton = document.getElementById(`submitButton_${orderId}`);
            submitButton.disabled = true;
            
            const formData = new FormData(this);

            fetch("{{ route('admin.orders.ordernote') }}", {
                method: "POST",
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    displaySuccessMessage(orderId, 'Note saved successfully!');
                    updateNoteDisplay(orderId, formData.get('note'));
                    
                    // Clear error states
                    const noteTextElement = form.querySelector(`#noteText_${orderId}`);
                    const noteErrorElement = form.querySelector(`#noteError_${orderId}`);
                    if (noteTextElement) noteTextElement.classList.remove('is-invalid');
                    if (noteErrorElement) noteErrorElement.textContent = '';
                    
                    // Close modal
                    const modalElement = document.getElementById(`ordernote_${orderId}`);
                    if (modalElement) {
                        const modal = bootstrap.Modal.getInstance(modalElement);
                        if (modal) modal.hide();
                    }
                } else {
                    const noteErrorElement = form.querySelector(`#noteError_${orderId}`);
                    const noteTextElement = form.querySelector(`#noteText_${orderId}`);
                    if (noteErrorElement) {
                        noteErrorElement.textContent = data.errors?.note || 'An error occurred';
                    }
                    if (noteTextElement) {
                        noteTextElement.classList.add('is-invalid');
                    }
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('An error occurred while saving the note');
            })
            .finally(() => {
                isSubmitting = false;
                submitButton.disabled = false;
            });
        });

        // Prevent default form submission on enter key
        const textarea = form.querySelector('textarea[name="note"]');
        if (textarea) {
            textarea.addEventListener('keypress', function(e) {
                if (e.key === 'Enter' && !e.shiftKey) {
                    e.preventDefault();
                }
            });
        }
    }
});
</script>

</td>