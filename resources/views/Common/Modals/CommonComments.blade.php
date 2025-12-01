

<div class="comments-all-offcanvas offcanvas offcanvas-end Modal_off_canvas"  id="viewAllCommentsGlobal"
     aria-labelledby="offcanvasRightLabel" style="visibility: visible;" aria-modal="true" role="dialog">

    <div class="offcanvas-header card-header fw-bold">
        <div class="d-flex align-items-center justify-content-between w-100">
            <div class="">
                <h6 class="mb-0" id="offcanvasRightLabel">ALL COMMENTS</h6>
            </div>
            <div class="">
                <button type="button" class="btn-grey text-end w-100"  onclick="CloseOffcanvas('viewAllCommentsGlobal');"><img src="{{ asset('asset_v2/Template/icons/cancel.svg') }}" alt="" width="14" height="14" class="me-3">
                    CLOSE</button>
            </div>
        </div>
    </div>
    <div class="offcanvas-body">
        <div class="card-comments">
            <table class="table-comments">
                <thead>
                <tr class="position-relative">
                    <th>Comments</th>
                    <th></th>
                </tr>
                </thead>

                <tbody id="show_patient_all_comments">

                </tbody>

            </table>
        </div>
    </div>
</div>

