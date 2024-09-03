@extends('layouts.admin')
@section('title')
    Product Update
@endsection
@section('css')
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
    </style>
    <style>
        #image-preview {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
            margin-top: 20px;
        }

        .image-container {
            position: relative;
            width: 150px;
            height: 150px;
            border: 1px solid #ddd;
            border-radius: 15px;
            overflow: hidden;
            box-sizing: border-box;
        }

        .image-container img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: filter 0.3s ease;
        }

        .image-container:hover img {
            filter: blur(2px);
        }

        .image-details {
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            background: rgba(0, 0, 0, 0.5);
            color: white;
            text-align: center;
            padding: 5px;
            box-sizing: border-box;
            display: none;
        }

        .image-container:hover .image-details {
            display: block;
        }

        .remove-button {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background-color: red;
            color: white;
            border: none;
            border-radius: 50%;
            cursor: pointer;
            display: none;
            width: 30px;
            height: 30px;
            font-size: 16px;
            text-align: center;
            line-height: 30px;
        }

        .image-container:hover .remove-button {
            display: block;
        }
    </style>
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
            <form id="" action="{{ route('admin.products.update', $product->id) }}" method="POST"
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
                                    <!--begin::General options-->
                                    <div class="card card-flush py-4">
                                        <!--begin::Card header-->
                                        <div class="card-header">
                                            <div class="card-title">
                                                <h2>{{ $language->lang }}</h2>
                                            </div>
                                        </div>
                                        <!--end::Card header-->
                                        <!--begin::Card body-->
                                        <div class="card-body pt-0">
                                            <!--begin::Input group-->
                                            <div class="mb-10 fv-row">
                                                <!--begin::Label-->
                                                <label class="required form-label">Title-{{ $language->lang }}</label>

                                                <input type="text" name="title[{{ $language->small }}]"
                                                    class="form-control mb-2" placeholder="title {{ $language->small }}..."
                                                    value="{{ $product->title[$language->small] ?? ''}}" />
                                                @error('title[{{ $language->small }}]')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div>
                                                <!--begin::Label-->
                                                <label class="form-label">Description-{{ $language->lang }}</label>
                                                <textarea id="descriptions-{{ $language->small }}" name="descriptions[{{ $language->small }}]"
                                                    class="form-control ckeditor">{!! $product->descriptions[$language->small] ?? '' !!}</textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                        <div class="card card-flush py-4">
                            <div id="new-inputs-container">
                                <div class="input-row">
                                    <div class="form-group">
                                        @if(isset($product->optional_key['en']) && is_array($product->optional_key['en']))
                                        @foreach ($product->optional_key['en'] as $key)
                                            <input type="text" value="{{ $key }}" id="input-en-802"
                                                   required name="optional_key[en][]" class="form-control mb-1"
                                                   placeholder="Optional configuration English">
                                        @endforeach
                                    @endif
                                    </div>
                                    <div class="form-group">
                                        @if(isset($product->optional_key['ru']) && is_array($product->optional_key['ru']))
                                        @foreach ($product->optional_key['ru'] as $key)
                                            <input type="text" value="{{ $key }}" id="input-en-802"
                                                   required name="optional_key[ru][]" class="form-control mb-1"
                                                   placeholder="Optional configuration English">
                                        @endforeach
                                    @endif
                                    </div>
                                </div>
                            </div>
                            <button type="button" id="add-input-btn" class="btn btn-primary">Add Optional
                                Input</button><br>
                            <div id="new-inputs">
                                <div class="input-row">
                                    <div class="form-group">
                                        @if(isset($product->standard_key['en']) && is_array($product->standard_key['en']))
                                        @foreach ($product->standard_key['en'] as $key)
                                            <input type="text" value="{{ $key }}" id="input-en-802"
                                                   required name="standard_key[en][]" class="form-control mb-1"
                                                   placeholder="Optional configuration English">
                                        @endforeach
                                    @endif
                                    </div>
                                    <div class="form-group">
                                        @if(isset($product->standard_key['ru']) && is_array($product->standard_key['ru']))
                                        @foreach ($product->standard_key['ru'] as $key)
                                            <input type="text" value="{{ $key }}" id="input-en-802"
                                                   required name="standard_key[ru][]" class="form-control mb-1"
                                                   placeholder="Optional configuration English">
                                        @endforeach
                                    @endif
                                    </div>
                                </div>
                            </div>
                            <button type="button" id="add-input" class="btn btn-primary">Add standard Input</button>

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

                    <!--end::Tab content-->
                    <div class="d-flex justify-content-end">
                        <button type="submit" id="kt_ecommerce_add_product_submit" class="btn btn-primary">
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
                        <div class="card-header">
                            <!--begin::Card title-->
                            <div class="card-title">
                                <h2>Edit category</h2>
                            </div>
                        </div>
                        <div class="card-body pt-0">
                            <!--begin::Select2-->
                            <select class="form-select mb-2" data-control="select2" name="product_category_id"
                                id="kt_ecommerce_add_category_status_select">
                                <option value="{{ $product->category_id }}" selected="false" disabled="disabled">

                                    {{ $product->product_category->title['en'] }}</option>
                                @foreach ($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->title['en'] }}
                                @endforeach
                            </select>
                        </div>

                        <div class="card-body  pt-0">
                            <h1>test</h1>

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
                            <label for="kt_ecommerce_add_category_store_template" class="form-label">Select a
                                status</label>
                            <!--end::Select store template-->
                            <!--begin::Select2-->
                            <select class="form-select mb-2" data-control="select2" name="status"
                                data-hide-search="true" id="kt_ecommerce_add_category_store_template">
                                <option value="{{ $product->status }}" selected="false" disabled="disabled">
                                    {{ $product->status }}</option>
                                <option value="Active">Active</option>
                                <option value="Inacitve">Inacitve</option>
                                {{-- <option value="True">True</option>
                                <option value="False">False</option> --}}
                            </select>

                            <!--end::Description-->
                        </div>
                        <div class="card-body pt-0">
                            <label for="kt_ecommerce_add_category_store_template" class="form-label">Price</label>
                            <input required class="form-control mb-2" name="price" value="{{ $product->price }}"
                                placeholder="add price">
                        </div>


                        <div class="card-body pt-0">
                            <!--begin::Select store template-->
                            <label for="kt_ecommerce_add_category_store_template" class="form-label">popular</label>
                            <input type="checkbox" name="popular" class="custom-switch-input"
                                {{ $product->popular == 'active' ? 'checked' : '' }}>

                            <span class="custom-switch-indicator"></span>
                        </div>
                    </div>
                    <!--end::Thumbnail settings-->
                    <!--begin::Status-->

                </div>
                <!--end::Main column-->
            </form>
        </div>
        <!--end::Container  shu ishlashi kerak  edi   shuni  google dan ko'ring   mani  ishim chiqib qoldi  -->
    </div>


