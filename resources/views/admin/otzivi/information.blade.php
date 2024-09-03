@extends('layouts.admin')
@section('title')
    Information Update
@endsection
@section('css')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.2/dropzone.min.css" rel="stylesheet">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        .input-row {
            display: flex;
            gap: 20px;
            /* Adjust the gap as needed */
            margin-bottom: 20px;
            /* Space between rows */
        }

        .form-group {
            flex: 1;
            /* Make sure each form group takes up equal space */
        }
        .custom-alert {
            position: fixed;
            background-color: #0BB783;
            top: 20px;
            right: 20px;
            z-index: 1050;
            min-width: 200px;
            max-width: 300px;
            padding: 10px;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
            opacity: 1;
            transition: opacity 0.5s ease-in-out;
        }

        .custom-alert.fade-out {
            opacity: 0;
        }
    </style>

@endsection

@section('content')
    {{-- <h1 class="text-uppercase mb-4">Add category</h1> --}}

    {{-- <a href="{{ route('admin.categories.index') }}" class="btn btn-success mb-3 text-white">Back Page</a> --}}

    @if (session('success'))
        <div class="alert alert-success alert-dismissible show fade custom-alert">
            <div class="alert-body">
                <button class="close" data-dismiss="alert">
                    <span>✅</span>
                </button>
                {{ session('success') }}
            </div>
        </div>
    @endif

    <div class="post d-flex flex-column-fluid" id="kt_post">
        <!--begin::Container-->
        <div id="kt_content_container" class="container-xxl">
            <form id="" action="{{ route('admin.information.store', $information->id) }}" method="post"
                  enctype="multipart/form-data" class="form d-flex flex-column flex-lg-row">
                @csrf
                @method('PUT')
                <div class="d-flex flex-column flex-row-fluid gap-7 gap-lg-10">
                    <div class="tab-content">

                        <div class="card card-flush py-4">

                            <div class="card-header">
                                <div class="card-title">
                                    <h2>Photo</h2>
                                </div>
                            </div>
                            <div class="dz-message needsclick">
                                <div class="ms-4">
                                    <div class="dropzone" id="document-dropzone"></div>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="d-flex justify-content-end">
                        <button type="submit" id="kt_ecommerce_add_information_submit" class="btn btn-primary">
                            <span class="indicator-label">Save Changes</span>
                            <span class="indicator-progress">Please wait...
                                <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                        </button>
                        <!--end::Button-->
                    </div>
                </div>
                <div class="d-flex flex-column gap-7 gap-lg-10 w-100 w-lg-300px mb-7 me-lg-10"
                     style="margin-left: 2rem; margin-top:5.5rem">
                    <!--begin::Thumbnail settings-->
                    <div class="card card-flush py-4">
                        <!--end::Card header-->
                        <!--begin::Card body-->
                        <div class="card-body pt-0">
                            <label for="kt_ecommerce_add_category_store_template" class="form-label">Phone</label>
                            <input type="number" class="form-control mb-2" name="phone" value="{{ $information->phone}}">
                        </div>
                        <div class="card-body pt-0">
                            <label for="kt_ecommerce_add_category_store_template" class="form-label">Project completed</label>
                            <input type="number" class="form-control mb-2" name="project_completed" value="{{ $information->project_completed}}">
                        </div>
                        <div class="card-body pt-0">
                            <label for="kt_ecommerce_add_category_store_template" class="form-label">Client satisfied</label>
                            <input type="number" class="form-control mb-2" name="client_satisfied" value="{{ $information->client_satisfied}}">
                        </div>
                        <div class="card-body pt-0">
                            <label for="kt_ecommerce_add_category_store_template" class="form-label">Design Project</label>
                            <input type="number" class="form-control mb-2" name="design_project" value="{{ $information->design_project}}">
                        </div>
                        <div class="card-body pt-0">
                            <label for="kt_ecommerce_add_category_store_template" class="form-label">Telegram</label>
                            <input type="url" class="form-control mb-2" name="telegram" value="{{ $information->telegram}}">
                        </div>
                        <div class="card-body pt-0">
                            <label for="kt_ecommerce_add_category_store_template" class="form-label">Instagram</label>
                            <input type="url" class="form-control mb-2" name="instagram" value="{{ $information->instagram}}">
                        </div>
                        <div class="card-body pt-0">
                            <label for="kt_ecommerce_add_category_store_template" class="form-label">Youtube</label>
                            <input type="url" class="form-control mb-2" name="youtube" value="{{ $information->youtube}}">
                        </div>
                        <div class="card-body pt-0">
                            <label for="kt_ecommerce_add_category_store_template" class="form-label">Linkedln</label>
                            <input type="text" class="form-control mb-2" name="linkedln" value="{{ $information->linkedln}}">
                        </div>

                    </div>
                </div>
            </form>
        </div>
    </div>


@endsection
@section('js')

    <script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.5.1/min/dropzone.min.js"></script>
    <script>
        let uploadedDocumentMap = {};
        Dropzone.autoDiscover = false;
        let myDropzone = new Dropzone("div#document-dropzone", {
            url: '{{ route('admin.information.ajax') }}',
            autoProcessQueue: true,
            uploadMultiple: true,
            addRemoveLinks: true,
            parallelUploads: 15,
            headers: {
                'X-CSRF-TOKEN': "{{ csrf_token() }}"
            },
            successmultiple: function(files, response) {
                $.each(response['name'], function(key, val) {
                    $('form').append('<input type="hidden" name="photo[]" value="' + val + '">');
                    uploadedDocumentMap[files[key].name] = val;
                });
            },
            removedfile: function(file) {
                file.previewElement.remove();
                let name = '';
                if (typeof file.file_name !== 'undefined') {
                    name = file.file_name;
                } else {
                    name = uploadedDocumentMap[file.name];
                }
                $('form').find('input[name="photo[]"][value="' + name + '"]').remove();
            },
            init: function() {
                var dz = this;
                @if ($information->photo)
                var existingImages = {!! json_encode($information->photo) !!};
                existingImages.forEach(function(image) {
                    var mockFile = {
                        name: image,
                        size: null,
                        file_name: image
                    };
                    dz.emit("addedfile", mockFile);
                    dz.emit("thumbnail", mockFile, '{{ asset('/site/images/info/') }}' + '/' +
                        image);
                    dz.emit("complete", mockFile);
                    $('form').append('<input type="hidden" name="photo[]" value="' + image + '">');
                    uploadedDocumentMap[mockFile.name] = image;
                });
                @endif
            }
        });
        document.addEventListener("DOMContentLoaded", function() {
            var alertElement = document.querySelector('.custom-alert');
            if (alertElement) {
                setTimeout(function() {
                    alertElement.classList.add('fade-out');
                    setTimeout(function() {
                        alertElement.remove();
                    }, 500); // 500ms ni xabarni yo'q qilish uchun
                }, 5000); // 5 soniyadan keyin fade-out qo'shiladi
            }
        });
    </script>



@endsection
