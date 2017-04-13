<table class="table table-striprd">
    <thead>
        <tr>
            <th class="text-info">Worksheet Lavel.</th>
            <th class="text-warning">Unit Price.</th>
             <th class="text-default">count @ Cnt.</th>
             <th class="text-default">Count @ Wh.</th>
            <th class="text-success">Tot. Count</th>
            <th class="text-danger">Total Price</th>
        </tr>
    </thead>
    <tbody>
        @foreach($data as $k=>$v)
            <tr>
                <td class="text-info">{{$k}}</td>
                 <td class="text-warning">{{$unit_price[$k]}}</td>
                  <td class="text-default">{{$countCenter[$k]}}</td>
                   <td class="text-default">{{$v}}</td>
                <td class="text-success">{{$v + $countCenter[$k]}}</td>
                <td class="text-danger">{{($v+ $countCenter[$k])*$unit_price[$k]}}</td>
            </tr>
        @endforeach
        @if(empty($data))
        <tr><td colspan="4">No Data Found</td></tr>
        @endif
    </tbody>
</table>