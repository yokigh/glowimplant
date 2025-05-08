@extends('admin.layouts.app')
@section('title','prosthetics')

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
                <h4 class="header-title">{{ __('pages.prosthetics') }}</h4>
                <p class="card-title-desc">{{ __('pages.text_prosthetics') }}</p>

                <a href="{{ route('prosthetics.create', ['lang' => app()->getLocale()]) }}">
                    <button class="btn btn-primary">{{ __('pages.create_prosthetic') }}</button>
                </a>

                <table id="datatable-buttons" class="table table-bordered dt-responsive nowrap w-100">
                    <thead>
                        <tr>
                            <th>{{ __('pages.REF') }}</th>
                            <th>{{ __('pages.diameter') }}</th>
                            <th>{{ __('pages.height') }}</th>
                            <th>{{ __('pages.np') }}</th>
                            <th>{{ __('pages.nr') }}</th>
                            <th>{{ __('pages.desc') }}</th>
                            <th>{{ __('pages.img') }}</th>
                            <th>{{ __('pages.products') }}</th>
                            <th>{{ __('pages.action') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($prosthetics as $item)
                        <tr>
                            <td>{{ $item->ref }}</td>
                            <td>{{ $item->diameter }}</td>
                            <td>{{ $item->height }}</td>
                            <td>{{ $item->np }}</td>
                            <td>{{ $item->nr }}</td>
                            <td>{!! $item->{'description_' . app()->getLocale()} !!}</td>
                            <td><img src="{{ asset($item->image) }}" class="avatar-sm" alt=""></td>
                            <td>
                                <ul>
                                    @foreach ($item->products as $product)
                                        <li>{{ $product->ref }}</li>
                                    @endforeach
                                </ul>
                            </td>
                            <td>
                                <a href="{{ route('prosthetics.show', ['lang' => app()->getLocale(), 'prosthetic' => $item->id]) }}" class="btn btn-info">{{ __('pages.show') }}</a>
                                <a href="{{ route('prosthetics.edit', ['lang' => app()->getLocale(), 'prosthetic' => $item->id]) }}" class="btn btn-warning">{{ __('pages.edit') }}</a>

                                <form id="delete-form-{{ $item->id }}" action="{{ route('prosthetics.destroy', ['lang' => app()->getLocale(), 'prosthetic' => $item->id]) }}" method="POST" style="display: none;">
                                    @csrf @method('DELETE')
                                </form>

                                <a href="javascript:void(0);" onclick="confirmDelete({{ $item->id }})" class="btn btn-danger">{{ __('pages.delete') }}</a>
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
