@extends('layouts.admin')
@section('title')
Sertificates    
@endsection

@section('content')
    <div class="menu-item px-3">

        <div class="menu-content px-3 py-3">
            <a href="#" class="btn btn-primary er fs-6 px-4 py-4" data-bs-toggle="modal"
                data-bs-target="#kt_modal_new_address">Add Sertificate</a>
        </div>
    </div>
    <div class="card mb-5 mb-xl-8">
        <!--begin::Header-->
        <div class="card-header border-0 pt-5">
            <h3 class="card-title align-items-start flex-column">
                <span class="card-label fw-bolder fs-3 mb-1">Sertificates</span>
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
                            <th class="min-w-200px">Sertificate</th>
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
                        @foreach ($sertificates as $sertificate)
                            <tr>
                                <!--begin::Checkbox-->
                                <td>
                                    <div class="form-check form-check-sm form-check-custom form-check-solid">
                                        <input class="form-check-input" type="checkbox" value="1" />
                                    </div>
                                </td>
                                <!--end::Checkbox-->
                                <!--begin::Category=-->
                                <td>
                                    <div class="d-flex align-items-center">

                                        <a href="{{ asset($sertificate->photo) }}" target="_blank"
                                            class="symbol symbol-50px">
                                            @if (in_array(pathinfo($sertificate->photo, PATHINFO_EXTENSION), ['jpeg', 'png', 'jpg']))
                                                <span class="symbol-label"
                                                    style="background-image:url({{ asset($sertificate->photo) }});"></span>
                                            @elseif (pathinfo($sertificate->photo, PATHINFO_EXTENSION) == 'pdf')
                                                <span><embed src="{{ asset($sertificate->photo) }}" type="application/pdf"
                                                        width="100%" height="200px" />Download</span>
                                            @endif
                                        </a>


                                    </div>
                                </td>
                                <!--end::Category=-->
                                <!--begin::SKU=-->
                                <td class="text-end pe-0">
                                    <span class="fw-bolder">{{ $sertificate->title['uz'] }}</span>
                                </td>
                                <td class="text-end pe-0" data-order="25">
                                    <span class="fw-bolder ms-3">{{ $sertificate->created_at }}</span>
                                </td>
                                <!--end::Status=-->
                                <!--begin::Action=-->
                                <td class="text-end">
                                    <form class=""
                                        action="{{ route('admin.sertificate.destroy', ['id' => $sertificate->id]) }}"
                                        method="post">
                                        @csrf
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
                    action="{{ route('admin.sertificate.store') }}" enctype="multipart/form-data">

                    @csrf
                    <!--begin::Modal header-->
                    <div class="card-body  pt-0">
                        <div class="modal-header" id="kt_modal_new_address_header">
                            <!--begin::Modal title-->
                            <h2>Add Sertificates</h2>
                            <!--end::Modal title-->
                            <!--begin::Close-->
                            <div class="btn btn-sm btn-icon btn-active-color-primary" data-bs-dismiss="modal">
                                <!--begin::Svg Icon | path: icons/duotune/arrows/arr061.svg-->
                                <span class="svg-icon svg-icon-1">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none">
                                        <rect opacity="0.5" x="6" y="17.3137" width="16" height="2" rx="1"
                                            transform="rotate(-45 6 17.3137)" fill="currentColor" />
                                        <rect x="7.41422" y="6" width="16" height="2" rx="1"
                                            transform="rotate(45 7.41422 6)" fill="currentColor" />
                                    </svg>
                                </span>
                                <!--end::Svg Icon-->
                            </div>
                            <!--end::Close-->
                        </div>
                    </div>
                    <!--begin::Modal body-->
                    <div class="modal-body py-10 px-lg-17">
                        <!--begin::Scroll-->
                        <div class="scroll-y me-n7 pe-7" id="kt_modal_new_address_scroll" data-kt-scroll="true"
                            data-kt-scroll-activate="{default: false, lg: true}" data-kt-scroll-max-height="auto"
                            data-kt-scroll-dependencies="#kt_modal_new_address_header"
                            data-kt-scroll-wrappers="#kt_modal_new_address_scroll" data-kt-scroll-offset="300px">

                            <div class="row mb-5">
                                <!--begin::Col-->

                                <div class="card-body  pt-0">
                                    <div class="image-input image-input-empty image-input-outline mb-3"
                                        data-kt-image-input="true"
                                        style="background-image: url(assets/media/svg/files/blank-image.svg)">
                                        <!--begin::Preview existing avatar-->
                                        <div class="image-input-wrapper w-150px h-150px"></div>
                                        <!--end::Preview existing avatar-->
                                        <!--begin::Label-->
                                        <label
                                            class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow"
                                            data-kt-image-input-action="change" data-bs-toggle="tooltip"
                                            title="Change avatar">
                                            <!--begin::Icon-->
                                            <i class="bi bi-pencil-fill fs-7"></i>
                                            <input type="file" name="photo" />
                                            <input type="hidden" name="avatar_remove" />
                                        </label>
                                        <span
                                            class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow"
                                            data-kt-image-input-action="cancel" data-bs-toggle="tooltip"
                                            title="Cancel avatar">
                                            <i class="bi bi-x fs-2"></i>
                                        </span>
                                        <span
                                            class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow"
                                            data-kt-image-input-action="remove" data-bs-toggle="tooltip"
                                            title="Remove avatar">
                                            <i class="bi bi-x fs-2"></i>
                                        </span>
                                        <!--end::Remove-->
                                    </div>


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
    <script src="/assets/plugins/global/plugins.bundle.js"></script>
    <script src="/assets/js/scripts.bundle.js"></script>
@endsection