@endsection
@section('js')
<script>
    $(document).ready(function() {
        let languages = [
            @foreach ($languages as $language)
                {
                    small: "{{ $language->small }}",
                    lang: "{{ $language->lang }}"
                },
            @endforeach
        ];

        $('#add-input').click(function() {
            // Create a new row container for each set of language inputs
            let rowContainer = $('<div class="input-row"> <button type="button" class="btn btn-danger delete-input">X</button></div>');

            languages.forEach(function(language) {
                // Generate a unique ID for the input
                let inputId = 'input-' + language.small + '-' + Math.floor(Math.random() * 1000);

                // Create the input field with a delete button
                let inputHtml = `
                    <div class="form-group input-group mb-2">
                        <input required type="text" id="${inputId}" name="standard_key[${language.small}][]" class="form-control" placeholder="New Input for ${language.lang}">

                    </div>

                `;

                // Append the input field to the row container
                rowContainer.append(inputHtml);
            });

            // Append the row container to the new inputs container
            $('#new-inputs').append(rowContainer);
        });

        // Delegate event handler for dynamically created delete buttons
        $('#new-inputs').on('click', '.delete-input', function() {
            $(this).closest('.input-row').remove(); // Remove the entire row container (.input-row)
        });
    });
</script>
<script>
    $(document).ready(function() {
        let languages = [
            @foreach ($languages as $language)
                {
                    small: "{{ $language->small }}",
                    lang: "{{ $language->lang }}"
                },
            @endforeach
        ];

        $('#add-input-btn').click(function() {
            // Create a new row container for each set of language inputs
            let rowContainer = $('<div class="input-row"></div>');

            // Create the delete button for the row
            let deleteButton = $('<button type="button" class="btn btn-danger delete-input">X</button>');
            deleteButton.appendTo(rowContainer);

            languages.forEach(function(language) {
                // Generate a unique ID for the input
                let inputId = 'input-' + language.small + '-' + Math.floor(Math.random() * 1000);

                // Create the input field
                let inputHtml = `
                    <div class="form-group input-group mb-2">
                        <input type="text" id="${inputId}" name="optional_key[${language.small}][]" class="form-control" required placeholder="Optional configuration ${language.lang}">
                    </div>
                `;

                // Append the input field to the row container
                rowContainer.append(inputHtml);
            });

            // Append the row container to the new inputs container
            $('#new-inputs-container').append(rowContainer);
        });

        // Add delete button functionality for existing and future rows
        $('#new-inputs-container').on('click', '.delete-input', function() {
            $(this).closest('.input-row').remove(); // Remove the entire input row container
        });
    });
</script>


    <script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.5.1/min/dropzone.min.js"></script>
    <script>
        let uploadedDocumentMap = {};
        Dropzone.autoDiscover = false;
        let myDropzone = new Dropzone("div#document-dropzone", {
            url: '{{ route('admin.uploadImageViaAjax') }}',
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
                @if ($product->photo)
                    var existingImages = {!! json_encode($product->photo) !!};
                    existingImages.forEach(function(image) {
                        var mockFile = {
                            name: image,
                            size: null,
                            file_name: image
                        };
                        dz.emit("addedfile", mockFile);
                        dz.emit("thumbnail", mockFile, '{{ asset('/site/images/products/') }}' + '/' +
                            image);
                        dz.emit("complete", mockFile);
                        $('form').append('<input type="hidden" name="photo[]" value="' + image + '">');
                        uploadedDocumentMap[mockFile.name] = image;
                    });
                @endif
            }
        });
    </script>


    <script src="//cdn.ckeditor.com/4.20.0/standard/ckeditor.js"></script>
    <script src="/admin/assets/bundles/select2/dist/js/select2.full.min.js"></script>
    <script type="text/javascript">
        @foreach ($languages as $language)
            CKEDITOR.replace('descriptions-{{ $language->small }}', {
                filebrowserUploadUrl: "{{ route('admin.faq.upload', ['_token' => csrf_token()]) }}",
                filebrowserUploadMethod: 'form'
            });
        @endforeach
    </script>
@endsection
