<table class="table table-striprd">
    <thead>
        <tr>
            <th class="text-info">Worksheet Lavel.</th>
            
         
            <th class="text-default">Total</th>
        </tr>
    </thead>
    <tbody>
        @foreach($data as $k=>$v)
            <tr>
                <td class="text-info">{{$k}}</td>
                <td class="text-success">{{$v}}</td>
            </tr>
        @endforeach
        @if(empty($data))
        <tr><td colspan="4">No Data Found</td></tr>
        @endif
    </tbody>
</table>