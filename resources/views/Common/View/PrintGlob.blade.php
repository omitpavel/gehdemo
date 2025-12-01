<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link rel="stylesheet" href="{{ asset('asset_v2/Ibox/Css/IboxCommonStyles.css') }}" crossorigin="anonymous">
    <link rel="stylesheet" href="{{ asset('asset_v2/Ibox/Css/CustomBootstrapPrint.css') }}" crossorigin="anonymous">
    <link rel="stylesheet" href="{{ asset('asset_v2/Generic/bootstrap/css/bootstrap5.0.2.min.css') }}" crossorigin="anonymous" />
    <link rel="stylesheet" href="{{ asset('asset_v2/Generic/bootstrap/icons/font/bootstrap-icons.css') }}" crossorigin="anonymous" />

    <script type="text/javascript" src="{{ asset('asset_v2/Generic/Js/jquery.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('asset_v2/Generic/Js/JqueryUi.js') }}"></script>
    <script type="text/javascript" src="{{ asset('asset_v2/Generic/Js/JqueryMigrate.js') }}"></script>


    <script type="text/javascript" src="{{ asset('asset_v2/Generic/bootstrap/js/bootstrap5.0.2.min.js') }}"></script>
    <style>
        /*@media print {*/
        /*    tbody, td, tfoot, th, thead, tr {*/
        /*        border-color: inherit;*/
        /*        border-style: solid;*/
        /*        border-width: 0;*/
        /*    }*/
        /*    th {*/
        /*        display: table-cell !important;*/
        /*    }*/
        /*    .responsiveTable tbody tr {*/
        /*        display: flex;*/
        /*        flex-direction: row;*/
        /*        align-items: flex-start;*/
        /*        justify-content: flex-start;*/
        /*        flex-wrap: wrap;*/
        /*        margin-bottom: 5px;*/
        /*        border-radius: 6px;*/
        /*    }*/
        /*    .custom-table .table-discharge-details tr td:nth-child(1), .custom-table .table-discharge-details tr td:nth-child(2), .custom-table .table-discharge-details tr td:nth-child(3), .custom-table .table-discharge-details tr th:nth-child(1), .custom-table .table-discharge-details tr th:nth-child(2), .custom-table .table-discharge-details tr th:nth-child(3) {*/
        /*        width: 25%;*/
        /*    }*/
        /*    .responsiveTable tbody tr {*/
        /*        border: 0.5px solid #A7A7A7;*/
        /*    }*/
        /*    .responsiveTable td .tdBefore {*/
        /*        position: absolute;*/
        /*        display: block;*/
        /*        left: 1rem;*/
        /*        width: calc(50% - 20px);*/
        /*        white-space: pre-wrap;*/
        /*        overflow-wrap: break-word;*/
        /*        text-align: left !important;*/
        /*        font-weight: 600;*/
        /*    }*/
        /*}*/

    </style>

</head>
<body>
<div id="PrintHere">

</div>
<script>
    setTimeout(function() {
        var buttons = document.getElementsByTagName('button');
        for (let i = 0; i < buttons.length; i++) {
            let button = buttons[i];
            button.style.display = 'none';
        }
    }, 500);
</script>

<script>

    $(document).ready(function(){
        setTimeout(function() {
            window.print();
        }, 1000);
        // window.print();
        setTimeout(function() {
            window.close();
        }, 1020);
    });

</script>
</body>
</html>
