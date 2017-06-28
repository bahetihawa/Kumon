<table class="table table-striprd">
    <thead>
        <tr>
            <th class="text-info">Item Name.</th>
            <th class="text-success">Item Code</th>
            <th class="text-warning">Availbility</th>
            <th class="text-danger">Unit Price</th>
            <th class="text-default">Total</th>
        </tr>
    </thead>
    <tbody>
        @foreach($data as $k=>$v)
            <tr>
                <td class="text-info"><?= isset($v->items->item) ? $v->items->item : $v->item ?></td>
                <td class="text-success"><?= isset($v->items->code) ? $v->items->code : $v->code ?> </td>
                <td class="text-warning">{{ $v->count }}</td>
                <td class="text-danger"><?= isset($v->unit_price) ? $v->unit_price : "NA" ?></td>
                <td class="text-default"><?= isset($v->unit_price) ? number_format($v->count*$v->unit_price,6,".","") : "NA" ?></td>
            </tr>
        @endforeach
        @if(empty($data->toArray()))
        <tr><td colspan="4">No Data Found</td></tr>
        @endif
    </tbody>
</table>