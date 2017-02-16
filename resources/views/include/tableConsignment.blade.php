<table class="table table-striprd">
                    <thead>
                        <tr>
                            <th class="text-info">Order No.</th>
                            <th>Order Date</th>
                            <th class="text-success">Amount</th>
                            <th class="text-warning">Custome</th>
                            <th class="text-warning">Freight</th>
                            <th class="text-warning">C & F</th>
                            <th class="text-warning">Others</th>
                            <th class="text-danger">Sum</th>
                            @if(Auth::user()->role == 1 && Request::has(0))
                            <th class="text-default">Warehouse</th>
                            @endif
                            <th class="text-center">Action</th>
                           
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($data as $k=>$v)
                        <tr>
                            <td class="text-info"><a href="#">{{ $v["orderNo"] }}</a></td>
                            <td>{{ $v["orderDate"] }}</td>
                            <td class="text-success">{{ $v["amount"] }} </td>
                            <td class="text-warning">{{ $v["custom"] }}</td>
                             <td class="text-warning">{{ $v["freight"] }}</td>
                              <td class="text-warning">{{ $v["cnf"] }}</td>
                               <td class="text-warning">{{ $v["others"] }}</td>
                            <td class="text-danger">{{ $v["sum"] }}</td>
                             @if(Auth::user()->role == 1 && Request::has(0))
                            <td class="text-default"><?= isset($v->warehouse) ? $v->warehouse : "NA" ?></td>
                            @endif
                            <td class="text-right">
                                <a href="{{ route('download',['file'=> $v['id']]) }}" style="background: #c5dfef;">&nbsp;</i>Get Excel&nbsp;</a> |
                                <a href="javascript:void(0)" class="text-danger" style="background: #efc5c5;" onclick="addCharges(<?= $v['id'];?>)">&nbsp;Add Charges&nbsp; </a> 
                            </td>
                           
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