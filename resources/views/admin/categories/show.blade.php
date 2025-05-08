@extends('admin.layouts.app')
@section('title','Show Category')
@section('content')

<div class="row">
    <div class="col-lg-12">
        <div>
            <div class="row">
                <div class="col-xl-12">
                    <div class="card">
                        <div class="row no-gutters align-items-center">
                            <div class="col-md-5 text-center">
                                @if($category->image)
                                    <img src="{{ asset($category->image) }}" class="card-img img-thumbnail clickable-image" alt="Main Image">
                                @else
                                    <p>No Image</p>
                                @endif
                            </div>
                            <div class="col-md-7">
                                <div class="card-body">
                                    <h4 class="header-title">{{ $category->{'name_' . app()->getLocale()} }}</h4>

                                    <dl class="row mb-0">
                                        <dt class="col-sm-3">{{ __('pages.desc') }}</dt>
                                        <dd class="col-sm-9">{!! $category->{'description_' . app()->getLocale()} !!} <br></dd>

                                        <dt class="col-sm-3 text-truncate">{{ __('pages.date_create') }}</dt>
                                        <dd class="col-sm-9">{{ $category->created_at }}</dd>
                                        <dt class="col-sm-3 text-truncate">{{ __('pages.last_update') }}</dt>
                                        <dd class="col-sm-9">{{ $category->updated_at }}</dd>
                                    </dl>

                                    <!-- الصور المتعددة -->
                                    <div class="gallery_img mt-3">
                                        <h5>صور إضافية</h5>
                                        <div class="row">
                                            @if($category->images)
                                                @foreach(json_decode($category->images) as $image)
                                                    <div class="col-md-3 mb-2">
                                                        <img src="{{ asset($image) }}" class="img-fluid img-thumbnail clickable-image"alt="Category Image" data-bs-toggle="modal" data-bs-target="#imageModal" data-image="{{ asset($image) }}">
                                                    </div>
                                                @endforeach
                                            @else
                                                <p>لا توجد صور إضافية</p>
                                            @endif
                                        </div>
                                    </div>

                                    <!-- عرض ملف الكتالوج -->
                                    <div class="catalog_pdf mt-3">
                                        <h5>الكتالوج</h5>
                                        @if($category->catalog)
                                            <a href="{{ asset($category->catalog) }}" class="btn btn-primary" target="_blank">
                                                <i class="fas fa-file-pdf"></i> عرض الكتالوج
                                            </a>
                                        @else
                                            <p>لا يوجد كتالوج</p>
                                        @endif
                                    </div>
                                    <dl class="row mb-0">
                                        <dt class="col-sm-3">{{ __('pages.action') }}</dt>
                                        <dd class="col-sm-9">
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
                                                    </dd>

                                    </dl>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- end row -->
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="header-title">{{ __('pages.subcategory_category') }}</h4>
                            <div class="table-responsive">
                                <table class="table mb-0">
                                    <thead>
                                        <tr>
                                            <th>{{ __('pages.name') }}</th>
                                            <th>{{ __('pages.desc') }}</th>
                                            <th>{{ __('pages.img') }}</th>
                                            <th>{{ __('pages.created_at') }}</th>
                                            <th>{{ __('pages.update_at') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($subcategories as $subcategory)
                                        <tr>
                                        <td>
                                                    <a href="{{ route('subcategories.show', ['lang' => app()->getLocale(), 'subcategory' => $subcategory->id]) }}">
                                                    {{ $subcategory->{'name_' . app()->getLocale()} }}
                                                    </a>
                                                    </td>
                                                    <td>
                                                    {!! $subcategory->{'description_' . app()->getLocale()} !!}
                                                    </td>
                                                    <td><img src="{{ asset($subcategory->image) }}" alt="" class="avatar-sm"></td>
                                                    <td>{{ $subcategory->created_at }}</td>
                                                    <td>{{ $subcategory->updated_at }}</td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
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
