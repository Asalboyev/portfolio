@extends('layouts.admin')
@section('title')
    Category Update
@endsection
@section('css')
@endsection

@section('content')
    {{-- <h1 class="text-uppercase mb-4">Add category</h1> --}}

    {{-- <a href="{{ route('admin.categories.index') }}" class="btn btn-success mb-3 text-white">Back Page</a> --}}

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="post d-flex flex-column-fluid" id="kt_post">
        <!--begin::Container-->
        <div id="kt_content_container" class="container-xxl">
            <form id="" action="{{ route('admin.service_categories.update', $service_category->id) }}" method="POST"
                enctype="multipart/form-data" class="form d-flex flex-column flex-lg-row">
                @csrf
                @method('PUT')
                <!--begin::Aside column-->

                <!--end::Aside column-->
                <!--begin::Main column-->
                <div class="d-flex flex-column flex-row-fluid gap-7 gap-lg-10">
                    <!--begin:::Tabs-->
                    <ul class="nav nav-custom nav-tabs nav-line-tabs nav-line-tabs-2x border-0 fs-4 fw-bold mb-n2">
                        <!--begin:::Tab item-->
                        @foreach ($languages as $language)
                            <li class="nav-item">
                                <a class="nav-link text-active-primary pb-4 @if ($language->small != 'uz') @else
                            active @endif "
                                    data-bs-toggle="tab" href="#{{ $language->small }}">{{ $language->lang }}</a>
                            </li>
                        @endforeach
                    </ul>
                    <!--end:::Tabs-->
                    <!--begin::Tab content-->
                    <div class="tab-content">
                        @foreach ($languages as $language)
                            <!--begin::Tab pane-->
                            <div class="tab-pane fade show @if ($language->small != 'uz') @else
                            active @endif"
                                id="{{ $language->small }}" role="tab-panel">
                                <div class="d-flex flex-column gap-7 gap-lg-10">
                                    <!--begin::General options-->
                                    <div class="card card-flush py-4">
                                        <!--begin::Card header-->
                                        <div class="card-header">
                                            <div class="card-title">
                                                <h2>{{ $language->lang }}</h2>
                                            </div>
                                        </div>
                                        <div class="card-body pt-0">
                                            <!--begin::Input group-->
                                            <div class="mb-10 fv-row">
                                                <!--begin::Label-->
                                                <label class="required form-label">Title-{{ $language->lang }}</label>
                                                <!--end::Label-->
                                                <!--begin::Input-->
                                                <input type="text" name="title[{{ $language->small }}]"
                                                    class="form-control mb-2"
                                                    placeholder="title {{ $language->small }}..."
                                                    @if ($language->small != 'uz') @else value="{{ $service_category->title[$language->small] }}" @endif />
                                                @error('title[{{ $language->small }}]')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <!--end::Input group-->
                                            <!--begin::Input group-->
                                            <div>
                                                <!--begin::Label-->
                                                <label class="form-label">Description-{{ $language->lang }}</label>
                                                <textarea name="descriptions[{{ $language->small }}]" class="form-control ckeditor" required> @if ($language->small != 'uz')
                                                @else
                                                {!! $service_category->descriptions[$language->small] !!}
                                                @endif </textarea>

                                            </div>
                                            <!--end::Input group-->
                                        </div>
                                        <!--end::Card header-->
                                    </div>

                                    <!--end::Media-->

                                    <!--end::Pricing-->
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <!--end::Tab content-->
                    <div class="d-flex justify-content-end">
                        <!--begin::Button-->
                        <a href="../../demo1/dist/apps/ecommerce/catalog/products.html"
                            id="kt_ecommerce_add_product_cancel" class="btn btn-light me-5">Cancel</a>
                        <!--end::Button-->
                        <!--begin::Button-->
                        <button type="submit" id="kt_ecommerce_add_product_submit" class="btn btn-primary">
                            <span class="indicator-label">Save Changes</span>
                            <span class="indicator-progress">Please wait...
                                <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                        </button>
                        <!--end::Button-->
                    </div>
                </div>
