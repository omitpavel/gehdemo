<div class="card-comments">
    <table class="table-comments">
        <thead>
        <tr class="position-relative">
            <th>Pharmacy Comments</th>
        </tr>
        </thead>
        <tbody>
        @if(count($all_comments) > 0)
        @foreach($all_comments as $comment)
        <tr>
            <td class="pivoted">
                <div class="tdBefore"></div>
              {{ $comment['pharmacy_comment'] }}
            </td>
        </tr>
        @endforeach
        @else
            <tr class="text-center">
                <td class="pivoted text-center" >
                    <div class="tdBefore"></div>
                    {{ NotFoundMessage()  }}
                </td>
            </tr>
        @endif

        </tbody>
    </table>
</div>
