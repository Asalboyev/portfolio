@extends('layouts.admin')
@section('title')
    Gallery
@endsection

@section('content')
    <div class="menu-item px-3">

        <div class="menu-content px-3 py-3">
            <a href="#" class="btn btn-primary er fs-6 px-4 py-4" data-bs-toggle="modal"
                data-bs-target="#kt_modal_new_address">Add gallery</a>
        </div>
    </div>
    <div class="card mb-5 mb-xl-8">
        <!--begin::Header-->
        <div class="card-header border-0 pt-5">
            <h3 class="card-title align-items-start flex-column">
                <span class="card-label fw-bolder fs-3 mb-1">Gallery</span>
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
                            <th class="w-10px pe-2">
                                <div class="form-check form-check-sm form-check-custom form-check-solid me-3">
                                    <input class="form-check-input" type="checkbox" data-kt-check="true"
                                        data-kt-check-target="#kt_ecommerce_products_table .form-check-input"
                                        value="1" />
                                </div>
                            </th>
                            <th class="min-w-200px">Video</th>
                            <th class="text-end min-w-100px">Gallery</th>
                            <th class="text-end min-w-100px">Title</th>
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
                                <td>
                                    <div class="form-check form-check-sm form-check-custom form-check-solid">
                                        <input class="form-check-input" type="checkbox" value="1" />
                                    </div>
                                </td>
                                <td>

                                    <a href="{{ asset($gallery->videos) }}" target="_blank" class="symbol symbol-50px">
                                        <video width="200" height="180 " controls>
                                            <source src="{{ asset($gallery->videos) }}" type="video/mp4">
                                            Your browser does not support the video tag.
                                        </video>
                                    </a>
                                </td>
                                <td class="text-end pe-0" data-order="25">
                                    <a href="{{ asset($gallery->photo) }}" target="_blank" class="symbol symbol-50px">
                                        <span class="symbol-label"
                                            style="background-image:url({{ asset($gallery->photo) }});"></span>
                                    </a>

                                </td>
                                <td class="text-end pe-0">
                                    <span class="fw-bolder">{{ $gallery->title['uz'] }}</span>
                                </td>
                                <td class="text-end pe-0" data-order="25">
                                    <span class="fw-bolder ms-3">{{ $gallery->created_at }}</span>
                                </td>
                                <!--end::Status=-->
                                <!--begin::Action=-->
                                <td class="text-end">
                                    <form class="" action="{{ route('admin.galleries.destroy', $gallery->id) }}"
                                        method="post">
                                        @csrf
                                        @method('DELETE')
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
                    action="{{ route('admin.galleries.store') }}" enctype="multipart/form-data">

                    @csrf
                    <div class="modal-body py-10 px-lg-17">
                        <!--begin::Scroll-->
                        <div class="scroll-y me-n7 pe-7" id="kt_modal_new_address_scroll" data-kt-scroll="true"
                            data-kt-scroll-activate="{default: false, lg: true}" data-kt-scroll-max-height="auto"
                            data-kt-scroll-dependencies="#kt_modal_new_address_header"
                            data-kt-scroll-wrappers="#kt_modal_new_address_scroll" data-kt-scroll-offset="300px">

                            <div class="row mb-5">
                                <!--begin::Col-->
                                <div class="col-md-6 fv-row">

                                    <label for="file1">Photo:</label>
                                    <input type="file" name="photo" id="file1" accept="image/*"
                                        onchange="previewFile('file1', 'preview1')">
                                </div>
                                <br>
                                <div class="col-md-6 fv-row">

                                    <label for="file2">Video 2:</label>
                                    <input type="file" name="videos" id="file2"
                                        onchange="previewFile('file2', 'preview2')">
                                </div>
                                <br>
                                <div class="col-md-6 fv-row">
                                    <div id="preview1"></div>
                                </div>
                                <div class="col-md-6 fv-row">
                                    <div id="preview2"></div>
                                </div>


                                @foreach ($languages as $language)
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
                                @endforeach
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
                <!--end::Form-->
            </div>
        </div>
    </div>
@endsection
@section('js')
    <script>
        function previewFile(inputId, previewId) {
            const preview = document.getElementById(previewId);
            const file = document.getElementById(inputId).files[0];
            const reader = new FileReader();

            reader.addEventListener("load", function() {
                if (file.type.startsWith('video/')) {
                    const video = document.createElement('video');
                    video.src = reader.result;
                    video.width = 320;
                    video.height = 240;
                    video.controls = true;
                    preview.innerHTML = '';
                    preview.appendChild(video);
                } else if (file.type.startsWith('image/')) {
                    const img = document.createElement('img');
                    img.src = reader.result;
                    img.width = 320;
                    img.height = 240;
                    preview.innerHTML = '';
                    preview.appendChild(img);
                }
            }, false);

            if (file) {
                reader.readAsDataURL(file);
            }
        }
    </script>
    <script src="/assets/plugins/global/plugins.bundle.js"></script>
    <script src="/assets/js/scripts.bundle.js"></script>
@endsection
