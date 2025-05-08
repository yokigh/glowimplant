@extends('agency.layouts.app')
@section('title','products')
@section('header')

        <!-- DataTables -->
        <link href="{{asset('assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css')}}" rel="stylesheet" type="text/css" />
        <link href="{{asset('assets/libs/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css')}}" rel="stylesheet" type="text/css" />

        <!-- Responsive datatable examples -->
        <link href="{{asset('assets/libs/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css')}}" rel="stylesheet" type="text/css" />     

@endsection
@section('content')            
                            <div class="row">
                                <div class="col-12">
                                    <div class="card">
                                        <div class="card-body">
            
                                            <h4 class="header-title">{{ __('pages.products') }}</h4>
                                            <p class="card-title-desc">{{ __('pages.textproducts') }}
                                            </p>
                                            <table id="datatable-buttons" class="table table-striped table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                                <thead>
                                                <tr>
                                                    <th>{{ __('pages.REF') }}</th>
                                                    <th>{{ __('pages.diameter') }}</th>
                                                    <th>{{ __('pages.height') }}</th>
                                                    <th>{{ __('pages.desc') }}</th>
                                                    <th>{{ __('pages.img') }}</th>
                                                    <th>{{ __('pages.category') }}</th>
                                                    <th>{{ __('pages.subcategory') }}</th>
                                                    <th>{{ __('pages.created_at') }}</th>
                                                    <th>{{ __('pages.find_prices') }}</th> <!-- العمود الجديد -->
                                                    <th>{{ __('pages.action') }}</th>
                                                </tr>
                                                </thead>

                                                <tbody>
                                                    @foreach ($products as $product)
                                                    <tr>
                                                        <td>
                                                            <a href="{{ route('products.show', ['lang' => app()->getLocale(), 'product' => $product->id]) }}">
                                                                {{ $product->ref }}
                                                            </a>
                                                        </td>
                                                        <td>
                                                            {{ $product->diameter }}
                                                        </td>
                                                        <td>
                                                            {{ $product->height }}
                                                        </td>
                                                        <td>
                                                            {!! $product->{'description_' . app()->getLocale()} !!}
                                                        </td>
                                                        <td><img src="{{ asset($product->image) }}" alt="" class="avatar-sm"></td>
                                                        <td>
                                                            {{ optional($product->subcategory->category)->{'name_' . app()->getLocale()} ?? 'N/A' }}
                                                        </td>
                                                        <td>
                                                            {{ optional($product->subcategory)->{'name_' . app()->getLocale()} ?? 'N/A' }}
                                                        </td>
                                                        <td>{{ $product->created_at }}</td>
                                                                
                                                        <td style="">
                                                            <ul>
                                                        @foreach ($countries as $country)
                                                        @php
                                                            $price = $product->prices->where('country_id', $country->id)->first();
                                                        @endphp
                                                            <li style="color: {{ $price ? 'green' : 'red' }};">
                                                                {{$country->name}} : 
                                                            {{ $price ? $price->price . ' ' . $country->currency : 'N/A' }}
                                                            </li>
                                                      @endforeach
                                                      </ul>
                                                      </td>

                                                        <td>
                                                            <!-- الأزرار الخاصة بالعرض والتعديل والحذف -->
                                                            <a href="{{ route('agencyproducts.show', ['lang' => app()->getLocale(), 'product' => $product->id]) }}" 
                                                            class="btn btn-info">{{ __('pages.show') }}</a>

                                                            <a href="{{ route('agencyproducts.edit', ['lang' => app()->getLocale(), 'product' => $product->id]) }}" 
                                                            class="btn btn-warning">{{ __('pages.edit') }}</a>

                                                        </td>
                                                    </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>

                                        </div>
                                    </div>
                                </div> <!-- end col -->
                            </div> 
@endsection
@section('script')

        <script src="{{asset('assets/libs/datatables.net/js/jquery.dataTables.min.js')}}"></script>
        <script src="{{asset('assets/libs/datatables.net-bs4/js/dataTables.bootstrap4.min.js')}}"></script>
        <!-- Buttons examples -->
        <script src="{{asset('assets/libs/datatables.net-buttons/js/dataTables.buttons.min.js')}}"></script>
        <script src="{{asset('assets/libs/datatables.net-buttons-bs4/js/buttons.bootstrap4.min.js')}}"></script>
        <script src="{{asset('assets/libs/jszip/jszip.min.js')}}"></script>
        <script src="{{asset('assets/libs/pdfmake/build/pdfmake.min.js')}}"></script>
        <script src="{{asset('assets/libs/pdfmake/build/vfs_fonts.js')}}"></script>
        <script src="{{asset('assets/libs/datatables.net-buttons/js/buttons.html5.min.js')}}"></script>
        <script src="{{asset('assets/libs/datatables.net-buttons/js/buttons.print.min.js')}}"></script>
        <script src="{{asset('assets/libs/datatables.net-buttons/js/buttons.colVis.min.js')}}"></script>
        <!-- Responsive examples -->
        <script src="{{asset('assets/libs/datatables.net-responsive/js/dataTables.responsive.min.js')}}"></script>
        <script src="{{asset('assets/libs/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js')}}"></script>

        <!-- Datatable init js -->
        <script src="{{asset('assets/js/pages/datatables.init.js')}}"></script>

        <!-- Message success delete -->
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
@endsection