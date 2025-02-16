@extends('admin.layout')
@section('css')


<style>

    table td{
        /* border: 1px solid lightgray; */
    }

    table th{
        /* border: 1px solid lightgray; */
    }

    @media (max-width: 767px){
        .container-fluid, .container-sm, .container-md, .container-lg, .container-xl, .container-xxl {

            overflow: scroll!important;
        }
    }


    .dataTables_filter{
        display: none!important;
    }


</style>
@endsection

@section('content')
    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
            <h4 class="text-themecolor">(#{{$data->id}})
            </h4>
        </div>
        <div class="col-md-7 align-self-center text-end">
            <div class="d-flex justify-content-end align-items-center">
                <ol class="breadcrumb justify-content-end">
                    <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                    <li class="breadcrumb-item active">Orders</li>
                </ol>
            </div>
        </div>
    </div>
    <div style="display: flex; gap: 10px;">
        <!-- 30% Section for Product Information -->
        <div style="width: 30%; padding: 10px; border: 1px solid #ccc; border-radius: 8px;">
            <h3>Product Information</h3>
            <div style="text-align: center; margin-bottom: 10px;">
                <img src="{{ asset($data->product->get_thumbnail->path) ?? asset('placeholder.jpg') }}" alt="Product Image" style="width: 100%; max-width: 200px; height: auto; border-radius: 8px;">
            </div>
            <p><strong>Product Name:</strong> {{ $data->product->title ?? 'N/A' }}</p>
            <p><strong>Price:</strong> {{ $data->product->selling_price ?? 'N/A' }}</p>
            <p><strong>Description:</strong> {!! $data->product->description ?? 'N/A' !!}</p>

            <hr style="margin: 15px 0; border: 0; border-top: 1px solid #ddd;">

            <h3>User Information</h3>
            @if ($data->user)
                <p><strong>Name:</strong> {{ $data->user->name ?? 'N/A' }}</p>
                <p><strong>Email:</strong> {{ $data->user->email ?? 'N/A' }}</p>
                <p><strong>Phone:</strong> {{ $data->user->phone ?? 'N/A' }}</p>
                <p><strong>Address:</strong> {{ $data->user->address ?? 'N/A' }}</p>
            @else
                <p>No user information found.</p>
            @endif
        </div>


        <!-- 70% Section for Order Details -->
        <div style="width: 70%; padding: 10px; border: 1px solid #ccc; border-radius: 8px;">
            <h3>Edit Order</h3>
            <form method="POST" action="{{ route('admin.orders.update', Crypt::encryptString($data->id)) }}">
                @csrf
                @method('PUT')
                <div style="display: flex; gap: 10px; margin-bottom: 10px;">
                    <div style="flex: 1;">
                        <label for="buyer_name" style="display: block; margin-bottom: 5px;">Buyer Name</label>
                        <input type="text" id="buyer_name" name="buyer_name" value="{{ $data->buyer_name }}" style="width: 100%; padding: 8px; border: 1px solid #ccc; border-radius: 4px;">
                    </div>
                    <div style="flex: 1;">
                        <label for="buyer_email" style="display: block; margin-bottom: 5px;">Buyer Email</label>
                        <input type="email" id="buyer_email" name="buyer_email" value="{{ $data->buyer_email }}" style="width: 100%; padding: 8px; border: 1px solid #ccc; border-radius: 4px;">
                    </div>
                </div>
                <div style="display: flex; gap: 10px; margin-bottom: 10px;">
                    <div style="flex: 1;">
                        <label for="passport" style="display: block; margin-bottom: 5px;">Passport</label>
                        <input type="text" id="passport" name="passport" value="{{ $data->passport }}" style="width: 100%; padding: 8px; border: 1px solid #ccc; border-radius: 4px;">
                    </div>
                    <div style="flex: 1;">
                        <label for="license" style="display: block; margin-bottom: 5px;">License</label>
                        <input type="text" id="license" name="license" value="{{ $data->license }}" style="width: 100%; padding: 8px; border: 1px solid #ccc; border-radius: 4px;">
                    </div>
                </div>
                <div style="display: flex; gap: 10px; margin-bottom: 10px;">
                    <div style="flex: 1;">
                        <label for="buyer_phone_number" style="display: block; margin-bottom: 5px;">Phone Number</label>
                        <input type="text" id="buyer_phone_number" name="buyer_phone_number" value="{{ $data->buyer_phone_number }}" style="width: 100%; padding: 8px; border: 1px solid #ccc; border-radius: 4px;">
                    </div>
                    <div style="flex: 1;">
                        <label for="buyer_country_of_origin" style="display: block; margin-bottom: 5px;">Country of Origin</label>
                        <input type="text" id="buyer_country_of_origin" name="buyer_country_of_origin" value="{{ $data->buyer_country_of_origin }}" style="width: 100%; padding: 8px; border: 1px solid #ccc; border-radius: 4px;">
                    </div>
                </div>
                <div style="display: flex; gap: 10px; margin-bottom: 10px;">
                    <div style="flex: 1;">
                        <label for="buyer_sec_name" style="display: block; margin-bottom: 5px;">Secondary Name</label>
                        <input type="text" id="buyer_sec_name" name="buyer_sec_name" value="{{ $data->buyer_sec_name }}" style="width: 100%; padding: 8px; border: 1px solid #ccc; border-radius: 4px;">
                    </div>
                    <div style="flex: 1;">
                        <label for="buyer_sec_phone_number" style="display: block; margin-bottom: 5px;">Secondary Phone</label>
                        <input type="text" id="buyer_sec_phone_number" name="buyer_sec_phone_number" value="{{ $data->buyer_sec_phone_number }}" style="width: 100%; padding: 8px; border: 1px solid #ccc; border-radius: 4px;">
                    </div>
                </div>
                <div style="display: flex; gap: 10px; margin-bottom: 10px;">
                    <div style="flex: 1;">
                        <label for="driver_name" style="display: block; margin-bottom: 5px;">Driver Name</label>
                        <input type="text" id="driver_name" name="driver_name" value="{{ $data->driver_name }}" style="width: 100%; padding: 8px; border: 1px solid #ccc; border-radius: 4px;">
                    </div>
                    <div style="flex: 1;">
                        <label for="driver_license_number" style="display: block; margin-bottom: 5px;">Driver License</label>
                        <input type="text" id="driver_license_number" name="driver_license_number" value="{{ $data->driver_license_number }}" style="width: 100%; padding: 8px; border: 1px solid #ccc; border-radius: 4px;">
                    </div>
                </div>
                <div style="display: flex; gap: 10px; margin-bottom: 10px;">
                    <div style="flex: 1;">
                        <label for="from_date" style="display: block; margin-bottom: 5px;">From Date & Time</label>
                        <input type="datetime-local" id="from_date" name="from_date"
                               value="{{ $data->from_date ? date('Y-m-d\TH:i', strtotime($data->from_date)) : '' }}"
                               style="width: 100%; padding: 8px; border: 1px solid #ccc; border-radius: 4px;">
                    </div>
                    <div style="flex: 1;">
                        <label for="to_date" style="display: block; margin-bottom: 5px;">To Date & Time</label>
                        <input type="datetime-local" id="to_date" name="to_date"
                               value="{{ $data->to_date ? date('Y-m-d\TH:i', strtotime($data->to_date)) : '' }}"
                               style="width: 100%; padding: 8px; border: 1px solid #ccc; border-radius: 4px;">
                    </div>
                </div>

                <div style="display: flex; gap: 10px; margin-bottom: 10px;">
                    <div style="flex: 1;">
                        <label for="status" style="display: block; margin-bottom: 5px;">Status</label>
                        <select id="status" name="status" style="width: 100%; padding: 8px; border: 1px solid #ccc; border-radius: 4px;">
                            <option value="pending" {{ $data->status == 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="confirmed" {{ $data->status == 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                            <option value="cancelled" {{ $data->status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                        </select>
                    </div>
                    <div style="flex: 1;">
                        <label for="payment_status" style="display: block; margin-bottom: 5px;">Payment Status</label>
                        <select id="payment_status" name="payment_status" style="width: 100%; padding: 8px; border: 1px solid #ccc; border-radius: 4px;">
                            <option value="0" {{ $data->payment_status == 0 ? 'selected' : '' }}>Unpaid</option>
                            <option value="1" {{ $data->payment_status == 1 ? 'selected' : '' }}>Paid</option>
                        </select>
                    </div>
                </div>
                <div style="display: flex; gap: 10px; margin-bottom: 10px;">
                    <div style="flex: 1;">
                        <label for="amount" style="display: block; margin-bottom: 5px;">Amount</label>
                        <input type="text" id="amount" name="amount" value="{{ $data->amount }}" style="width: 100%; padding: 8px; border: 1px solid #ccc; border-radius: 4px;">
                    </div>
                    <div style="flex: 1;">
                        <label for="flight_no" style="display: block; margin-bottom: 5px;">Flight Number</label>
                        <input type="text" id="flight_no" name="flight_no" value="{{ $data->flight_no }}" style="width: 100%; padding: 8px; border: 1px solid #ccc; border-radius: 4px;">
                    </div>
                </div>
                <button type="submit" style="padding: 10px 15px; background-color: #28a745; color: #fff; border: none; border-radius: 4px;">Update Order</button>
            </form>

        </div>
    </div>

@endsection
 @section('js')


       <script>
        $(function () {


         });
    </script>
@endsection
