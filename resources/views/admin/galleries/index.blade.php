text/x-generic index.blade.php ( HTML document, ASCII text, with very long lines )
@extends('layouts.admin')
@section('title')
    Banner
@endsection
<link href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.2/dropzone.min.css" rel="stylesheet">
<meta name="csrf-token" content="{{ csrf_token() }}">
@section('content')

    <div class="menu-item px-3">
        <div class="menu-content px-3 py-3">
            <a href="#" class="btn btn-primary er fs-6 px-4 py-4" data-bs-toggle="modal"
                data-bs-target="#kt_modal_new_address">Add Banner</a>
        </div>
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
        <div class="card mb-5 mb-xl-8">

            <div class="card-header border-0 pt-5">
                <h3 class="card-title align-items-start flex-column">
                    <span class="card-label fw-bolder fs-3 mb-1">Banner</span>
                    <span class="text-muted mt-1 fw-bold fs-7">Over 500 orders</span>
                </h3>

            </div>
            <!--end::Header-->
            <!--begin::Body-->
            <div class="card-body py-3">
                <!--begin::Table container-->
                <div class="card-body pt-0">
                    <!--begin::Table-->
                    <table class="table align-middle table-row-dashed fs-6 gy-5" id="kt_ecommerce_products_table">
                        <!--begin::Table head-->
                        <thead>
                            <!--begin::Table row-->
                            <tr class="text-start text-gray-400 fw-bolder fs-7 text-uppercase gs-0">
                                <th class="w-10px pe-2"># </th>
                                {{-- <th class="min-w-200px">Video</th> --}}
                                <th class="text-end min-w-100px">Banners</th>
                                {{-- <th class="text-end min-w-100px">Title</th> --}}
                                <th class="text-end min-w-70px">Created time</th>
                                <th class="text-end min-w-70px">Actions</th>
                            </tr>
                            <!--end::Table row-->
                        </thead>
                        <!--end::Table head-->
                        <!--begin::Table body-->
                        <tbody class="fw-bold text-gray-600">
                            <!--begin::Table row-->
                            @foreach ($galleries as $gallery)
                                <tr>
                                    <!--begin::Checkbox-->
                                    <td>{{ $loop->iteration }}</td>
                                    {{-- <td>

                                    <a href="{{ asset($gallery->videos) }}" target="_blank" class="symbol symbol-50px">
                                        <video width="200" height="180 " controls>
                                            <source src="{{ asset($gallery->videos) }}" type="video/mp4">
                                            Your browser does not support the video tag.
                                        </video>
                                    </a>
                                </td> --}}
                                    <td class="text-end pe-0" data-order="25">
                                        <a href="{{ asset($gallery->photo) }}" target="_blank" class="symbol symbol-50px">
                                            <span class="symbol-label"
                                                style="background-image:url({{ asset('storage/' . ($gallery->photo ?? 'default.jpg')) }});"></span>
                                        </a>

                                    </td>
                                    {{-- <td class="text-end pe-0">
                                    <span class="fw-bolder">{{ $gallery->title['en'] }}</span>
                                </td> --}}
                                    <td class="text-end pe-0" data-order="25">
                                        <span class="fw-bolder ms-3">{{ $gallery->created_at }}</span>
                                    </td>
                                    <!--end::Status=-->
                                    <!--begin::Action=-->
                                    <td class="text-end">

                                        <form class="" action="{{ route('admin.banners.destroy', $gallery->id) }}"
                                            method="post">
                                            @csrf
                                            @method('DELETE')
                                            <a href="{{ route('admin.banners.edit', $gallery->id) }}"
                                                class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm me-1">
                                                <!--begin::Svg Icon | path: icons/duotune/art/art005.svg-->
                                                <span class="svg-icon svg-icon-3">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                        viewBox="0 0 24 24" fill="none">
                                                        <path opacity="0.3"
                                                            d="M21.4 8.35303L19.241 10.511L13.485 4.755L15.643 2.59595C16.0248 2.21423 16.5426 1.99988 17.0825 1.99988C17.6224 1.99988 18.1402 2.21423 18.522 2.59595L21.4 5.474C21.7817 5.85581 21.9962 6.37355 21.9962 6.91345C21.9962 7.45335 21.7817 7.97122 21.4 8.35303ZM3.68699 21.932L9.88699 19.865L4.13099 14.109L2.06399 20.309C1.98815 20.5354 1.97703 20.7787 2.03189 21.0111C2.08674 21.2436 2.2054 21.4561 2.37449 21.6248C2.54359 21.7934 2.75641 21.9115 2.989 21.9658C3.22158 22.0201 3.4647 22.0084 3.69099 21.932H3.68699Z"
                                                            fill="currentColor"></path>
                                                        <path
                                                            d="M5.574 21.3L3.692 21.928C3.46591 22.0032 3.22334 22.0141 2.99144 21.9594C2.75954 21.9046 2.54744 21.7864 2.3789 21.6179C2.21036 21.4495 2.09202 21.2375 2.03711 21.0056C1.9822 20.7737 1.99289 20.5312 2.06799 20.3051L2.696 18.422L5.574 21.3ZM4.13499 14.105L9.891 19.861L19.245 10.507L13.489 4.75098L4.13499 14.105Z"
                                                            fill="currentColor"></path>
                                                    </svg>
                                                </span>
                                                <!--end::Svg Icon-->
                                            </a>
                                            <button type="submit"
                                                class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm">
                                                <!--begin::Svg Icon | path: icons/duotune/general/gen027.svg-->
                                                <span class="svg-icon svg-icon-3">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                        viewBox="0 0 24 24" fill="none">
                                                        <path
                                                            d="M5 9C5 8.44772 5.44772 8 6 8H18C18.5523 8 19 8.44772 19 9V18C19 19.6569 17.6569 21 16 21H8C6.34315 21 5 19.6569 5 18V9Z"
                                                            fill="currentColor" />
                                                        <path opacity="0.5"
                                                            d="M5 5C5 4.44772 5.44772 4 6 4H18C18.5523 4 19 4.44772 19 5V5C19 5.55228 18.5523 6 18 6H6C5.44772 6 5 5.55228 5 5V5Z"
                                                            fill="currentColor" />
                                                        <path opacity="0.5"
                                                            d="M9 4C9 3.44772 9.44772 3 10 3H14C14.5523 3 15 3.44772 15 4V4H9V4Z"
                                                            fill="currentColor" />
                                                    </svg>
                                                </span>
                                            </button>
                                        </form>
                                    </td>
                                    <!--end::Action=-->
                                </tr>
                            @endforeach
                        </tbody>
                        <!--end::Table body-->
                    </table>
                    <!--end::Table-->
                </div>
                <!--end::Table container-->
            </div>
            <!--begin::Body-->
        </div>
        <div class="modal fade" id="kt_modal_new_address" tabindex="-1" aria-hidden="true">
            <!--begin::Modal dialog-->
            <div class="modal-dialog modal-dialog-centered mw-650px">
                <!--begin::Modal content-->
                <div class="modal-content">
                    <!--begin::Form-->

                    <form class="form" id="kt_modal_new_address_form" method="POST"
                        action="{{ route('admin.banners.store') }}" enctype="multipart/form-data">

                        @csrf
                        <div class="modal-body py-10 px-lg-17">
                            <!--begin::Scroll-->
                            <div class="scroll-y me-n7 pe-7" id="kt_modal_new_address_scroll" data-kt-scroll="true"
                                data-kt-scroll-activate="{default: false, lg: true}" data-kt-scroll-max-height="auto"
                                data-kt-scroll-dependencies="#kt_modal_new_address_header"
                                data-kt-scroll-wrappers="#kt_modal_new_address_scroll" data-kt-scroll-offset="300px">

                                <div class="card-body pt-0">
                                    <!--begin::Select store template-->
                                    <label for="kt_ecommerce_add_category_store_template" class="form-label">Select</label>
                                    <!--end::Select store template-->
                                    <!--begin::Select2-->
                                    <select class="form-select mb-2" data-control="select2" name="select"
                                        data-hide-search="true" data-placeholder="Select an option"
                                        id="kt_ecommerce_add_category_store_template">
                                        <option value="banner">Banner</option>
                                        <option value="gallery">Gallery</option>
                                    </select>
                                    <div class="text-muted fs-7">Set the product category status.</div>
                                </div>
                                <div class="row mb-5">
                                    <!--begin::Col-->
                                    <div id="my-dropzone" class="dropzone">
                                        <div class="fallback">
                                            <input required name="photo" type="file" />
                                        </div>
                                    </div>
                                    <br>
                                    <br>


                                    {{-- @foreach ($languages as $language)
                                    <div class="col-md-6 fv-row">
                                        <!--end::Label-->
                                        <label class="required fs-5 fw-bold mb-2">Title {{ $language->small }}</label>

                                        <input type="text" class="form-control form-control-solid" id="input-text-1"
                                            name="title[{{ $language->small }}]" type="text"
                                            @error('lang') is-invalid @enderror
                                            placeholder="title {{ $language->small }}..." data-bs-original-title=""
                                            title="" required>
                                        @error('small')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                @endforeach --}}
                                </div>
                            </div>
                            <div class="modal-footer flex-center">
                                <!--begin::Button-->
                                <button type="reset" id="kt_modal_new_address_cancel"
                                    class="btn btn-light me-3">Discard</button>
                                <!--end::Button-->
                                <!--begin::Button-->
                                <button type="submit" id="kt_modal_new_address_submit" class="btn btn-primary">
                                    <span class="indicator-label">Submit</span>
                                    <span class="indicator-progress">Please wait...
                                        <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                                </button>
                                <!--end::Button-->
                            </div>
                            <!--end::Modal footer-->
                    </form>
                    <input type="hidden" required name="photo" id="image_name">
                </div>
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
        <script src="/assets/plugins/global/plugins.bundle.js"></script>
        <script src="/assets/js/scripts.bundle.js"></script>
    @endsection
