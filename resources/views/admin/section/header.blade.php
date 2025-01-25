<header>
    <div class="topbar d-flex align-items-center">
        <nav class="navbar navbar-expand gap-3">
            <div class="mobile-toggle-menu"><i class='bx bx-menu'></i>
            </div>




            <div class="top-menu ms-auto">
                <ul class="navbar-nav align-items-center gap-1">
                    <li class="nav-item mobile-search-icon d-flex d-lg-none" data-bs-toggle="modal"
                        data-bs-target="#SearchModal">
                        <a class="nav-link" href="avascript:;"><i class='bx bx-search'></i>
                        </a>
                    </li>


                    <li class="nav-item dropdown dropdown-laungauge d-none d-sm-flex visually-hidden">
                        <a class="nav-link dropdown-toggle dropdown-toggle-nocaret" href="avascript:;"
                            data-bs-toggle="dropdown"><img src="{{asset('assets/images/county/02.png')}}" width="22" alt="">
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><a class="dropdown-item d-flex align-items-center py-2" href="javascript:;"><img
                                        src="{{asset('assets/images/county/01.png')}}" width="20" alt=""><span
                                        class="ms-2">English</span></a>
                            </li>

                        </ul>
                    </li>

       
                    <li class="nav-item d-none d-sm-flex">
                        <a href="{{env('FRONTEND')}}" class="btn btn-sm btn-primary">Visit Website</a>
                    </li>


                    <li class="nav-item dark-mode d-none d-sm-flex" onclick="toggleDarkMode()">
                        <a class="nav-link dark-mode-icon" href="javascript:;"><i class='bx bx-moon'></i>
                        </a>
                    </li>

                    <li class="nav-item dropdown dropdown-app visually-hidden">
                        <a class="nav-link dropdown-toggle dropdown-toggle-nocaret" data-bs-toggle="dropdown"
                            href="javascript:;"><i class='bx bx-grid-alt'></i></a>
                        <div class="dropdown-menu dropdown-menu-end p-0">
                            <div class="app-container p-2 my-2">
                                <div class="row gx-0 gy-2 row-cols-3 justify-content-center p-2">
                                    <div class="col">
                                        <a href="javascript:;">
                                            <div class="app-box text-center">
                                                <div class="app-icon">
                                                    <img src="{{asset('assets/images/app/slack.png')}}" width="30"
                                                        alt="">
                                                </div>
                                                <div class="app-name">
                                                    <p class="mb-0 mt-1">Slack</p>
                                                </div>
                                            </div>
                                        </a>
                                    </div>

                                </div>
                                <!--end row-->

                            </div>
                        </div>
                    </li>
      


<li class="nav-item dropdown dropdown-large">
    <a class="nav-link dropdown-toggle dropdown-toggle-nocaret position-relative" href="#" data-bs-toggle="dropdown">
        <span class="alert-count" id="notification-count">0</span>
        <i class='bx bx-bell'></i>
    </a>
    <div class="dropdown-menu dropdown-menu-end">
        <a href="javascript:;">
            <div class="msg-header">
                <p class="msg-header-title">Notifications</p>
                <p class="msg-header-badge" id="notification-badge">0 New</p>
             
            </div>
        </a>
        <div id="notifications-container" class="header-notifications-list">
            <!-- Notifications will be dynamically added here -->
        </div>
        <a href="javascript:;">
            <div class="text-center msg-footer">
                <button class="btn btn-danger w-100" onclick="destroylastten()">Delete Last 10 Notifications</button>
            </div>
        </a>
    </div>
