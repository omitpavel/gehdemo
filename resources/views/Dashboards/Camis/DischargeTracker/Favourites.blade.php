@extends('Layouts.Common.MasterLayout')
@section('page-title', 'Set Favourites')
@section('page-top-title', 'Set Favourites')
@section('page-top-title-sub', date('jS F H:i'))

@section('content')
    <link rel="stylesheet" href="{{ asset('asset_v2/Template/Css/TableListing.css') }}" crossorigin="anonymous" />
    <style>

    </style>
    <div class="container-fluid">
        <div class="col-lg-12  ">
            <div class="rectangle-block-1 mb-2">
                <div class="favourites-dashboards p-3">
                    <form method="post" action="{{ route('save.favourites') }}">
                        @csrf
                        <div class="row gy-3 gx-2">
                            <div class="col-md-6">
                                <label for="" class="form-label">Choose Dashboard</label>
                                <select class="form-select" aria-label="Default select example" name="menus"
                                    id="menus">
                                    @foreach (array_keys($list_dashboard) as $dashboard_name)
                                        <option label="{{ $dashboard_name }}" class="optionGroup" value="" disabled>
                                            {{ $dashboard_name }}</option>
                                        @foreach ($list_dashboard[$dashboard_name] as $dashboard)
                                            <option value="{{ $dashboard['id'] }}"
                                                @if (count($user_favourites) && in_array($dashboard['id'], $user_favourites)) selected @endif>{{ $dashboard['name'] }}
                                            </option>
                                        @endforeach
                                    @endforeach

                                </select>
                            </div>

                        </div>
                    </form>
                </div>
            </div>
            <div class="card-table-listing mb-2">
                <div class="sub-header">
                    <span>Menu List (Drag & Drop To Adjust Position)</span>
                </div>
                <table class="responsiveTable table-listing" id="sortableTable">
                    <thead>
                        <tr class="position-relative">
                            <th>#</th>
                            <th>Dashboard Name</th>
                            <th>Module</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if (count($user_favourites) > 0)
                            @foreach ($user_favourites as $fav)
                                <tr data-id="{{ $fav['menu_id'] }}">
                                    <td class="pivoted">
                                        <div class="tdBefore">Serial No.</div>
                                        {{ $loop->iteration }}
                                    </td>
                                    <td class="pivoted">
                                        <div class="tdBefore">Dashboard Name</div>
                                        {{ $fav['menus']['dashboard_name'] ?? '' }}
                                    </td>
                                    <td class="pivoted">
                                        <div class="tdBefore">Module Name</div>
                                        {{ $fav['menus']['dashboard_type'] ?? '' }}
                                    </td>
                                    <td class="pivoted">
                                        <div class="tdBefore">Action</div>
                                        <div class="wrapper-buttons ">

                                            <button class="btn btn-reject  remove-row">Remove</button>

                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        @else
                            <tr id="no-record">
                                <td colspan="4" class="text-center">No record found</td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>
            <div class="container-fluid">
                <div class="col-lg-12  ">
                    <div class="mb-2">
                        <div class="favourites-dashboards p-3">

                            <div class="row gy-3 gx-2">

                                <div class=" col-lg-2">
                                    <button class="btn btn-primary-grey" id="save_table">Save</button>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection
@section('footer')
    <script>
        $(document).ready(function() {
            $('.page-loader').hide();
            $('select').selectric('refresh');

        });


    </script>
   
    <script>
        // Dynamically Space Managing - Marquee, Topbar and Side bar

        if ((document.querySelector("#sidebar")) || (document.querySelector("#content"))) {
            if (document.getElementById("sidebar")) {
                // document.getElementById("content").style.width = "calc(100% - 100px)";
            } else {
                document.getElementById("content").style.width = "100%";
                document.getElementById("content").style.paddingLeft = "0"
            }
        }

        if ((document.querySelector("#marquee-content")) && (document.querySelector("#content")) &&
            (document.querySelector("#page-wrapper")) || (document.querySelector("#topbar"))) {
            if ((document.getElementById("marquee-content")) && (document.getElementById("topbar"))) {
                document.getElementById("page-wrapper").style.marginTop = "95px";
            } else {
                document.getElementById("page-wrapper").style.marginTop = "70px";
                document.getElementById("topbar").style.marginTop = "0px";

            }
        }



        if (document.getElementById("topbar")) {
            // document.getElementById("page-wrapper").style.marginTop = "105px";
        } else {
            document.getElementById("page-wrapper").style.marginTop = "20px";

        }
    </script>

@endsection
