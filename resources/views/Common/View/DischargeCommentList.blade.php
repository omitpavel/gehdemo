@if(count($comment_list) > 0)
    @foreach($comment_list as $comment)

        <div class="row gx-1 align-items-center @if(isset($comment->priority) && $comment->priority == 1 ) bg-priority-task @endif">
            <div class="col-comment">
                <span class="">{{ $comment->comments }} - {{ PredefinedDateFormatFor24Hour($comment->updated_at) }}</span>
            </div>
            <div class="col-icons">

            </div>
        </div>
    @endforeach



@endif