</li>


                    <li class="nav-item dropdown dropdown-large visually-hidden">
                        <a class="nav-link dropdown-toggle dropdown-toggle-nocaret position-relative" href="#"
                            role="button" data-bs-toggle="dropdown" aria-expanded="false"> <span
                                class="alert-count">8</span>
                            <i class='bx bx-shopping-bag'></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-end">
                            <a href="javascript:;">
                                <div class="msg-header">
                                    <p class="msg-header-title">My Cart</p>
                                    <p class="msg-header-badge">10 Items</p>
                                </div>
                            </a>
                            <div class="header-message-list">

                                <a class="dropdown-item" href="javascript:;">
                                    <div class="d-flex align-items-center gap-3">
                                        <div class="position-relative">
                                            <div class="cart-product rounded-circle bg-light">
                                                <img src="{{asset('assets/images/products/11.png')}}" class=""
                                                    alt="product image">
                                            </div>
                                        </div>
                                        <div class="flex-grow-1">
                                            <h6 class="cart-product-title mb-0">Men White T-Shirt</h6>
                                            <p class="cart-product-price mb-0">1 X $29.00</p>
                                        </div>
                                        <div class="">
                                            <p class="cart-price mb-0">$250</p>
                                        </div>
                                        <div class="cart-product-cancel"><i class="bx bx-x"></i>
                                        </div>
                                    </div>
                                </a>

                            </div>
                            <a href="javascript:;">
                                <div class="text-center msg-footer">
                                    <div class="d-flex align-items-center justify-content-between mb-3">
                                        <h5 class="mb-0">Total</h5>
                                        <h5 class="mb-0 ms-auto">$489.00</h5>
                                    </div>
                                    <button class="btn btn-primary w-100">Checkout</button>
                                </div>
                            </a>
                        </div>
                    </li>



                </ul>
            </div>
            <div class="user-box dropdown px-3">
                <a class="d-flex align-items-center nav-link dropdown-toggle gap-3 dropdown-toggle-nocaret" href="#"
                    role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    @if(auth()->user()->image)
                    <img src="{{asset(auth()->user()->image)}}" class="user-img" alt="user avatar">
                    @else 
                    <img src="@avatar(auth()->user()->image, auth()->user()->name)" width="50" height="50" />

                    @endif
                    <div class="user-info">
                        <p class="user-name mb-0">{{auth()->user()->name}}</p>
                       
                    </div>
                </a>
                <ul class="dropdown-menu dropdown-menu-end">
                    <li><a class="dropdown-item d-flex align-items-center" href="{{route('profileSetting')}}"><i
                                class="bx bx-user fs-5"></i><span>Profile</span></a>
                    </li>



                    <li>
                        <div class="dropdown-divider mb-0"></div>
                    </li>
                    <li>
                        <a class="dropdown-item d-flex align-items-center" href="javascript:;"
                            onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            <i class="bx bx-log-out-circle"></i>
                            <span>
                                Logout
                            </span>

                            <!-- Hidden Logout Form -->
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>

                        </a>
                    </li>
                </ul>
            </div>
        </nav>
    </div>
</header>

@push('scripts')
<script>
   


// Function to toggle dark mode
function toggleDarkMode() {
    const isDarkMode = localStorage.getItem('dark-mode') === 'true';

    if (isDarkMode) {
        // Switch to light mode
        localStorage.setItem('dark-mode', 'false');
        document.body.classList.remove('dark');
        document.querySelector("html").classList.remove('dark-theme');
        document.querySelector("html").setAttribute('data-theme', 'light');
    } else {
        // Switch to dark mode
        localStorage.setItem('dark-mode', 'true');
        document.body.classList.add('dark');
        document.querySelector("html").classList.add('dark-theme');
        document.querySelector("html").setAttribute('data-theme', 'dark');
    }

    // Reload the page to apply changes
    window.location.reload();
}

// On page load, set the initial theme based on localStorage
(function initializeTheme() {
    const isDarkMode = localStorage.getItem('dark-mode') === 'true';

    if (isDarkMode) {
        // Apply dark mode settings
        document.body.classList.add('dark');
        document.querySelector("html").classList.add('dark-theme');
        document.querySelector("html").setAttribute('data-theme', 'dark');
    } else {
        // Apply light mode settings
        document.body.classList.remove('dark');
        document.querySelector("html").classList.remove('dark-theme');
        document.querySelector("html").setAttribute('data-theme', 'light');
    }
})();

async function fetchUnreadNotifications() {
    try {
        const response = await fetch('/notifications/unread', {
            headers: {
                'Authorization': `Bearer ${document.querySelector('meta[name="csrf-token"]').content}`,
            },
        });

        if (response.ok) {
            const notifications = await response.json();
            updateNotificationsUI(notifications);
        } else {
            console.error('Failed to fetch notifications');
        }
    } catch (error) {
        console.error('Error:', error);
    }
}

async function deleteNotification(notificationId) {
    try {
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        const response = await fetch(`/notifications/${notificationId}`, {
            method: 'DELETE',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken, // Add CSRF token here
                'Authorization': `Bearer ${csrfToken}`, // Optional, if you use token-based auth
            },
        });

        if (response.ok) {
            // Re-fetch notifications to update the UI
            fetchUnreadNotifications();
        } else {
            console.error('Failed to delete notification');
        }
    } catch (error) {
        console.error('Error:', error);
    }
}
async function destroylastten() {
    try {
       
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        const response = await fetch('/notifications/destroylastten', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken,
            },
        });

        if (response.ok) {
            // Re-fetch notifications to update the UI
            fetchUnreadNotifications();
        } else {
            const errorData = await response.json();
            console.error('Error:', errorData.message);
        }
    } catch (error) {
        console.error('Error:', error);
    }
}



