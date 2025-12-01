<div class="col-lg-12">
    <div class="row">
        <div class="col-lg-12" id="custom-tab">

            <!-- Nav tabs -->

            <div class="sticky-tab" id="">
                <ul class="nav nav-tabs" role="tablist">
                    <li class="mb-2">
                        <a class="tab-custom-btn {{ $tab == 'regular' ? 'active' : '' }}"
                            onclick="DataPageLoad('regular');">
                            <div class="tab-active">Favourites</div>
                        </a>
                    </li>
                    <li class="mb-2">
                        <a class="tab-custom-btn {{ $tab == 'dtoc' ? 'active' : '' }}"
                            onclick="DataPageLoad('dtoc');">
                            <div class="tab-active">Discharge Tracker</div>
                        </a>
                    </li>
                </ul>
            </div>

            <!-- Tab panes -->

            <div class="tab-content favourites-wrapper" id="tabcontent">
                <div id="favourites" class="tab-pane active">
                    <div class="row">
                        <div class="container-fluid">
                            <div class="col-lg-12">
                                <div class="fovourites-dashboards-wrapper">
                                    <div class="row gx-2 align-items-center mb-3">
                                        <div class="col-lg-2 col-md-3">
                                            <label for="" class="form-label mb-md-0">Choose
                                                Dashboard</label>
                                        </div>
                                        <div class="col-md-4">
                                            <select class="form-select selectric-select w-100"
                                                aria-label="Default select example" name="menus" id="menus">
                                                @foreach (array_keys($list_dashboard) as $dashboard_name)
                                                    <option label="{{ $dashboard_name }}" class="optionGroup"
                                                        value="" disabled>
                                                        {{ $dashboard_name }}</option>
                                                    @foreach ($list_dashboard[$dashboard_name] as $dashboard)
                                                        <option value="{{ $dashboard['id'] }}"
                                                            @if (count($user_favourites) && in_array($dashboard['id'], $user_favourites)) selected @endif>
                                                            {{ $dashboard['name'] }}
                                                        </option>
                                                    @endforeach
                                                @endforeach

                                            </select>

                                        </div>
                                    </div>
                                    <div class="card-table-listing">
                                        <div class="sub-header">
                                            <span>Menu List (Drag & Drop To Adjust
                                                Position)</span>
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
                                            <tbody class="droppable">
                                                @if (count($user_favourites) > 0)
                                                    @foreach ($user_favourites as $fav)
                                                        @if(!isset($fav['menus']['dashboard_name']))
                                                            <tr id="no-record">
                                                                <td colspan="4" class="text-center">No Menu Added</td>
                                                            </tr>
                                                            @continue
                                                        @endif
                                                        <tr data-id="{{ $fav['menu_id'] }}"  class="draggable ui-sortable-handle">
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

                                                                    <button class="btn btn-remove-row remove-row">Remove</button>

                                                                </div>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                @else
                                                    @if($tab == 'dtoc')
                                                        @foreach ($dtoc_menu as $fav)
                                                            <tr data-id="{{ $fav['id'] }}"  class="draggable ui-sortable-handle">
                                                                <td class="pivoted">
                                                                    <div class="tdBefore">Serial No.</div>
                                                                    {{ $loop->iteration }}
                                                                </td>
                                                                <td class="pivoted">
                                                                    <div class="tdBefore">Dashboard Name</div>
                                                                    {{ $fav['dashboard_name'] ?? '' }}
                                                                </td>
                                                                <td class="pivoted">
                                                                    <div class="tdBefore">Module Name</div>
                                                                    {{ $fav['dashboard_type'] ?? '' }}
                                                                </td>
                                                                <td class="pivoted">
                                                                    <div class="tdBefore">Action</div>
                                                                    <div class="wrapper-buttons ">

                                                                        <button class="btn btn-remove-row remove-row">Remove</button>

                                                                    </div>
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                    @else
                                                        <tr id="no-record">
                                                            <td colspan="4" class="text-center">No Menu Added</td>
                                                        </tr>
                                                    @endif
                                                @endif

                                            </tbody>
                                        </table>
                                        <div class="button-section">
                                            <button class="btn btn-primary-grey w-auto save_table">SAVE</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<input type="hidden" id="current_tab" value="{{ $tab }}">
<script>
    var windowWidth = window.innerWidth;
    var bgSticky = document.querySelector('.sticky-tab');

    if (windowWidth > 1026) {
        if (document.getElementById("marquee-content")) {
            if (bgSticky) {
                bgSticky.style.top = "86px";
            }
        }
    }

</script>
<script>


    function UpdateSerialNumbers() {
        $('#sortableTable tbody tr').each(function(index) {
            $(this).find('td:first').html(`
           <div class="tdBefore">Serial No.</div>
           ${index + 1}
       `);
        });
    }

    $(function() {
        $("#sortableTable tbody").sortable({
            placeholder: "ui-state-highlight",
            update: function(event, ui) {
                UpdateSerialNumbers();
            }
        });


        $('#menus').on('change', function() {
            const selectedText = $('#menus option:selected').text();
            const selectedOption = $(this).find('option:selected');
            const selectedVal = $(this).val();
            const groupName = selectedOption.prevAll('.optionGroup').first().text();

            if ($('#sortableTable tbody tr[data-id="' + selectedVal + '"]').length === 0) {
                $('#no-record').remove();
                const rowCount = $('#sortableTable tbody tr').length + 1;

                $('#sortableTable tbody').append(`
               <tr data-id="${selectedVal}"  class="draggable ui-sortable-handle">
                   <td class="pivoted">
                       <div class="tdBefore">Serial No.</div>
                       ${rowCount}
                   </td>
                   <td class="pivoted"><div class="tdBefore">Dashboard Name</div>
                       ${selectedText}</td>
                       <td class="pivoted"><div class="tdBefore">Module Name</div>
                       ${groupName}</td>
                       <td class="pivoted">
                                               <div class="tdBefore">Action</div>
                                               <button class="btn btn-remove-row remove-row">Remove</button>

                                           </td>
               </tr>
           `);
            }
        });
    });

    $(document).on('click', '.remove-row', function() {
        $(this).closest('tr').remove();

        if ($('#sortableTable tbody tr[data-id]').length === 0) {
            $('#sortableTable tbody').html(`
       <tr id="no-record">
           <td colspan="4" class="text-center">No Menu Added</td>
       </tr>
   `);
        }

        $('#sortableTable tbody tr[data-id]').each(function(index) {
            $(this).find('td:first').html(`
       <div class="tdBefore">Serial No.</div>${index + 1}
   `);
        });
    });
</script>