<div class="d-flex flex-column gap-7 gap-lg-10 w-100 w-lg-300px mb-7 me-lg-10" style="margin-left: 2rem; margin-top:5.5rem">
                    <!--begin::Thumbnail settings-->
                    <div class="card card-flush py-4">



                        <div class="card-header">
                            <!--begin::Card title-->
                            <div class="card-title">
                                <h2>Edit Subccategory</h2>
                            </div>
                        </div>
                        <div class="card-body pt-0">
                            <!--begin::Select2-->
                            <select class="form-select mb-2" data-control="select2" name="service_category_id"
                                id="kt_ecommerce_add_category_status_select">
                                <option value="{{ $service_category->category_id }}" selected="false" disabled="disabled">
                                    {{ $service_category->title['uz'] }}</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->title['uz'] }}
                                        {{-- @if ($category->categories->isNotEmpty())
                                    @foreach ($category->categories as $subcategory)
                                    <option value="{{ null }}">{{$category->title['uz']}}</option>
                                        @endforeach
                                        @else
                                        <p> NO Categories</p>
                                        @endif</option> --}}
                                @endforeach
                            </select>
                            {{-- <label for="firstSelect">Birinchi tanlov:</label>
                            <select id="firstSelect" onchange="handleFirstSelectChange()">
                                <option value="">Tanlang</option>
                                @foreach ($categories as $category)
                                    <option value="mobil" id="mobil">Mobile</option>
                                @endforeach
                                <option value="model">Model</option>

                            </select>
                            <br><br>
                            <div id="secondSelectContainer" style="display: none;">
                                <label for="secondSelect">Ikkinchi tanlov:</label>
                                <select id="secondSelect">
                                    <option value="">Tanlang</option>
                                    <option value="samsung">Samsung</option>
                                    <option value="iphone">iPhone</option>
                                </select>
                            </div> --}}

                        </div>
                        <div class="card-header">

                            <!--begin::Card title-->
                            <div class="card-title">
                                <h2>Photo</h2>
                            </div>
                            <!--end::Card title-->
                        </div>
                        <div class="card-body  pt-0">
                            <!--begin::Image input-->
                            <div class="image-input image-input-empty image-input-outline mb-3" data-kt-image-input="true"
                                style="background-image: url({{ asset($service_category->photo) }})">
                                <!--begin::Preview existing avatar-->
                                <div class="image-input-wrapper w-150px h-150px"></div>
                                <!--end::Preview existing avatar-->
                                <!--begin::Label-->
                                <label class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow"
                                    data-kt-image-input-action="change" data-bs-toggle="tooltip" title="Change avatar">
                                    <!--begin::Icon-->
                                    <i class="bi bi-pencil-fill fs-7"></i>
                                    <input type="file" value="" name="photo" accept=".png, .jpg, .jpeg, .webp" />
                                    <input type="hidden" name="avatar_remove" />
                                </label>
                                <span class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow"
                                    data-kt-image-input-action="cancel" data-bs-toggle="tooltip" title="Cancel avatar">
                                    <i class="bi bi-x fs-2"></i>
                                </span>
                                <span class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow"
                                    data-kt-image-input-action="remove" data-bs-toggle="tooltip" title="Remove avatar">
                                    <i class="bi bi-x fs-2"></i>
                                </span>
                                <!--end::Remove-->
                            </div>
                            <!--end::Image input-->
                            <!--begin::Description-->
                            {{-- <div class="text-muted fs-7">Set the category thumbnail image. Only *.png, *.jpg and *.jpeg image files are accepted</div> --}}
                            <!--end::Description-->
                        </div>

                        <!--begin::Card header-->
                        <div class="card-header">
                            <!--begin::Card title-->
                            <div class="card-title">
                                <h2>Status</h2>
                            </div>
                        </div>
                        <!--end::Card header-->
                        <!--begin::Card body-->
                        <div class="card-body pt-0">
                            <!--begin::Select store template-->
                            <label for="kt_ecommerce_add_category_store_template" class="form-label">Select a status</label>
                            <!--end::Select store template-->
                            <!--begin::Select2-->
                            <select class="form-select mb-2" data-control="select2" name="status" data-hide-search="true"
                                id="kt_ecommerce_add_category_store_template">
                                <option value="{{ $service_category->status }}" selected="false" disabled="disabled">
                                    {{ $service_category->status }}</option>
                                <option value="Active">Active</option>
                                <option value="Inacitve">Inacitve</option>
                                {{-- <option value="True">True</option>
                                <option value="False">False</option> --}}
                            </select>

                            <!--end::Description-->
                        </div>
                        <div class="card-body pt-0">
                            <!--begin::Select store template-->
                            <label for="kt_ecommerce_add_category_store_template" class="form-label">order</label>
                            <input type="number" name="order" id="checkbox" value="{{ $service_category->order }}"
                                class="form-control mb-2">
                        </div>
                    </div>
                </div>
                <!--end::Main column-->
            </form>
        </div>
        <!--end::Container-->
    </div>


@endsection
@section('js')
    <script src="//cdn.ckeditor.com/4.20.0/standard/ckeditor.js"></script>
    <script src="/admin/assets/bundles/select2/dist/js/select2.full.min.js"></script>
    <script type="text/javascript">
        CKEDITOR.replace('descriptions[{{ $language->small }}]', {
            filebrowserUploadUrl: "{{ route('admin.category.upload', ['_token' => csrf_token()]) }}",
            filebrowserUploadMethod: 'form'
        });
    </script>
@endsection
