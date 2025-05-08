@extends('admin.layouts.app')
@section('title','Category')
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
            
                                            <h4 class="header-title">{{ __('pages.categories') }}</h4>
                                            <p class="card-title-desc">{{ __('pages.textcategories') }}
                                            </p>
                                            <a href="{{ route('categories.create', ['lang' => app()->getLocale()]) }}">
                                                <button class="btn btn-primary waves-effect waves-light">{{ __('pages.create_categories') }}</button>
                                            </a> 
                                            <table id="datatable-buttons" class="table table-striped table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                                <thead>
                                                <tr>
                                                    <th>{{ __('pages.name') }}</th>
                                                    <th>{{ __('pages.desc') }}</th>
                                                    <th>{{ __('pages.img') }}</th>
                                                    <th>{{ __('pages.date_add') }}</th>
                                                    <th>{{ __('pages.number_subcategory') }}</th>
                                                    <th>{{ __('pages.actions') }}</th>
                                                </tr>
                                                </thead>
            
            
                                                <tbody>
                                                    
                                                @foreach ($categories as $category)
                                                <tr>
                                                    <td>
                                                    <a href="{{route('categories.show', ['lang' => app()->getLocale(), 'category' => $category->id])}}">
                                                    {{ $category->{'name_' . app()->getLocale()} }}
                                                    </a>
                                                    </td>
                                                    <td>
                                                    {!! $category->{'description_' . app()->getLocale()} !!}
                                                    </td>
                                                    <td>
                                                        <img src="{{ asset($category->image) }}" alt="Category Image" class="avatar-sm clickable-image" data-bs-toggle="modal" data-bs-target="#imageModal" data-image="{{ asset($category->image) }}">
                                                    </td>
                                                    <td>{{ $category->created_at }}</td>
                                                    <td>
                                                    {{ $category->subcategories_count }}
                                                    </td>
                                                    <td>
                                                        <!-- show category -->
                                                        <a href="{{ route('categories.show', ['lang' => app()->getLocale(), 'category' => $category->id]) }}" 
                                                        class="btn btn-info">
                                                            {{ __('pages.show') }}
                                                        </a>

                                                        <!-- edit category-->
                                                        <a href="{{ route('categories.edit', ['lang' => app()->getLocale(), 'category' => $category->id]) }}" 
                                                        class="btn btn-warning">
                                                            {{ __('pages.edit') }}
                                                        </a>
                                                        <form id="delete-form-{{ $category->id }}" action="{{ route('categories.destroy', ['lang' => app()->getLocale(), 'category' => $category->id]) }}" method="POST" style="display: none;">
                                                            @csrf
                                                            @method('DELETE')
                                                        </form>

                                                        <a href="javascript:void(0);" onclick="confirmDelete({{ $category->id }})" class="btn btn-danger">
                                                            {{ __('pages.delete') }}
                                                        </a>
                                                    </td>
                                                </tr>
                                                @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div> <!-- end col -->
                            </div> 
                            <div class="modal fade" id="imageModal" tabindex="-1" aria-labelledby="imageModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="imageModalLabel">عرض الصورة</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="إغلاق"></button>
                                        </div>
                                        <div class="modal-body text-center">
                                            <img id="modalImage" src="" class="img-fluid rounded shadow">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <script>
                                document.addEventListener("DOMContentLoaded", function() {
                                    document.querySelectorAll(".clickable-image").forEach(img => {
                                        img.addEventListener("click", function() {
                                            let imageUrl = this.getAttribute("data-image");
                                            document.getElementById("modalImage").src = imageUrl;
                                        });
                                    });
                                });

                            </script>
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
                        Swal.fire("تم الإلغاء", "لم يتم حذف الصنف", "info");
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