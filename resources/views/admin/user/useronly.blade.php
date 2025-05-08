@extends('admin.layouts.app')
@section('title','Users')
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
                                        <div class="row">
                                            <div class="col-md-6">
                                                <canvas id="userChart" width="300" height="150"></canvas>
                                            </div>
                                            <div class="col-md-6">
                                            <canvas id="rolePieChart"></canvas>
                                            </div>
                                        </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <div class="card">
                                        <div class="card-body">
                                            <h4 class="header-title">{{ __('pages.onlyuser') }}</h4>
                                            <p class="card-title-desc">{{ __('pages.textonlyuser') }}
                                            </p>
        
                                            <a href="{{ route('createuseronly.index', ['lang' => app()->getLocale()]) }}">
                                                <button class="btn btn-primary waves-effect waves-light">{{ __('pages.create_user') }}</button>
                                            </a> 
                                            <table id="datatable-buttons" class="table table-striped table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                                <thead>
                                                <tr>
                                                    <th>{{ __('pages.name') }}</th>
                                                    <th>{{ __('pages.email') }}</th>
                                                    <th>{{ __('pages.birth') }}</th>
                                                    <th>{{ __('pages.phone') }}</th>
                                                    <th>{{ __('pages.country') }}</th>
                                                    <th>{{ __('pages.role') }}</th>
                                                    <th>{{ __('pages.actions') }}</th>
                                                </tr>
                                                </thead>
            
            
                                                <tbody>
                                                    
                                                @foreach ($users as $user)
                                                <tr>
                                                    <td>
                                                    <a href="{{ route('users.show', ['lang' => app()->getLocale(), 'user' => $user->id]) }}">
                                                        {{ $user->name }}
                                                    </a>
                                                    </td>
                                                    <td>
                                                        {{ $user->email }}
                                                        <br>
                                                        @if(!empty($user->email_verified_at))
                                                        <small style="color:green;">{{ __('pages.virifay') }} <br> {{ __('pages.date_virifay') }} : <b>{{ $user->email_verified_at }}</b> </small>
                                                        @else
                                                        <small style="color:red;">{{ __('pages.notvirifay') }}</small>
                                                        <a href="{{ route('users.virifay', ['lang' => app()->getLocale(), 'user' => $user->id]) }}">{{ __('pages.send_virifay') }}</a>
                                                        @endif
                                                    </td>
                                                    <td>{{ $user->datebirthday }}</td>
                                                    <td>{{ $user->phone }}</td>
                                                    <td>{{ $user->country->name }}</td>
                                                    <td>{{ $user->role }}</td>
                                                    <td>
                                                        <form id="delete-form-{{ $user->id }}" action="{{ route('users.destroy', ['lang' => app()->getLocale(), 'user' => $user->id]) }}" method="POST" style="display: none;">
                                                            @csrf
                                                            @method('DELETE')
                                                        </form>

                                                        <a href="javascript:void(0);" onclick="confirmDelete({{ $user->id }})" class="btn btn-danger">
                                                            {{ __('pages.delete') }}
                                                        </a>
                                                        <a href="{{ route('users.forgetpassword', ['lang' => app()->getLocale(), 'user' => $user->id]) }}" class="btn btn-warning">{{ __('pages.Forgot password') }}</a>

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
        <script src="{{url('https://cdn.jsdelivr.net/npm/sweetalert2@11')}}"></script>

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
                        Swal.fire("تم الإلغاء", "لم يتم حذف المستخدم", "info");
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
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script>
    document.addEventListener("DOMContentLoaded", function () {
        // بيانات المخطط الخطي لعدد المستخدمين الذين لديهم دور "user" خلال السنة الحالية
        var usersPerMonth = @json($usersPerMonth);
        var months = Array.from({length: 12}, (_, i) => i + 1); // الأشهر 1 إلى 12
        var userCounts = months.map(m => usersPerMonth[m] || 0); // إذا لم يكن هناك بيانات اجعلها 0

        var ctx = document.getElementById('userChart').getContext('2d');
        new Chart(ctx, {
            type: 'line',
            data: {
                labels: months.map(m => `شهر ${m}`),
                datasets: [{
                    label: 'عدد المستخدمين الجدد بدور "user"',
                    data: userCounts,
                    borderColor: 'blue',
                    borderWidth: 2,
                    fill: false
                }]
            }
        });

        // بيانات المخطط الدائري لتوزيع المستخدمين حسب الأدوار
        var userRolesCount = @json($userRolesCount);
        var roleLabels = Object.keys(userRolesCount);
        var roleCounts = Object.values(userRolesCount);

        var ctxPie = document.getElementById('rolePieChart').getContext('2d');
        new Chart(ctxPie, {
            type: 'pie',
            data: {
                labels: roleLabels,
                datasets: [{
                    label: 'توزيع المستخدمين حسب الأدوار',
                    data: roleCounts,
                    backgroundColor: ['#FF6384', '#36A2EB', '#FFCE56', '#4CAF50', '#FF9800']
                }]
            }
        });
    });
</script>


@endsection