async function markNotificationAsRead(notificationId) {
    try {
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        const response = await fetch(`/notifications/${notificationId}/mark-as-read`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken,
                'Authorization': `Bearer ${csrfToken}`,
            },
        });

        if (response.ok) {
            // Re-fetch notifications to update the UI
            fetchUnreadNotifications();
            
            // You can also update the specific notification UI without re-fetching
            const notificationElement = document.querySelector(`[data-notification-id="${notificationId}"]`);
            if (notificationElement) {
                notificationElement.classList.add('read');
                // Optional: Update the styling for read notifications
                notificationElement.style.backgroundColor = '#f8f9fa';
                notificationElement.style.opacity = '0.7';
            }
        } else {
            console.error('Failed to mark notification as read');
        }
    } catch (error) {
        console.error('Error:', error);
    }
}

// Update the updateNotificationsUI function to include the mark as read button
function updateNotificationsUI(notifications) {
    const container = document.getElementById('notifications-container');
    const alertCount = document.getElementById('notification-count');
    const alertBadge = document.getElementById('notification-badge');
    container.innerHTML = ''; // Clear existing notifications

    if (notifications.length > 0) {
        alertCount.textContent = notifications.length;
        alertBadge.textContent = `${notifications.length} New`;

        notifications.forEach(notification => {
            const timeAgo = timeSince(new Date(notification.created_at));
            let link = "#";

            if (notification.notification_type === 'Order') {
                link = `{{route('admin.orders.index')}}/${notification.related_id}/invoice`;
            } else if (notification.notification_type === 'StockOut') {
                link = `{{route('products.index')}}/${notification.related_id}/edit`;
            }
           
            const notificationItem = `<div class="dropdown-item d-flex align-items-center" data-notification-id="${notification.id}"  onclick="markNotificationAsRead(${notification.id})">
                <a href='${link}' class="flex-grow-1">
                    <div>
                        <h6 class="msg-name text-wrap"><span>${notification.notification_type}</span> 
                            <span class="msg-time float-end text-muted">${timeAgo}</span>
                        </h6>
                        <p class="msg-info text-break">${notification.message}</p>
                    </div>
                </a>
                <div class="d-flex gap-2">
                   
                    <button class="btn btn-danger btn-sm" onclick="deleteNotification(${notification.id})">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash3-fill" viewBox="0 0 16 16">
                            <path d="M11 1.5v1h3.5a.5.5 0 0 1 0 1h-.538l-.853 10.66A2 2 0 0 1 11.115 16h-6.23a2 2 0 0 1-1.994-1.84L2.038 3.5H1.5a.5.5 0 0 1 0-1H5v-1A1.5 1.5 0 0 1 6.5 0h3A1.5 1.5 0 0 1 11 1.5m-5 0v1h4v-1a.5.5 0 0 0-.5-.5h-3a.5.5 0 0 0-.5.5M4.5 5.029l.5 8.5a.5.5 0 1 0 .998-.06l-.5-8.5a.5.5 0 1 0-.998.06m6.53-.528a.5.5 0 0 0-.528.47l-.5 8.5a.5.5 0 0 0 .998.058l.5-8.5a.5.5 0 0 0-.47-.528M8 4.5a.5.5 0 0 0-.5.5v8.5a.5.5 0 0 0 1 0V5a.5.5 0 0 0-.5-.5"></path>
                        </svg>
                    </button>
                </div>
            </div>`;

            container.insertAdjacentHTML('beforeend', notificationItem);
        });
    } else {
        alertCount.textContent = '0';
        container.innerHTML = '<p class="text-center">No new notifications</p>';
    }
}

// Function to calculate time ago
function timeSince(date) {
    const now = new Date();
    const seconds = Math.floor((now - date) / 1000);
    const minutes = Math.floor(seconds / 60);
    const hours = Math.floor(minutes / 60);
    const days = Math.floor(hours / 24);

    if (seconds < 60) return `${seconds} sec ago`;
    if (minutes < 60) return `${minutes} min ago`;
    if (hours < 24) return `${hours} hour ago`;
    return `${days} day ago`;
}

// Initial fetch for notifications
fetchUnreadNotifications();

// Fetch new notifications every 60 seconds (optional)
setInterval(fetchUnreadNotifications, 60000);


    </script>