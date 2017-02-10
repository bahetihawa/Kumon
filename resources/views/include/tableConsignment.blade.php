<table class="table table-striprd">
                    <thead>
                        <tr>
                            <th class="text-info">Order No.</th>
                            <th>Order Date</th>
                            <th class="text-success">Ammount</th>
                            <th class="text-warning">Freight</th>
                            <th class="text-danger">Sum</th>
                            @if(Auth::user()->role == 1 && Request::has(0))
                            <th class="text-default">Warehouse</th>
                            @endif
                            <th class="text-right">Action</th>
                           
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($data as $k=>$v)
                        <tr>
                            <td class="text-info"><a href="#">{{ $v["orderNo"] }}</a></td>
                            <td>{{ $v["orderDate"] }}</td>
                            <td class="text-success">{{ $v["amount"] }} </td>
                            <td class="text-warning">{{ $v["freight"] }}</td>
                            <td class="text-danger">{{ $v["sum"] }}</td>
                             @if(Auth::user()->role == 1 && Request::has(0))
                            <td class="text-default"><?= isset($v->warehouse) ? $v->warehouse : "NA" ?></td>
                            @endif
                            <td class="text-right">|<a href="{{ route('download',['file'=> $v['id']]) }}"> Get Excel</a> |</td>
                           
                        </tr>
                        @endforeach
                        @if(empty($data->toArray()))
                        <tr><td colspan="7"> no record found</td></tr>
                        @endif
                    </tbody>
                </table>
<script>
    $("#searchForm").hide();
   </script>