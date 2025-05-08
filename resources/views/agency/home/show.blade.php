@extends('agency.layouts.app')
@section('title','Show Paymet')
@section('content')

<div class="row">
    <div class="col-lg-12">
        <div>
            <div class="row">
                <div class="col-xl-12">
                    <div class="card">
                        <div class="row no-gutters align-items-center">
                            <div class="col-md-5">
                                
                                            <img src="{{ asset('assets/images/logo/logo.png') }}" style="width:250px;margin: 20px;" class="card-img" alt="...">

                            </div>
                            <div class="col-md-7">
                                <div class="card-body">

                                        <h4 class="header-title"></h4>

                                        <dl class="row mb-0">
                                            <dt class="col-sm-3">{{ __('pages.date_pay') }}</dt>
                                            <dd class="col-sm-9">{{ $payment->created_at }}<br></dd>

                                            <dt class="col-sm-3 text-truncate">{{ __('pages.user') }}</dt>
                                            <dd class="col-sm-9"><a href="{{ route('users.show', ['lang' => app()->getLocale(), 'user' => $payment->user->id]) }}">{{ $payment->user->name }}</a></dd>
                                            <dt class="col-sm-3 text-truncate">{{ __('pages.stripe_payment_id') }}</dt>
                                            <dd class="col-sm-9">{{ $payment->stripe_payment_id }}</dd>
                                            <dt class="col-sm-3 text-truncate">{{ __('pages.number_card') }}</dt>
                                            <dd class="col-sm-9">**** **** **** {{ $payment->last_four_digits }}</dd>
                                            <dt class="col-sm-3 text-truncate">{{ __('pages.name') }}</dt>
                                            <dd class="col-sm-9">{{ $payment->name }}</dd>
                                            <dt class="col-sm-3 text-truncate">{{ __('pages.email') }}</dt>
                                            <dd class="col-sm-9">{{ $payment->email }}</dd>
                                            <dt class="col-sm-3 text-truncate">{{ __('pages.phone') }}</dt>
                                            <dd class="col-sm-9">{{ $payment->phone }}</dd>
                                            <dt class="col-sm-3 text-truncate">{{ __('pages.country') }}</dt>
                                            <dd class="col-sm-9">{{ $payment->country }}</dd>
                                            <dt class="col-sm-3 text-truncate">{{ __('pages.state') }}</dt>
                                            <dd class="col-sm-9">{{ $payment->state }}</dd>
                                            <dt class="col-sm-3 text-truncate">{{ __('pages.city') }}</dt>
                                            <dd class="col-sm-9">{{ $payment->city }}</dd>
                                            <dt class="col-sm-3 text-truncate">{{ __('pages.building_number') }}</dt>
                                            <dd class="col-sm-9">{{ $payment->building_number }}</dd>
                                            <dt class="col-sm-3 text-truncate">{{ __('pages.amount') }}</dt>
                                            <dd class="col-sm-9">{{ $payment->amount }} {{ $payment->currency }}</dd>
                                            <dt class="col-sm-3 text-truncate">{{ __('pages.payment_status') }}</dt>
                                            <dd class="col-sm-9">
                                                @if($payment->payment_status === "success")
                                                <span style="color:green;">{{ __('pages.done_pay') }}</span>
                                                @else
                                                <span style="color:red;">{{ __('pages.not_pay') }}</span>
                                                @endif
                                            </dd>
                                        </dl>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- end row -->
             <!-- start row -->
             <div class="row">
                <div class="col-xl-12">
                    <div class="card">
                        <div class="row no-gutters align-items-center">
                            <div class="col-md-5">
                                
                                            <img src="{{ asset('assets/images/logo/logo.png') }}" style="width:250px;margin: 20px;" class="card-img" alt="...">

                            </div>
                            <div class="col-md-7">
                                <div class="card-body">

                                        <h4 class="header-title">{{ __('pages.addnotes') }}</h4>
                                        <form action="{{ route('agancypayment.notes', ['lang' => app()->getLocale()]) }}" method="POST" enctype="multipart/form-data" class="row">
                                            @csrf
                                            <div class="col-12">
                                                <div class="card">
                                                    <div class="card-body">
                                                            <div class="form-group mb-3 row">
                                                                <label class="col-md-2 col-form-label">{{ __('pages.notes') }}</label>
                                                                <div class="col-md-10">
                                                                    <textarea class="form-control" id="desc_en" name="notes"></textarea>
                                                                </div>
                                                            </div>
                                                        
                                                            <input type="hidden" name="pay_id" value="{{$payment->id}}">

                                                        <button type="submit" class="btn btn-primary waves-effect waves-light">{{ __('pages.create_product') }}</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- end row -->
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="header-title">{{ __('pages.datiels_pay') }}</h4>
                            <div class="table-responsive">
                                <table class="table mb-0">
                                    <thead>
                                        <tr>
                                            <th>{{ __('pages.ref') }}</th>
                                            <th>{{ __('pages.quantity') }}</th>
                                            <th>{{ __('pages.status_pay') }}</th>
                                            <th>{{ __('pages.status_order') }}</th>
                                            <th>{{ __('pages.notes') }}</th>
                                            <th>{{ __('pages.created_at') }}</th>
                                            <th>{{ __('pages.update_at') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($carts as $cart)
                                        <tr>
                                        <td>
                                                    <a href="{{ route('products.show', ['lang' => app()->getLocale(), 'product' => $cart->product->id]) }}">
                                                    {{ $cart->product->ref }}
                                                    </a>
                                                    </td>
                                                    <td>
                                                    {{ $cart->quantity }}
                                                    </td>
                                                    <td>
                                                        @if ($cart->status_pay == 1)
                                                        <span style="color:green;">{{ __('pages.done_pay') }}</span>
                                                        @else
                                                        <span style="color:red;">{{ __('pages.not_pay') }}</span>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @if ($cart->status_order == 1)
                                                        <span style="color:green;">{{ __('pages.done_order') }}</span>
                                                        @else
                                                        <span style="color:red;">{{ __('pages.padding') }}</span>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @if ($cart->notes)
                                                        {!! $cart->notes !!}                                                            
                                                        @endif
                                                    </td>
                                                    <td>{{ $payment->created_at }}</td>
                                                    <td>{{ $cart->updated_at }}</td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('script')
        <script>
            document.addEventListener("DOMContentLoaded", function () {
                @if(session('success'))
                    Swal.fire({
                        title: "تم الحذف!",
                        text: "{{ session('success') }}",
                        icon: "success",
                        confirmButtonText: "حسنًا"
                    });
                @endif

                @if(session('error'))
                    Swal.fire({
                        title: "خطأ!",
                        text: "{{ session('error') }}",
                        icon: "error",
                        confirmButtonText: "إغلاق"
                    });
                @endif
            });
        </script>

<!--tinymce js-->
<script src="{{ asset('assets/libs/tinymce/tinymce.min.js') }}"></script>
<!-- init js -->
<script src="{{ asset('assets/js/pages/form-editor.init.js') }}"></script>
@endsection