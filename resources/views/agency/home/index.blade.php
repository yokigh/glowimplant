@extends('agency.layouts.app')
@section('title','Payment')
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
            
                                            <h4 class="header-title">{{ __('pages.payments') }}</h4>
                                            <p class="card-title-desc">{{ __('pages.payments') }}</p>
                                            <table id="datatable-buttons" class="table table-striped table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                                <thead>
                                                <tr>
                                                    <th>{{ __('pages.date') }}</th>
                                                    <th>{{ __('pages.number_card') }}</th>
                                                    <th>{{ __('pages.card_type') }}</th>
                                                    <th>{{ __('pages.stripe_payment_id') }}</th>
                                                    <th>{{ __('pages.actions') }}</th>
                                                </tr>
                                                </thead>
            
                                                <tbody>
                                                    

                                                @foreach ($payments as $payment)
                                                <tr>
                                                    <td>{{ $payment->created_at }}</td>
                                                    <td>{{ $payment->last_four_digits }}</td>
                                                    <td>{{ $payment->card_type }}</td>
                                                    <td>{{ $payment->stripe_payment_id }}</td>
                                                    <td>
                                                            <a href="{{ route('agancypayment.show', ['lang' => app()->getLocale(), 'payment' => $payment->id]) }}" 
                                                            class="btn btn-info">{{ __('pages.show') }}</a>

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

        <script>
        function confirmDelete(eventId) {
                Swal.fire({
                    title: "هل أنت متأكد؟",
                    text: "لن تتمكن من التراجع عن هذا!",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#d33",
                    cancelButtonColor: "#3085d6",
                    confirmButtonText: "نعم، احذف!",
                    cancelButtonText: "إلغاء"
                }).then((result) => {
                    if (result.isConfirmed) {
                        // إرسال الطلب عبر النموذج المخفي
                        document.getElementById(`delete-form-${eventId}`).submit();
                    } else {
                        Swal.fire("تم الإلغاء", "لم يتم حذف الحدث", "info");
                    }
                });
            }
        </script>
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
