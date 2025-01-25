@foreach ($stats as $stat)
    @php
        // Assign the status directly to the stat
        if ($stat['title'] === 'Total Orders') {
            $stat['status'] = '';
        } elseif ($stat['title'] === 'Pending Orders') {
            $stat['status'] = 'pending';
        } elseif ($stat['title'] === 'Delivered Orders') {
            $stat['status'] = 'delivered';
        } elseif ($stat['title'] === 'Processed Orders') {
            $stat['status'] = 'processed';
        } elseif ($stat['title'] === 'Returned Orders') {
            $stat['status'] = 'returned';
        } elseif ($stat['title'] === 'On delivery Orders') {
            $stat['status'] = 'shipped';
        } elseif ($stat['title'] === 'Pending delivery Orders') {
            $stat['status'] = 'courier';
            $stat['title'] = 'Courier Orders'; // Change the title here
        } elseif ($stat['title'] === 'Cancelled Orders') {
            $stat['status'] = 'cancelled';
        }
    @endphp

    <div class="col" onclick="window.location='{{ route('admin.orders.index', ['status' => $stat['status']]) }}'">
        <div class="card radius-10 status-card {{ request()->get('status') === $stat['status'] ? 'active' : '' }}" data-status="{{ $stat['status'] }}">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div>
                        <p class="mb-0 text-secondary">{{ $stat['title'] }}</p>
                        <h4 class="my-1">{{ $stat['value'] }}</h4>
                        <p class="mb-0 font-13">
                            <i class="bx {{ $stat['trendIcon'] }} align-middle"></i> {{ $stat['trendText'] }}
                        </p>
                    </div>
                    <div class="widgets-icons rounded-circle text-white ms-auto">
                        @if ($stat['title'] === 'Total Orders')
                            <img src="{{asset('uploads/Total Order.png')}}" style="width:45px;height:45px" />
                        @elseif($stat['title'] === 'Pending Orders')
                            <img src="{{asset('uploads/pending order.png')}}" style="width:45px;height:45px" />
                        @elseif($stat['title'] === 'Delivered Orders')
                            <img src="{{asset('uploads/Delivered Order.png')}}" style="width:45px;height:45px" />
                        @elseif($stat['title'] === 'Processed Orders')
                            <img src="{{asset('uploads/Processed Orders.png')}}" style="width:45px;height:45px" />
                        @elseif($stat['title'] === 'Returned Orders')
                            <img src="{{asset('uploads/return orders.png')}}" style="width:45px;height:45px" />
                        @elseif($stat['title'] === 'On delivery Orders')
                            <img src="{{asset('uploads/On Delivery Order.png')}}" style="width:45px;height:45px" />
                        @elseif($stat['title'] === 'Courier Orders')
                            <img src="{{asset('uploads/pending deliver order.png')}}" style="width:45px;height:45px" />
                        @elseif($stat['title'] === 'Cancelled Orders')
                            <img src="{{asset('uploads/cancelled Order.png')}}" style="width:45px;height:45px" />
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endforeach