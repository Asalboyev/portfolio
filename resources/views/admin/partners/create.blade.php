@extends('layouts.admin')
@section('title')
    Add Services
@endsection
@section('css')
@endsection
<link href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.2/dropzone.min.css" rel="stylesheet">
<meta name="csrf-token" content="{{ csrf_token() }}">
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
            <form id="" action="{{ route('admin.partners.store') }}" method="POST" enctype="multipart/form-data"
                class="form d-flex flex-column flex-lg-row">
                @csrf
                <!--begin::Aside column-->

                <!--end::Aside column-->
                <!--begin::Main column-->
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
                                                <label class="required form-label">Title-{{ $language->lang }}</label>
                                                <input type="text" name="title[{{ $language->small }}]"
                                                    class="form-control mb-2" placeholder="title {{ $language->small }}..."
                                                    value="" />
                                                @error('title[{{ $language->small }}]')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div>
                                                <label class="form-label">Description-{{ $language->lang }}</label>
                                                <textarea name="descriptions[{{ $language->small }}]" class="form-control ckeditor" required></textarea>

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
                <div class="d-flex flex-column gap-7 gap-lg-10 w-100 w-lg-300px mb-7 me-lg-10"
                    style="margin-left: 2rem; margin-top:5.5rem">
                    <!--begin::Thumbnail settings-->
                    <div class="card card-flush py-4">

                        <div class="card-header">

                            <!--begin::Card title-->
                            <div class="card-header">

                                <!--begin::Card title-->
                                <div class="card-title">
                                    <h2>File uplod</h2>
                                </div>
                                <!--end::Card title-->
                            </div>
                            <div class="card-body  pt-0">
                                <!--begin::Image input-->
                                <div class="image-input image-input-empty image-input-outline mb-3"
                                    data-kt-image-input="true"
                                    style="background-image: url(assets/media/svg/files/blank-image.svg)">
                                    <!--begin::Preview existing avatar-->
                                    <div id="my-dropzone" class="dropzone">
                                        <div class="fallback">
                                            <input name="file" type="file" />
                                        </div>
                                    </div>

                                </div>
                            </div>
                            <div class="card-body pt-0">
                                <!--begin::Select store template-->
                                <label for="kt_ecommerce_add_category_store_template" class="form-label">Add Link</label>
                                <input required type="text" class="form-control mb-2" name="link"
                                    placeholder="link..">
                            </div>

                        </div>
                    </div>
                    <input type="hidden" name="photo" id="image_name">
            </form>
        </div>
    </div>
@endsection
@section('js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.2/min/dropzone.min.js"></script>
    <script>
        Dropzone.autoDiscover = false;
        $(document).ready(function() {
            var csrfToken = $('meta[name="csrf-token"]').attr('content');

            var myDropzone = new Dropzone("#my-dropzone", {
                url: "{{ route('admin.partner.ajax') }}", // Upload yo'lini kiritish
                paramName: "file", // serverga fayl nomi
                maxFilesize: 5, // maksimal fayl hajmi (MB)
                acceptedFiles: ".jpeg,.jpg,.png,.gif,.webp", // qo'llaniladigan fayl turlari
                headers: {
                    'X-CSRF-TOKEN': csrfToken
                },
                maxFiles: 1, // faqat bitta rasm yuklash imkoniyati
                addRemoveLinks: true, // x tugmasi qo'shish
                init: function() {
                    this.on("success", function(file, response) {
                        if (response.success) {
                            // Dropzone orqali yuklangan rasm yo'lini formaga qo'shamiz
                            $('#image_name').val(response.success);
                        } else {
                            console.log(response);
                        }
                    });

                    this.on("error", function(file, response) {
                        if (typeof response === 'object') {
                            alert(JSON.stringify(response));
                        } else {
                            alert(response);
                        }
                    });

                    this.on("removedfile", function(file) {
                        // Rasm o'chirilganda yashirin inputni tozalaymiz
                        $('#image_name').val('');
                    });

                    // Eski rasmni ko'rsatish uchun
                    var existingPhotoUrl = $('#image_name').val();
                    if (existingPhotoUrl) {
                        var mockFile = {
                            name: existingPhotoUrl,
                            size: 12345
                        };
                        this.emit("addedfile", mockFile);
                        this.emit("thumbnail", mockFile, '{{ asset('storage') }}/' + existingPhotoUrl);
                        this.emit("complete", mockFile);
                    }
                }
            });
        });
    </script>
    <script src="//cdn.ckeditor.com/4.20.0/standard/ckeditor.js"></script>
    <script src="/admin/assets/bundles/select2/dist/js/select2.full.min.js"></script>

    <script type="text/javascript">
        CKEDITOR.replace('descriptions[{{ $language->small }}]', {
            filebrowserUploadUrl: "{{ route('admin.partner.upload', ['_token' => csrf_token()]) }}",
            filebrowserUploadMethod: 'form'
        });
    </script>
@endsection
