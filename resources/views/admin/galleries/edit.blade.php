text/x-generic edit.blade.php ( HTML document, ASCII text )
@extends('layouts.admin')
@section('title')
    Banner Update
@endsection
@section('css')
@endsection
<link href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.2/dropzone.min.css" rel="stylesheet">
<meta name="csrf-token" content="{{ csrf_token() }}">
@section('content')
    <div class="post d-flex flex-column-fluid" id="kt_post">
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
    </div>
    <div id="kt_content_container" class="container-xxl">
        <form id="" action="{{ route('admin.banners.update', $banner->id) }}" method="post"
            enctype="multipart/form-data" class="form d-flex flex-column flex-lg-row">
            @csrf
            @method('PUT')
            <div class="d-flex flex-column flex-row-fluid gap-7 gap-lg-10">
                <div class="card-body pt-0">
                    <!--begin::Select store template-->
                    <label for="kt_ecommerce_add_category_store_template" class="form-label">Select</label>
                    <!--end::Select store template-->
                    <!--begin::Select2-->
                    <select class="form-select mb-2" data-control="select2" name="select" data-hide-search="true"
                        data-placeholder="Select an option" id="kt_ecommerce_add_category_store_template">
                        <option value="banner">Banner</option>
                        <option value="gallery">Gallery</option>
                    </select>
                    <div class="text-muted fs-7">Set the product category status.</div>
                </div>
                <div class="tab-content">
                    <div class="form-group">
                        <label for="photo">Photo</label>
                        <input type="hidden" name="photo" id="image_name" value="{{ $banner->photo }}">
                        <div id="my-dropzone" class="dropzone"></div>
                    </div>

                </div>

                {{-- @foreach ($languages as $language)
                <div class="col-md-5 fv-row">
                    <!--end::Label-->
                    <label class="required fs-5 fw-bold mb-2">Title {{ $language->small }}</label>
                    <input type="text" class="form-control form-control-solid" id="input-text-1"
                        name="title[{{ $language->small }}]" type="text" value="{{$banner->title[$language->small]}}"
                        @error('lang') is-invalid @enderror
                        placeholder="title {{ $language->small }}..." data-bs-original-title=""
                        title="" required>
                    @error('small')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            @endforeach --}}
                <div class="d-flex justify-content-end">
                    <button type="submit" id="kt_ecommerce_add_product_submit" class="btn btn-primary">
                        <span class="indicator-label">Save </span>
                        <span class="indicator-progress">Please wait...
                            <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                    </button>
                </div>

            </div>

        </form>
    </div>
    {{-- <input type="hidden" name="photo" id="image_name"> --}}
    </div>

@endsection
@section('js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.2/min/dropzone.min.js"></script>
    <script>
        Dropzone.autoDiscover = false;
        $(document).ready(function() {
            var csrfToken = $('meta[name="csrf-token"]').attr('content');

            var myDropzone = new Dropzone("#my-dropzone", {
                url: "{{ route('admin.banners.ajax') }}", // Upload yo'lini kiritish
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
        CKEDITOR.replace('descriptions', {
            filebrowserUploadUrl: "{{ route('admin.partner.upload', ['_token' => csrf_token()]) }}",
            filebrowserUploadMethod: 'form'
        });
    </script>
@endsection
