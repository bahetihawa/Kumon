<table class="table table-striprd">
                    <thead>
                        <tr>
                            <th class="text-info">Sr. No.</th>
   
                            <th class="text-success">Items</th>
                             <th class="text-warning">Unit Price</th>
                            <th class="text-center">Quantity</th>
                             <th class="text-danger">Total Price</th>
                           
                        </tr>
                    </thead>
                    <tbody><?php $i = 0;?>
                        @foreach($data as $k=>$v)
                            <?php  $i++;?>
                        <tr>
                            <td class="text-info"><a href="#">{{ $i }}</a></td>
                            <td>{{$k}}</td>                         
                            <td class="text-warning">{{$unit_price[$k]}}</d>
                            <td class="text-center">{{$v}}</td>                         
                             
                           <td class="text-danger">{{$v*$unit_price[$k]}}</d>
                           
                        </tr>
                        @endforeach
                        @if($i == 0)
                        <tr><td colspan="7" class="text-center"> No record found for this center. Please select another.</td></tr>
                        @endif
                    </tbody>
                </table>
<script>
    //$("#searchForm").hide();
    $("#addNew").text("Center : <?= $left_title;?>");
   </script><?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

