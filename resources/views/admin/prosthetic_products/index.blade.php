@extends('admin.layouts.app')
@section('title','Prosthetic Products')

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
                <h4 class="header-title">{{ __('pages.prosthetic_products') }}</h4>
                <p class="card-title-desc">{{ __('pages.text_prosthetic_products') }}</p>

                <a href="{{ route('prosthetic_products.create', ['lang' => app()->getLocale()]) }}">
                    <button class="btn btn-primary">{{ __('pages.create_prosthetic_products') }}</button>
                </a>

                <table id="datatable-buttons" class="table table-bordered dt-responsive nowrap w-100">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>{{ __('pages.name') }}</th>
                            <th>{{ __('pages.description') }}</th>
                            <th>{{ __('pages.img') }}</th>
                            <th>{{ __('pages.gallery') }}</th> <!-- NEW COLUMN -->
                            <th>{{ __('pages.ref') }}</th>
                            <th>{{ __('pages.diameter') }}</th>
                            <th>{{ __('pages.height') }}</th>
                            <th>{{ __('pages.ml') }}</th>
                            <th>{{ __('pages.angle') }}</th>
                            <th>{{ __('pages.screw_ref') }}</th>
                            <th>{{ __('pages.category') }}</th>
                            <th>{{ __('pages.action') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($products as $product)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $product->{'name_' . app()->getLocale()} }}</td>
                            <td>{!! $product->{'description_' . app()->getLocale()} !!}</td>
                            <td>
                                @if ($product->image)
                                    <img src="{{ asset($product->image) }}" class="avatar-sm" alt="">
                                @else
                                    <span class="text-muted">No Image</span>
                                @endif
                            </td>
                            <td>
                                @if ($product->images)
                                    @php $images = json_decode($product->images, true); @endphp
                                    @foreach ($images as $img)
                                        <img src="{{ asset($img) }}" class="avatar-sm mb-1" style="width: 50px; height: 50px; object-fit: cover;" alt="">
                                    @endforeach
                                @else
                                    <span class="text-muted">No Gallery</span>
                                @endif
                            </td>
                            <td>{{ $product->ref }}</td>
                            <td>{{ $product->diameter }}</td>
                            <td>{{ $product->height }}</td>
                            <td>{{ $product->ml }}</td>
                            <td>{{ $product->angle }}</td>
                            <td>{{ $product->screw_ref }}</td>
                            <td>
                                {{ $product->prostheticCategory->{'name_' . app()->getLocale()} ?? '—' }}
                            </td>
                            <td>
                                <a href="{{ route('prosthetic_products.show', ['lang' => app()->getLocale(), 'prosthetic_product' => $product->id]) }}" class="btn btn-info">{{ __('pages.show') }}</a>
                                <a href="{{ route('prosthetic_products.edit', ['lang' => app()->getLocale(), 'prosthetic_product' => $product->id]) }}" class="btn btn-warning">{{ __('pages.edit') }}</a>
                
                                <form id="delete-form-{{ $product->id }}" action="{{ route('prosthetic_products.destroy', ['lang' => app()->getLocale(), 'prosthetic_product' => $product->id]) }}" method="POST" style="display: none;">
                                    @csrf @method('DELETE')
                                </form>
                
                                <a href="javascript:void(0);" onclick="confirmDelete({{ $product->id }})" class="btn btn-danger">{{ __('pages.delete') }}</a>
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
