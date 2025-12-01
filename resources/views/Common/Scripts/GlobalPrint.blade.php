<script>

    function GlobalPrint(printdivname) {

        var printContents = $("#"+printdivname).html();

        url = '{{ route('print_global.dashboard') }}';

        var newWin = window.open(url, '_blank');

        newWin.onload = function() {

            var newWinDoc = newWin.document;

            var contentDiv = newWinDoc.createElement('div');
            contentDiv.innerHTML = printContents;

            var targetDiv = newWinDoc.getElementById('PrintHere');

            if (targetDiv) {
                targetDiv.appendChild(contentDiv);
            }
        }
    }

    function print_pd_doc(printdivname, is_comment, is_signature) {

        var printheader = "";
        var print_footer = "";
        var print_footer_comments = "";
        var print_footer_signature = "";

        if (printdivname == "definite_document_details_insert") {
            printheader = "Definite Discharge Patients List";
            print_footer = "";
        }

        if (printdivname == "potential_document_details_insert") {
            printheader = "Potential Discharge Patients List";
            print_footer = "";
        }

        if (printdivname == "bed_flag_div") {
            printheader = "Bed Status Flag Dashboard";
            print_footer = "";
        }

        var printContents = document.getElementById(printdivname).innerHTML;

        if(is_comment === true) {
            print_footer_comments = "<div class='col-md-12 padding-zero' style='padding: 10px; border: 1px solid black; height: 100px; width: 95%; margin-top: 35px;'> " + "<div class='col-md-12 padding-zero' style='padding: 2px;'>  Comments :  </div>" + "</div>";
        }

        if(is_signature === true) {
            print_footer_signature = "<div class='col-md-12 padding-zero' style='padding: 10px; width: 95%; margin-top: 60px;'> " + "<div class='col-md-8 padding-zero' style='padding: 10px; border-top: 1px solid black; height: 50px; width: 150px; float: right; text-align: center;'>  Signature :  </div>" + "</div>";
        }

        var print_header_content = "<div style='width:100%; font-weight: bold; text-align: center; font-weight: bold; font-size: 20px; padding-bottom: 3px;'>" + printheader + "</div>";
        var print_footer_content = "<div style='width:100%;font-size: 14px; font-weight: bold; text-align: center; font-weight: bold; font-size: 14px; padding-bottom: 5px;'>" + print_footer + "</div>";


        var newWin = window.open('', 'Print-Window');
        newWin.document.open();
        newWin.document.write('<html><link rel="stylesheet" href="{{asset('asset_v2/Generic/bootstrap/css/bootstrap.min.css') }}" crossorigin="anonymous"> <body onload="window.print()">' + print_header_content + printContents + print_footer_comments + print_footer_signature + print_footer_content +'</body></html>');



        $(".task_complete_on_popup_to_change_login_sep").css("display", "block");


        var buttons = newWin.document.getElementsByTagName('button');
        for (var i = 0; i < buttons.length; i++) {
            buttons[i].style.display = 'none';
        }
        newWin.onload = function() {
            newWin.print();

        };

        setTimeout(function() {
            newWin.close();
        }, 10);

    }
</script>

<script>
    function PrintPage(printdivname,header_title) {
        var printContents = $("#"+printdivname).html();
        if(header_title !== ''){
            var printContent_title = $("#"+header_title).html();
        }

        var stylesheets = [];
        $('head link[rel="stylesheet"]').each(function() {
            var stylesheetUrl = $(this).attr('href');
            stylesheets.push(stylesheetUrl);
        });


        url = '{{ route('print_global.dashboard') }}';

        var newWin = window.open(url, '_blank');

        newWin.onload = function() {

            var newWinDoc = newWin.document;

            for (var i = 0; i < stylesheets.length; i++) {
                var link = newWinDoc.createElement('link');
                link.rel = 'stylesheet';
                link.type = 'text/css';
                link.href = stylesheets[i];
                newWinDoc.head.appendChild(link);
            }


            var contentDiv = newWinDoc.createElement('div');
            if(header_title !== ''){
                contentDiv.innerHTML = printContent_title + "<br>" + printContents;
            }else{
                contentDiv.innerHTML =  printContents;
            }


            var targetDiv = newWinDoc.getElementById('PrintHere');

            if (targetDiv) {
                targetDiv.appendChild(contentDiv);
            }
        }
    }
</script>

<script>
    function PrintPageWO(printdivname,header_title) {
        var printContents = $("#"+printdivname).html();
        var printContent_title = $("#"+header_title).html();

        url = '{{ route('print_global.dashboard') }}';

        var newWin = window.open(url, '_blank');

        newWin.onload = function() {

            var newWinDoc = newWin.document;

            var contentDiv = newWinDoc.createElement('div');
            contentDiv.innerHTML = printContent_title + "<br>" + printContents;;

            var targetDiv = newWinDoc.getElementById('PrintHere');

            if (targetDiv) {
                targetDiv.appendChild(contentDiv);
            }
        }

    }
</script>


