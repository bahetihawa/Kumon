<table>
    <thead style="border:1px solid black;">
        <tr>
            @for($i=0;$i<11;$i++)
            {!!'<td></td>'!!}
            @endfor
        </tr>
        <tr>
            <td colspan="4"><b>Kumon India Education Private Limited</b></td>
            <td colspan="3"></td>
            <td colspan="4"><strong>Goods Receipt Note (GRN)</strong></td>
        </tr>
         <tr>
            <td colspan="4">Regd. Office: 14A & 14B, Vasant Square Mall, </td>
            <td colspan="3"></td>
            <td colspan="2"><stong>Consignor</stong></td>
            <td colspan="2"><stong>{{$center['centerName']}}</stong></td>

        </tr>
         <tr>
            <td colspan="4">Plot no. A, Community Centre Pkt-V, </td>
            <td colspan="3"></td>
            <td colspan="2"></td>
            <td colspan="2">{{$center['address']}}</td>
        </tr>
         <tr>
            <td colspan="4">Sec-B,Vasant Kunj,  </td>
            <td colspan="3"></td>
            <td colspan="2"></td>
            <td colspan="2">{{$center['district']}},{{$center['province']}};</td>
        </tr>
         <tr>
            <td colspan="4">New Delhi-110070</td>
            <td colspan="3"></td>
            <td colspan="2"></td>
            <td colspan="2">{{$center['country']}}</td>
        </tr>
        <tr>
            @for($i=0;$i<11;$i++)
            {!!'<td></td>'!!}
            @endfor
        </tr>
         <tr>
            @for($i=0;$i<11;$i++)
            {!!'<td></td>'!!}
            @endfor
        </tr>
        <tr>
            <td>Tin</td>
            <td colspan="3">{{$center['tin']}}</td>
            @for($i=0;$i<4;$i++)
            {!!'<td></td>'!!}
            @endfor
            <td>Date</td>
            <td colspan="2">{{date('d/m/Y',$date)}}</td>
        </tr>
        <tr>
            <td>CST</td>
            <td colspan="3">{{$center['cst']}}</td>
            @for($i=0;$i<4;$i++)
            {!!'<td></td>'!!}
            @endfor
            <td>Dispatch Note no.-</td>
            <td colspan="2">{{$grnRef}}</td>
        </tr>
        <tr>
            <td>Contact</td>
            <td colspan="3">{{$center['phone']}}</td>
            @for($i=0;$i<4;$i++)
            {!!'<td></td>'!!}
            @endfor
            <td># Requisition ref-</td>
            <td colspan="2"></td>
        </tr>
        <tr>
            <td>Email</td>
            <td colspan="3">{{$center['email']}}</td>
            @for($i=0;$i<4;$i++)
            {!!'<td></td>'!!}
            @endfor
            <td></td>
            <td colspan="2"></td>
        </tr>
         <tr>
            @for($i=0;$i<11;$i++)
            {!!'<td></td>'!!}
            @endfor
        </tr>
         <tr>
            @for($i=0;$i<11;$i++)
            {!!'<td></td>'!!}
            @endfor
        </tr>
        <tr>
            <td colspan="2">Ship To</td>
            <td colspan="3"></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td colspan="2">Address  of consignee</td>
            <td colspan="3"></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td colspan="2">TIN of consignee</td>
            <td colspan="3"></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        
    </thead>
    
    <tr>
        @for($i=0;$i<11;$i++)
        {!!'<td></td>'!!}
        @endfor
    </tr>
    <tbody style="border:1px solid black;">
        <tr style="height: 20px;border:1px solid black;">
            <th>S.no.</th>
            <th colspan="2">Item Code</th>
            <th colspan="2">Item Name</th>
            <th colspan="2">Quantity</th>
            <th colspan="2">Per Unit Rate</th>
            <th colspan="2">Value</th>
        </tr><?php $i = 1;$tot = 0; $totVal = 0?>
        @foreach($data as $dat)
        <?php $tot += $dat['quantity'];
        $val = $price[$dat['item']]*$dat['quantity'];
        $totVal +=$val;
        ?>
        <tr>
            <td>{{$i++}}</th>
            <td colspan="2">{{$dat['items']['code']}}</td>
            <td colspan="2">{{$dat['items']['item']}}</td>
            <td colspan="2">{{$dat['quantity']}}</td>
            <td colspan="2">{{$price[$dat['item']]}}</td>
            <td colspan="2">{{$val}}</td>
        </tr>
        @endforeach
        <tr style="height: 20px;border:1px solid black;">
            <th></th>
            <th colspan="2"></th>
            <th colspan="2">Total</th>
            <th colspan="2">{{$tot}}</th>
            <th colspan="2"></th>
            <th colspan="2">{{$totVal}}</th>
        </tr>
        <tr>
        @for($i=0;$i<11;$i++)
        {!!'<td></td>'!!}
        @endfor
        </tr>
        <tr>
            @for($i=0;$i<11;$i++)
            {!!'<td></td>'!!}
            @endfor
        </tr>
        <tr>
            <td></td>
            <td colspan="2"></td>
            <td colspan="2">No. of cartons</td>
            <td colspan="2"></td>
            <td colspan="2">Warehouse-in-charge</td>
            <td colspan="2"></td>
        </tr>
        <tr>
            <td></td>
            <td colspan="2"></td>
            <td colspan="2">Driver/Representative Signatur</td>
            <td colspan="2"></td>
            <td colspan="2">Name</td>
            <td colspan="2"></td>
        </tr>
    </tbody>
</table>