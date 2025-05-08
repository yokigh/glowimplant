@extends('admin.layouts.app')
@section('title', 'About Us')
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

                    <h4 class="header-title">{{ __('pages.about_us') }}</h4>
                    <p class="card-title-desc">{{ __('pages.text_about_us') }}</p>

                    <a href="{{ route('about-us.create', ['lang' => app()->getLocale()]) }}">
                        <button class="btn btn-primary waves-effect waves-light">{{ __('pages.create_about_us') }}</button>
                    </a> 

                    <table id="datatable-buttons" class="table table-striped table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                        <thead>
                            <tr>
                                <th>{{ __('pages.name') }}</th>
                                <th>{{ __('pages.description') }}</th>
                                <th>{{ __('pages.image') }}</th>
                                <th>{{ __('pages.created_at') }}</th>
                                <th>{{ __('pages.action') }}</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($aboutUs as $about)
                            <tr>
                                <td>{{ $about->name  }}</td>
                                <td>{!! $about->description !!}</td>
                                <td><img src="{{ asset($about->image) }}" alt="" class="avatar-sm"></td>
                                <td>{{ $about->created_at }}</td>
                                <td>

                                    <a href="{{ route('about-us.edit', ['lang' => app()->getLocale(), 'about_u' => $about->id]) }}" class="btn btn-warning">{{ __('pages.edit') }}</a>

                                    <form id="delete-form-{{ $about->id }}" action="{{ route('about-us.destroy', ['lang' => app()->getLocale(), 'about_u' => $about->id]) }}" method="POST" style="display: none;">
                                        @csrf
                                        @method('DELETE')
                                    </form>

                                    <a href="javascript:void(0);" onclick="confirmDelete({{ $about->id }})" class="btn btn-danger">{{ __('pages.delete') }}</a>
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
        function confirmDelete(userId) {
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
                        document.getElementById(`delete-form-${userId}`).submit();
                    } else {
                        Swal.fire("تم الإلغاء", "لم يتم حذف العنصر", "info");
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
