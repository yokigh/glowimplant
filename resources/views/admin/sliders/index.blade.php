@extends('admin.layouts.app')
@section('title','Slider')
@section('header')
    <!-- DataTables -->
    <link href="{{asset('assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('assets/libs/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('assets/libs/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css')}}" rel="stylesheet" type="text/css" />
@endsection
@section('content')            
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="header-title">{{ __('pages.sliders') }}</h4>
                    <p class="card-title-desc">{{ __('pages.text_sliders') }}</p>
                    <a href="{{ route('sliders.create', ['lang' => app()->getLocale()]) }}">
                        <button class="btn btn-primary waves-effect waves-light">{{ __('pages.create_slider') }}</button>
                    </a> 
                    <table id="datatable-buttons" class="table table-striped table-bordered dt-responsive nowrap" style="width: 100%;">
                        <thead>
                        <tr>
                            <th>{{ __('pages.img') }}</th>
                            <th>{{ __('pages.type') }}</th>
                            <th>{{ __('pages.actions') }}</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($sliders as $slider)
                        <tr>
                        <td>
                            <img src="{{ asset($slider->image) }}" alt="Slider Image" class="avatar-sm" 
                                onclick="showImageModal('{{ asset($slider->image) }}')" 
                                style="cursor: pointer;">
                        </td>
                        <td>
                            {{ $slider->type }}
                        </td>
                            <td>
                                <a href="{{ route('sliders.edit', ['lang' => app()->getLocale(), 'slider' => $slider->id]) }}" class="btn btn-warning">{{ __('pages.edit') }}</a>
                                <form id="delete-form-{{ $slider->id }}" action="{{ route('sliders.destroy', ['lang' => app()->getLocale(), 'slider' => $slider->id]) }}" method="POST" style="display: none;">
                                    @csrf
                                    @method('DELETE')
                                </form>
                                <a href="javascript:void(0);" onclick="confirmDelete({{ $slider->id }})" class="btn btn-danger">{{ __('pages.delete') }}</a>
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
@section('script')
    <script src="{{asset('assets/libs/datatables.net/js/jquery.dataTables.min.js')}}"></script>
    <script src="{{asset('assets/libs/datatables.net-bs4/js/dataTables.bootstrap4.min.js')}}"></script>
    <script src="{{asset('assets/libs/datatables.net-buttons/js/dataTables.buttons.min.js')}}"></script>
    <script src="{{asset('assets/libs/datatables.net-buttons-bs4/js/buttons.bootstrap4.min.js')}}"></script>
    <script src="{{asset('assets/libs/jszip/jszip.min.js')}}"></script>
    <script src="{{asset('assets/libs/pdfmake/build/pdfmake.min.js')}}"></script>
    <script src="{{asset('assets/libs/pdfmake/build/vfs_fonts.js')}}"></script>
    <script src="{{asset('assets/libs/datatables.net-buttons/js/buttons.html5.min.js')}}"></script>
    <script src="{{asset('assets/libs/datatables.net-buttons/js/buttons.print.min.js')}}"></script>
    <script src="{{asset('assets/libs/datatables.net-buttons/js/buttons.colVis.min.js')}}"></script>
    <script src="{{asset('assets/libs/datatables.net-responsive/js/dataTables.responsive.min.js')}}"></script>
    <script src="{{asset('assets/libs/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js')}}"></script>
    <script src="{{asset('assets/js/pages/datatables.init.js')}}"></script>
    <script>
    function confirmDelete(sliderId) {
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
                document.getElementById(`delete-form-${sliderId}`).submit();
            } else {
                Swal.fire("تم الإلغاء", "لم يتم حذف السلايدر", "info");
            }
        });
    }
    function showImageModal(imageUrl) {
        Swal.fire({
            imageUrl: imageUrl,
            imageAlt: 'Slider Image',
            showConfirmButton: false,
            padding: '20px',
        });
    }
    </script>
@endsection
