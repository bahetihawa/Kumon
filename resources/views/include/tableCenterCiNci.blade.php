<table class="table table-striprd">
                    <thead>
                        <tr>
                            <th class="text-info">Sr. No.</th>
   
                            <th class="text-success">Items</th>
                            <th class="text-warnib">code</th>
                            <th class="text-center">Quantity</th>
                           
                        </tr>
                    </thead>
                    <tbody><?php $i = 0;?>
                        @foreach($data as $k=>$v)
                            <?php  $i++;?>
                        <tr>
                            <td class="text-info"><a href="#">{{ $i }}</a></td>
                            <td class="text-success">{{$v['items']['item']}}</td>                         
                              <td class="text-warning">{{$v['items']['code']}}</td>      
                            <td class="text-center">
                                
                              {{$v['quantity']}}
                            </td>
                           
                        </tr>
                        @endforeach
                        @if($i == 0)
                        <tr><td colspan="7" class="text-center"> No record found for this center. Please select another.</td></tr>
                        @endif
                    </tbody>
                </table>
<script>
   // $("#searchForm").hide();
    $("#addNew").text("Center : <?= $left_title;?>");
   </script>