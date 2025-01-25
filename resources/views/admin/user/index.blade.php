@extends('admin.master')

@section('main-content')
    <div class="page-content">

        <div class="col-lg-12">
            <div class="card container mx-auto">
               
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h5>All Avilable User</h5>
                        </div>
                       
                    </div>
                </div>
                




            </div>

            <div class="card container mx-auto mt-5">
               
                <div class="card-body">
                    <table class="my-table table table-hover table-stripe" id="example">
                        <thead>
                            <th>SL</th>
                            <th>Image</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>View Order</th>
                            
                        </thead>

                        <tbody>
                            @foreach($users as $index=> $item)
                            <tr>
                                <td>{{$index+1}}</td>
                                <td>
                                     
                                    @if(isset($item->image) && $item->image)
                                    <img src="{{ asset($item->image) }}" width="50" height="50" />
                                @else
                                <img src="@avatar($item->image, $item->name)" width="50" height="50" />
                                @endif
                                
                                </td>
                                <td>
                                    {{$item->name}}
                                </td>
                               
                               <td>
                                {{$item->email}}
                                </td> 
                                
                               
                                
                                <td>
                                    {{$item->phone}}
                                </td>

                                <td class="text-center">
                                    <a class="pastel-button pastel-button-rose-sm" href="/admin/orders/filter?customer_name={{ rawurlencode($item->name) }}">View</a>
                                </td>
                               
                            </tr>
                            @endforeach 
                           
                        </tbody>

                    </table>
                </div>
                




            </div>



        </div>
        

    </div>
@endsection

