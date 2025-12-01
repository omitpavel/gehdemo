

@if($edit_comment != null)

    <input type="hidden" id="initial_type" value="{{ $edit_comment->initials }}">
@else

    <input type="hidden" id="initial_type" @if(Session::has('initial_type') && Session::has('initial_type') == 'TU') value="TU" @else value="AAA" @endif>
@endif
@if($edit_comment != null)
    <input type="hidden" id="data_update_type" value="update">
    <input type="hidden" id="data_comment_id" value="{{ $edit_comment->id }}">
@else
    <input type="hidden" id="data_update_type" value="add">
    <input type="hidden" id="data_comment_id" value="">
@endif


<div class="col-12">
    <div class="row gx-2">
        <div class="col-lg-10 col-md-8 col-7">
            <label for="" class="form-label">Comments</label>
        </div>
        <div class="col-lg-2 col-md-4 col-5">
            <div class="form-check">
                <input class="form-check-input"  type="checkbox" @if(($edit_comment != null) && ($edit_comment->priority == 1)) value="1" checked @else   value="0" @endif  id="is_a_priority_comment">
                <label class="form-check-label text-danger" for="is_a_priority_comment">
                    Mark As Priority
                </label>
            </div>
        </div>
    </div>
</div>
<div class="col-12">
    <div class="">
        <textarea class="form-control comment_data" id="comment_data" name="comment_data" rows="4">@if($edit_comment != null) {{ $edit_comment->comments }} @endif</textarea>
    </div>
</div>
