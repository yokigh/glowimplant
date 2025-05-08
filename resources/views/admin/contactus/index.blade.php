@extends('admin.layouts.app')
@section('title', 'Contact Us')
@section('header')

    <!-- DataTables -->
    <link href="{{ asset('assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/libs/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css') }}" rel="stylesheet" type="text/css" />

    <!-- Responsive datatable examples -->
    <link href="{{ asset('assets/libs/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css') }}" rel="stylesheet" type="text/css" />

@endsection
@section('content')            
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">

                    <h4 class="header-title">{{ __('pages.contact_us') }}</h4>
                    <p class="card-title-desc">{{ __('pages.text_contact_us') }}</p>

                    <a href="{{ route('contactus.create', ['lang' => app()->getLocale()]) }}">
                        <button class="btn btn-primary waves-effect waves-light">{{ __('pages.create_contact') }}</button>
                    </a>

                    <table id="datatable-buttons" class="table table-striped table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                        <thead>
                            <tr>
                                <th>{{ __('pages.name') }}</th>
                                <th>{{ __('pages.country') }}</th>
                                <th>{{ __('pages.email') }}</th>
                                <th>{{ __('pages.phone') }}</th>
                                <th>{{ __('pages.actions') }}</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($contacts as $contact)
                                <tr>
                                    <td>{{ $contact->{'name_' . app()->getLocale()} }}</td>
                                    <td>{{ $contact->country->name }}</td>
                                    <td>{{ $contact->email }}</td>
                                    <td>{{ $contact->phone }}</td>
                                    <td>
                                        <!-- Show Contact -->
                                        <a href="{{ route('contactus.show', ['lang' => app()->getLocale(), 'contactu' => $contact->id]) }}" class="btn btn-info">
                                            {{ __('pages.show') }}
                                        </a>

                                        <!-- Edit Contact -->
                                        <a href="{{ route('contactus.edit', ['lang' => app()->getLocale(), 'contactu' => $contact->id]) }}" class="btn btn-warning">
                                            {{ __('pages.edit') }}
                                        </a>

                                        <!-- Delete Contact -->
                                        <form id="delete-form-{{ $contact->id }}" action="{{ route('contactus.destroy', ['lang' => app()->getLocale(), 'contactu' => $contact->id]) }}" method="POST" style="display: none;">
                                            @csrf
                                            @method('DELETE')
                                        </form>
                                        <a href="javascript:void(0);" onclick="confirmDelete({{ $contact->id }})" class="btn btn-danger">
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
@endsection

@section('script')

    <script src="{{ asset('assets/libs/datatables.net/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/libs/datatables.net-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('assets/libs/datatables.net-buttons/js/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('assets/libs/datatables.net-buttons-bs4/js/buttons.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('assets/libs/jszip/jszip.min.js') }}"></script>
    <script src="{{ asset('assets/libs/pdfmake/build/pdfmake.min.js') }}"></script>
    <script src="{{ asset('assets/libs/pdfmake/build/vfs_fonts.js') }}"></script>
    <script src="{{ asset('assets/libs/datatables.net-buttons/js/buttons.html5.min.js') }}"></script>
    <script src="{{ asset('assets/libs/datatables.net-buttons/js/buttons.print.min.js') }}"></script>
    <script src="{{ asset('assets/libs/datatables.net-buttons/js/buttons.colVis.min.js') }}"></script>
    <script src="{{ asset('assets/libs/datatables.net-responsive/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('assets/libs/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js') }}"></script>

    <script src="{{ asset('assets/js/pages/datatables.init.js') }}"></script>

    <script>
        function confirmDelete(contactId) {
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
                    document.getElementById(`delete-form-${contactId}`).submit();
                } else {
                    Swal.fire("تم الإلغاء", "لم يتم حذف جهة الاتصال", "info");
                }
            });
        }
    </script>

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
