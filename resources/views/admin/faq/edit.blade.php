@extends('layouts.admin')
@section('title')
    Update Faq
@endsection
@section('css')
@endsection

@section('content')
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
            <form id="" action="{{ route('admin.faq.store') }}" method="POST" enctype="multipart/form-data"
                class="form d-flex flex-column flex-lg-row">
                @csrf
                <!--begin::Aside column-->

                <!--end::Thumbnail settings-->
                <!--begin::Status-->
                <div class="d-flex flex-column flex-row-fluid gap-7 gap-lg-10">
                    <!--begin:::Tabs-->
                    <ul class="nav nav-custom nav-tabs nav-line-tabs nav-line-tabs-2x border-0 fs-4 fw-bold mb-n2">
                        <!--begin:::Tab item-->
                        @foreach ($languages as $language)
                            <li class="nav-item">
                                <a class="nav-link text-active-primary pb-4 @if ($language->small != 'en') @else
                            active @endif "
                                    data-bs-toggle="tab" href="#{{ $language->small }}">{{ $language->lang }}</a>
                            </li>
                        @endforeach

                        <!--end:::Tab item-->
                    </ul>
                    <!--end:::Tabs-->
                    <!--begin::Tab content-->
                    <div class="tab-content">
                        @foreach ($languages as $language)
                            <!--begin::Tab pane-->
                            <div class="tab-pane fade show @if ($language->small != 'en') @else
                            active @endif"
                                id="{{ $language->small }}" role="tab-panel">
                                <div class="d-flex flex-column gap-7 gap-lg-10">

                                    <div class="card card-flush py-4">
                                        <!--begin::Card header-->
                                        <div class="card-header">
                                            <div class="card-title">
                                                <h2>{{ $language->lang }}</h2>
                                            </div>
                                        </div>
                                        <div class="card-body pt-0">
                                            <div class="mb-10 fv-row">
                                                <label class="required form-label">Question-{{ $language->lang }}</label>
                                                <input required type="text" name="question[{{ $language->small }}]"
                                                    class="form-control mb-2" placeholder=" {{ $language->small }}..." value="{{$faq->question[$language->small]}}" />
                                                @error('question[{{ $language->small }}]')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="mb-10 fv-row">
                                                <label class="required form-label">Answer-{{ $language->lang }}</label>
                                                <textarea id="answer-{{ $language->small }}" required name="answer[{{ $language->small }}]" class="form-control ckeditor">@if ($language->small != 'en')@else{!! $faq->answer[$language->small] !!}@endif</textarea>
                                                @error('answer[{{ $language->small }}]')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <div class="d-flex justify-content-end">
                        <!--begin::Button-->
                        <a href="../../demo1/dist/apps/ecommerce/catalog/products.html" id="kt_ecommerce_add_product_cancel"
                            class="btn btn-light me-5">Cancel</a>
                        <button type="submit" id="kt_ecommerce_add_product_submit" class="btn btn-primary">
                            <span class="indicator-label">Save Changes</span>
                            <span class="indicator-progress">Please wait...
                                <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                        </button>
                    </div>

                </div>
                <div class="d-flex flex-column gap-7 gap-lg-10 w-100 w-lg-300px mb-7 me-lg-10" style="margin-left: 2rem; margin-top:5rem">
                    <!--begin::Thumbnail settings-->
                    <div class="card card-flush py-4">
                        <div class="card-header">
                            <div class="card-title">
                                <h2> Order</h2>
                            </div>
                            <!--end::Card title-->
                        </div>
                        <div class="card-body  pt-0">
                            <!--begin::Image input-->



                            <!--end::Remove-->
                        </div>
                        <div class="card-body pt-0">
                            <!--begin::Select store template-->
                            <label for="kt_ecommerce_add_category_store_template" class="form-label">Order</label>
                            <input type="number" class="form-control mb-2" name="order" placeholder="order..">
                        </div>
                    </div>


                </div>

        </div>
        <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
            <!--begin::Toolbar-->
            <div class="toolbar" id="kt_toolbar">
                <!--begin::Container-->
                <div id="kt_toolbar_container" class="container-fluid d-flex flex-stack">
                    <!--begin::Page title-->
                    <div data-kt-swapper="true" data-kt-swapper-mode="prepend"
                        data-kt-swapper-parent="{default: '#kt_content_container', 'lg': '#kt_toolbar_container'}"
                        class="page-title d-flex align-items-center flex-wrap me-3 mb-5 mb-lg-0">
                        <!--begin::Title-->
                        <a href="{{route('admin.faq.index')}}"
                            class="d-flex text-dark fw-bolder fs-3 align-items-center my-1">Back</a>
                        <!--end::Title-->
                        <!--begin::Separator-->
                        <span class="h-20px border-gray-300 border-start mx-4"></span>
                        <!--end::Separator-->
                        <!--begin::Breadcrumb-->
                        <ul class="breadcrumb breadcrumb-separatorless fw-bold fs-7 my-1">

                            <!--begin::Item-->
                            <li class="breadcrumb-item">
                                <span class="bullet bg-gray-300 w-5px h-2px"></span>
                            </li>
                            <!--end::Item-->
                        </ul>
                        <!--end::Breadcrumb-->
                    </div>
                    <!--end::Page title-->
                    <!--begin::Actions-->
                    <div class="d-flex align-items-center gap-2 gap-lg-3">
                        <button type="submit" class="btn btn-sm btn-primary">Add</button>
                        <!--end::Primary button-->
                    </div>
                    <!--end::Actions-->
                </div>
                <!--end::Container-->
            </div>

        </div>
        </form>
    </div>
    </div>
    </div>
@endsection
@section('js')
    <script src="//cdn.ckeditor.com/4.20.0/standard/ckeditor.js"></script>
    <script src="/admin/assets/bundles/select2/dist/js/select2.full.min.js"></script>
    <script type="text/javascript">
        @foreach($languages as $language)
        CKEDITOR.replace('answer-{{ $language->small }}', {
            filebrowserUploadUrl: "{{ route('admin.faq.upload', ['_token' => csrf_token()]) }}",
            filebrowserUploadMethod: 'form'
        });
        @endforeach
    </script>
@endsection
