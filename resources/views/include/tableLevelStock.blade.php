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
        <?php $tc = $v + @$countCenter[$k] + @$byTransfer[$k];?>
            <tr>
                <td class="text-info">{{$k}}</td>
                 <td class="text-warning">{{@$unit_price[$k]}}</td>
                  <td class="text-default">{{@$countCenter[$k] + @$byTransfer[$k]}}</td>
                   <td class="text-default">{{$v}}</td>
                <td class="text-success">{{$tc}}</td>
                <td class="text-danger">{{number_format($tc*@$unit_price[$k],6,".","")}}</td>
            </tr>
        @endforeach
        @if(empty($data))
        <tr><td colspan="4">No Data Found</td></tr>
        @endif
    </tbody>
</table>