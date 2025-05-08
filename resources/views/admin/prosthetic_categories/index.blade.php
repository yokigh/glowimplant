@extends('admin.layouts.app')
@section('title','Prosthetic Categories')

@section('header')
<link href="{{asset('assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css')}}" rel="stylesheet" />
<link href="{{asset('assets/libs/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css')}}" rel="stylesheet" />
<link href="{{asset('assets/libs/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css')}}" rel="stylesheet" />
@endsection

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <h4 class="header-title">{{ __('pages.prosthetic_categories') }}</h4>
                <p class="card-title-desc">{{ __('pages.text_prosthetic_categories') }}</p>

                <a href="{{ route('prostatic_categories.create', ['lang' => app()->getLocale()]) }}">
                    <button class="btn btn-primary">{{ __('pages.create_prosthetic_category') }}</button>
                </a>

                <table id="datatable-buttons" class="table table-bordered dt-responsive nowrap w-100">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>{{ __('pages.name') }}</th>
                            <th>{{ __('pages.description') }}</th>
                            <th>{{ __('pages.img') }}</th>
                            <th>{{ __('pages.products') }}</th>
                            <th>{{ __('pages.action') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($categories as $category)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $category->{'name_' . app()->getLocale()} }}</td>
                            <td>{!! $category->{'description_' . app()->getLocale()} !!}</td>
                            <td>
                                @if ($category->image)
                                    <img src="{{ asset($category->image) }}" class="avatar-sm" alt="">
                                @else
                                    <span class="text-muted">No Image</span>
                                @endif
                            </td>                            
                            <td>
                                <ul>
                                    @foreach ($category->subcategories as $subcategory)
                                        <li>{{ $subcategory->name_en }}</li>
                                    @endforeach
                                </ul>
                            </td>
                            
                            <td>
                                <a href="{{ route('prostatic_categories.show', ['lang' => app()->getLocale(), 'prostatic_category' => $category->id]) }}" class="btn btn-info">{{ __('pages.show') }}</a>
                                <a href="{{ route('prostatic_categories.edit', ['lang' => app()->getLocale(), 'prostatic_category' => $category->id]) }}" class="btn btn-warning">{{ __('pages.edit') }}</a>

                                <form id="delete-form-{{ $category->id }}" action="{{ route('prostatic_categories.destroy', ['lang' => app()->getLocale(), 'prostatic_category' => $category->id]) }}" method="POST" style="display: none;">
                                    @csrf @method('DELETE')
                                </form>

                                <a href="javascript:void(0);" onclick="confirmDelete({{ $category->id }})" class="btn btn-danger">{{ __('pages.delete') }}</a>
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
<script src="{{asset('assets/libs/datatables.net-responsive/js/dataTables.responsive.min.js')}}"></script>
<script src="{{asset('assets/libs/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js')}}"></script>
<script src="{{asset('assets/js/pages/datatables.init.js')}}"></script>

<script>
function confirmDelete(id) {
    Swal.fire({
        title: "هل أنت متأكد؟",
        text: "لن تتمكن من التراجع!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#d33",
        cancelButtonColor: "#3085d6",
        confirmButtonText: "نعم، احذف",
        cancelButtonText: "إلغاء"
    }).then((result) => {
        if (result.isConfirmed) {
            document.getElementById(`delete-form-${id}`).submit();
        } else {
            Swal.fire("تم الإلغاء", "لم يتم الحذف", "info");
        }
    });
}
</script>

@if(session('success'))
<script>
Swal.fire("تم!", "{{ session('success') }}", "success");
</script>
@endif

@if(session('error'))
<script>
Swal.fire("خطأ!", "{{ session('error') }}", "error");
</script>
@endif
@endsection
