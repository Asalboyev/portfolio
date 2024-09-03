@extends('layouts.admin')
@section('title')
    Search Category
@endsection
@section('css')
    <style>
        body {
        font-family: Arial, sans-serif;
        background-color: #f4f4f4;
        margin: 0;
        padding: 0;
        }

        .container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 20px;
        background-color: #fff;
        box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }


        .tags {
        display: flex;
        flex-wrap: wrap;
        gap: 5px;
        }

        .tags span {
        background-color: #e0f0ff;
        color: #0066cc;
        padding: 5px 10px;
        border-radius: 5px;
        font-size: 13px;
        }

        </style>
    @endsection
    @section('content')
        <div class="post d-flex flex-column-fluid" id="kt_post">
            <!--begin::Container-->
            <div id="kt_content_container" class="container-xxl">
                <!--begin::Products-->
                <div class="card card-flush">
                    <!--begin::Card header-->
                    <div class="card-header align-items-center py-9 gap-2 gap-md-9">
                        <!--begin::Card title-->
                        <div class="card-title">
                            <!--begin::Search-->
                            <div class="d-flex align-items-center position-relative my-1">
                                <!--begin::Svg Icon | path: icons/duotune/general/gen021.svg-->
                                <span class="svg-icon svg-icon-1 position-absolute ms-4">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                        fill="none">
                                        <rect opacity="0.5" x="17.0365" y="15.1223" width="8.15546" height="2"
                                            rx="1" transform="rotate(45 17.0365 15.1223)" fill="currentColor" />
                                        <path
                                            d="M11 19C6.55556 19 3 15.4444 3 11C3 6.55556 6.55556 3 11 3C15.4444 3 19 6.55556 19 11C19 15.4444 15.4444 19 11 19ZM11 5C7.53333 5 5 7.53333 5 11C5 14.4667 7.53333 17 11 17C14.4667 17 17 14.4667 17 11C17 7.53333 14.4667 5 11 5Z"
                                            fill="currentColor" />
                                    </svg>
                                </span>
                                <!--end::Svg Icon-->
                                <form class="navbar-search form-inline mb-4 w-50 d-flex"
                                    action="{{ route('admin.categories.search') }}" method="post">
                                    @csrf
                                    <div class="d-flex align-items-center position-relative my-1">
                                        <!--begin::Svg Icon | path: icons/duotune/general/gen021.svg-->
                                        <span class="svg-icon svg-icon-1 position-absolute ms-4">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                viewBox="0 0 24 24" fill="none">
                                                <rect opacity="0.5" x="17.0365" y="15.1223" width="8.15546" height="2"
                                                    rx="1" transform="rotate(45 17.0365 15.1223)"
                                                    fill="currentColor" />
                                                <path
                                                    d="M11 19C6.55556 19 3 15.4444 3 11C3 6.55556 6.55556 3 11 3C15.4444 3 19 6.55556 19 11C19 15.4444 15.4444 19 11 19ZM11 5C7.53333 5 5 7.53333 5 11C5 14.4667 7.53333 17 11 17C14.4667 17 17 14.4667 17 11C17 7.53333 14.4667 5 11 5Z"
                                                    fill="currentColor" />
                                            </svg>
                                        </span>
                                        <input type="text" data-kt-ecommerce-order-filter="search"
                                            class="form-control form-control-solid w-250px ps-14" name="search"
                                            placeholder="Search Order" />
                                        {{-- <input type="text" class="form-control" placeholder="Search..." name="search"> --}}

                                    </div>
                                </form>
                            </div>
                            <!--end::Search-->
                        </div>
                        <!--end::Card title-->
                        <!--begin::Card toolbar-->
                        <div class="card-toolbar flex-row-fluid justify-content-end gap-5">
                        </div>
                        <!--end::Card toolbar-->
                    </div>
                    <!--end::Card header-->
                    <!--begin::Card body-->
                    <div class="card-body pt-0">
                        <!--begin::Table-->
                        <table class="table align-middle table-row-dashed fs-6 gy-5" id="kt_ecommerce_sales_table">
                            <!--begin::Table head-->
                            <thead>
                                <tr class="text-start text-gray-400 fw-bolder fs-7 text-uppercase gs-0">
                                    <th class="min-w-100px">#</th>
                                    <th class="min-w-100px">Title</th>
                                    <th class="min-w-100px">Status</th>
                                    <th class="min-w-100px">Subcategories</th>
                                    <th scope="min-w-120p">ACTIONS</th>

                                </tr>
                            </thead>
                            <!--end::Table head-->
                            <!--begin::Table body-->
                            <tbody>
                                @foreach ($result as $category)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>
                                            <img src="{{ asset($category->photo) }}" width="50">
                                            {{ $category->title['uz'] }}
                                        </td>

                                        <td  data-order="Published">
                                            @if ($category->status === 'Active')
                                                <div class="badge badge-light-success">{{ $category->status }}</div>
                                            @elseif ($category->status === 'Inacitve')
                                                <div class="badge badge-light-danger">{{ $category->status }}</div>
                                            @else
                                                <div class="badge badge-light-secondary">{{ $category->status }}</div>
                                            @endif
                                        </td>

                                        <td> <span class="tags">
                                            @if ($category->categories && $category->categories->isNotEmpty())
                                            @foreach ($category->categories as $subcategory)
                                                <span><a href="{{ route('admin.categories.edit', $subcategory->id) }}">{{ $subcategory->title['uz'] }}</a></span>
                                            @endforeach
                                        @elseif ($category->product_categories && $category->product_categories->isNotEmpty())
                                            @foreach ($category->product_categories as $productCategory)
                                                <span><a href="{{ route('admin.categories.edit', $productCategory->id) }}">{{ $productCategory->title['uz'] }}</a></span>
                                            @endforeach
                                        @else
                                            <p> NO Categories</p>
                                        @endif
                                            </span>
                                        </td>

                                        <td>
                                            <form class=""
                                                action="{{ route('admin.categories.destroy', $category->id) }}"
                                                method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <a href="{{ route('admin.categories.edit', $category->id) }}"
                                                    class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm me-1">
                                                    <!--begin::Svg Icon | path: icons/duotune/art/art005.svg-->
                                                    <span class="svg-icon svg-icon-3">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                            height="24" viewBox="0 0 24 24" fill="none">
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
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                            height="24" viewBox="0 0 24 24" fill="none">
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
                                    </tr>
                                @endforeach
                            </tbody>

                        </table>
                        <div class="d-flex flex-stack flex-wrap pt-10">
                            {{-- <div class="fs-6 fw-bold text-gray-700">Showing 1 to 10 of 50 entries</div> --}}
                            <!--begin::Pages-->
                            <ul class="pagination">
                                {{-- {{ $categories->links() }} --}}
                            </ul>
                            <!--end::Pages-->
                        </div>
                    </div>
                    <!--end::Card body-->
                </div>
                <!--end::Products-->
            </div>
            <!--end::Container-->
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
                        <a href="{route('admin.translations.index')}}"
                            class="d-flex text-dark fw-bolder fs-3 align-items-center my-1">Translation</a>
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
                        <a href="{{ route('admin.categories.create') }}" class="btn btn-sm btn-primary">Create</a>
                        <!--end::Primary button-->
                    </div>
                    <!--end::Actions-->
                </div>
                <!--end::Container-->
            </div>

        </div>
    @endsection
    @section('js')
        <script src="{{ asset('/assets/js/custom/apps/ecommerce/sales/listing.js') }}"></script>
        <!--begin::Global Javascript Bundle(used by all pages)-->
        <script src="{{ asset('/assets/plugins/global/plugins.bundle.js') }}"></script>
        <script src="{{ asset('/assets/js/scripts.bundle.js') }}"></script>
        <!--end::Global Javascript Bundle-->
        <!--begin::Page Vendors Javascript(used by this page)-->
        <script src="{{ asset('/assets/plugins/custom/fullcalendar/fullcalendar.bundle.js') }}"></script>
        <script src="{{ asset('/assets/plugins/custom/datatables/datatables.bundle.js') }}"></script>
        <!--end::Page Vendors Javascript-->
        <!--begin::Page Custom Javascript(used by this page)-->
        <script src="{{ asset('/assets/js/widgets.bundle.js') }}"></script>
        <script src="{{ asset('/assets/js/custom/widgets.js') }}"></script>
        <script src="{{ asset('/assets/js/custom/apps/chat/chat.js') }}"></script>
        <script src="{{ asset('/assets/js/custom/utilities/modals/upgrade-plan.js') }}"></script>
        <script src="{{ asset('/assets/js/custom/utilities/modals/create-app.js') }}"></script>
        <script src="{{ asset('/assets/js/custom/utilities/modals/users-search.js') }}"></script>
        <script src=/assets/plugins/global/plugins.bundle.js"></script>
        <script src="/assets/js/scripts.bundle.js"></script>
    @endsection
