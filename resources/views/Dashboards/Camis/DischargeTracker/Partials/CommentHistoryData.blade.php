
    <div class="col-12">
        <div class="card-comment-history">
            @if($comment_list->count() > 0)
                <table class="breachReasonTable responsiveTable table-comments-history">
                    <thead>
                        <tr class="position-relative">
                            <th>Patient Name</th>
                            <th>Ward</th>
                            <th>Date & Time</th>
                            <th>User</th>
                            <th>Status</th>
                            <th>Comments</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach($comment_list as $comment)
                            <tr @if(isset($comment->priority) && $comment->priority == 1) class="bg-priority-task" @endif>
                                <td class="pivoted">
                                    <div class="tdBefore">Patient Name</div>
                                    {!! CamisPatientGender($patient->camis_patient_sex, $patient->camis_patient_name) !!}

                                </td>
                                <td class="pivoted">
                                    <div class="tdBefore">Ward</div>
                                    {{ $patient->ibox_ward_name }}
                                </td>
                                <td class="pivoted">
                                    <div class="tdBefore">Date & Time</div>
                                    {{ PredefinedDateFormatFor24Hour($comment->updated_at) }}
                                </td>
                                <td class="pivoted">
                                    <div class="tdBefore">User</div>
                                    {{ $comment->User ? $comment->User->username : '' }}
                                </td>

                                <td class="pivoted">
                                    <div class="tdBefore">Status</div>
                                    @if($comment->history_status == 1)
                                        Insert
                                    @elseif($comment->history_status == 2)
                                        Update
                                    @elseif($comment->history_status == 3)
                                        Delete
                                    @else
                                        Undefined
                                    @endif
                                </td>
                                <td class="pivoted">
                                    <div class="tdBefore">Comment</div>
                                    {{ $comment->comments }} - {{ PredefinedDateFormatFor24Hour($comment->updated_at) }}
                                                        </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <div class="work-plan-wrapper No_record_css bg-assigned-details">
                    <div class="work-plan mb-2">
                        <h6>{{  NotFoundMessage() }}</h6>

                    </div>
                </div>
            @endif
        </div>
    </div>
