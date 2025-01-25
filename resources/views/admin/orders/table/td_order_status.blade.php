<td style="width: 10%" class="text-wrap">
                                        <style>
                                            .status-select-container {
                                                position: relative;
                                                width: 100%;
                                                font-family: system-ui, -apple-system, sans-serif;
                                            }

                                            .status-select {
                                                appearance: none;
                                                width: 100%;
                                                padding: 0.625rem 2rem 0.625rem 1rem;
                                                font-size: 0.875rem;
                                                line-height: 1.5;
                                                border-radius: 0.5rem;
                                                border: 1px solid #e2e8f0;
                                                background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='24' height='24' viewBox='0 0 24 24' fill='none' stroke='currentColor' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpolyline points='6 9 12 15 18 9'%3E%3C/polyline%3E%3C/svg%3E");
                                                background-repeat: no-repeat;
                                                background-position: right 0.5rem center;
                                                background-size: 1.2em;
                                                cursor: pointer;
                                                transition: all 0.2s ease;
                                                font-weight: 500;
                                            }

                                            .status-select:focus {
                                                outline: none;
                                                box-shadow: 0 0 0 3px rgba(66, 153, 225, 0.15);
                                            }

                                            /* Softer, more professional colors */
                                            #orderStatus {
                                                background-color: #f7f7f7;
                                            }

                                            /* Status-specific styles with softer colors */
                                            #orderStatus option[value="pending"] {
                                                background-color: #FFF8E6;
                                                color: #916800;
                                            }

                                            #orderStatus option[value="processed"] {
                                                background-color: #FFF1E7;
                                                color: #6d2c00;
                                            }

                                            #orderStatus option[value="shipped"] {
                                                background-color: #E6F6F4;
                                                color: #0F766E;
                                            }

                                            #orderStatus option[value="delivered"] {
                                                background-color: #ECFDF5;
                                                color: #003013;
                                            }

                                            #orderStatus option[value="cancelled"] {
                                                background-color: #FEE2E2;
                                                color: #991B1B;
                                            }

                                            #orderStatus option[value="returned"] {
                                                background-color: #EFF6FF;
                                                color: #1E40AF;
                                            }

                                            #orderStatus option[value="on delivery"] {
                                                background-color: #EEF2FF;
                                                color: #07006d;
                                            }

                                            #orderStatus option[value="pending delivery"] {
                                                background-color: #F5F3FF;
                                                color: #5B21B6;
                                            }

                                            #orderStatus option[value="incomplete"] {
                                                background-color: #FDF2F8;
                                                color: #9D174D;
                                            }

                                            .status-badge {
                                                display: inline-flex;
                                                align-items: center;
                                                padding: 0.375rem 0.75rem;
                                                border-radius: 0.375rem;
                                                font-weight: 500;
                                                font-size: 0.875rem;
                                                line-height: 1.25;
                                            }

                                            .status-select:hover {
                                                border-color: #CBD5E0;
                                                background-color: inherit;
                                                /* Maintain current background color */
                                                color: inherit;
                                                /* Maintain current text color */
                                            }
                                        </style>

                                        <div class="status-select-container">
                                            <select class="status-select" data-order-id="{{ $order->id }}"
                                                name="order_status" aria-label="Update Order Status">
                                                <option value="pending"
                                                    style="background-color: #FFF8E6; color: #916800;"
                                                    {{ $order->order_status == 'pending' ? 'selected' : '' }}>
                                                    Pending</option>
                                                <option value="processed"
                                                    style="background-color: #FFF1E7; color: #C54E00;"
                                                    {{ $order->order_status == 'processed' ? 'selected' : '' }}>
                                                    Processed</option>
                                                <option value="shipped"
                                                    style="background-color: #E6F6F4; color: #0F766E;"
                                                    {{ $order->order_status == 'shipped' ? 'selected' : '' }}>
                                                    Shipped</option>
                                                <option value="delivered"
                                                    style="background-color: #ECFDF5; color: #166534;"
                                                    {{ $order->order_status == 'delivered' ? 'selected' : '' }}>
                                                    Delivered</option>
                                                <option value="cancelled"
                                                    style="background-color: #FEE2E2; color: #991B1B;"
                                                    {{ $order->order_status == 'cancelled' ? 'selected' : '' }}>
                                                    Cancelled</option>
                                                <option value="returned"
                                                    style="background-color: #EFF6FF; color: #1E40AF;"
                                                    {{ $order->order_status == 'returned' ? 'selected' : '' }}>
                                                    Returned</option>
                                                <option value="on delivery"
                                                    style="background-color: #EEF2FF; color: #3730A3;"
                                                    {{ $order->order_status == 'on delivery' ? 'selected' : '' }}>
                                                    On Delivery</option>
                                                <option value="pending delivery"
                                                    style="background-color: #F5F3FF; color: #5B21B6;"
                                                    {{ $order->order_status == 'pending delivery' ? 'selected' : '' }}>
                                                    Pending Delivery</option>
                                                <option value="incomplete"
                                                    style="background-color: #FDF2F8; color: #9D174D;"
                                                    {{ $order->order_status == 'incomplete' ? 'selected' : '' }}>
                                                    Incomplete</option>
                                            </select>
                                        </div>


                                        <script>
                                            document.addEventListener('DOMContentLoaded', function() {
                                                // Find all status select elements
                                                const statusSelects = document.querySelectorAll('.status-select');

                                                statusSelects.forEach(select => {
                                                    // Apply initial styles for the selected option
                                                    applyStyles(select);

                                                    // Add change event listener to each select
                                                    select.addEventListener('change', function() {
                                                        const orderId = this.getAttribute('data-order-id');
                                                        handleStatusChange(this, orderId);
                                                        applyStyles(this);
                                                    });
                                                });

                                                function applyStyles(select) {
                                                    const selectedOption = select.options[select.selectedIndex];
                                                    select.style.backgroundColor = selectedOption.style.backgroundColor;
                                                    select.style.color = selectedOption.style.color;
                                                }

                                                function handleStatusChange(select, orderId) {

                                                    // Prevent unnecessary calls and ensure single execution
                                                    if (select.dataset.updating === 'true') return;
                                                    select.dataset.updating = 'true';

                                                    // Show loading state
                                                    select.style.opacity = '0.7';

                                                    fetch('/admin/orders/updatestatus', {
                                                            method: 'POST',
                                                            headers: {
                                                                'Content-Type': 'application/json',
                                                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                                                            },
                                                            body: JSON.stringify({
                                                                order_id: orderId,
                                                                status: select.value
                                                            })
                                                        })
                                                        .then(response => response.json())
                                                        .then(data => {
                                                            select.style.opacity = '1';
                                                            select.dataset.updating = 'false';
                                                            if (!data.success) throw new Error('Update failed');



                                                            showFeedback(select, 'success');
                                                            //swit alert
                                                            Swal.fire({
                                                                position: 'top-end',
                                                                icon: 'success',
                                                                title: 'Your work has been saved',
                                                                showConfirmButton: false,
                                                                timer: 1500
                                                            })

                                                        })
                                                        .catch(error => {
                                                            select.style.opacity = '1';
                                                            select.dataset.updating = 'false';
                                                            console.error('Error updating status:', error);
                                                            showFeedback(select, 'error');
                                                        });
                                                }

                                                function showFeedback(select, type) {
                                                    const container = select.closest('.status-select-container');
                                                    const indicator = document.createElement('div');
                                                    indicator.className = `status-indicator ${type}`;
                                                    indicator.style.cssText = `position: absolute;right: -10px;top: -10px;background-color: ${type === 'success' ? '#34D399' : '#EF4444'};border-radius: 50%;width: 20px;height: 20px;opacity: 0;transition: opacity 0.2s ease;`;

                                                    container.appendChild(indicator);
                                                    requestAnimationFrame(() => (indicator.style.opacity = '1'));

                                                    setTimeout(() => {
                                                        indicator.style.opacity = '0';
                                                        setTimeout(() => indicator.remove(), 200);
                                                    }, 1500);
                                                }
                                            });
                                        </script>


                                    </td>