<table class="table table-striprd">
                    <thead>
                        <tr>
                            <th class="text-info">Sr. No.</th>
                            <th>Order Date</th>
                            <th class="text-success">Centre Name</th>
                            <th class="text-center">Action</th>
                           
                        </tr>
                    </thead>
                    <tbody><?php $i = 0;?>
                        @foreach($data as $k=>$v)
                            <?php $time = strtotime($v["updated_at"]); $i++;?>
                        <tr>
                            <td class="text-info"><a href="#">{{ $k+1 }}</a></td>
                            <td>{{  date("d/m/Y", $time) }}</td>
                            
                            <td class="text-warning">{{ @$center[$v["target"]] }}</td>
                             
                             
                            <td class="text-center">
                                <a href="{{ route('downloadRender',['file'=> $time]) }}" style="background: #c5dfef;">&nbsp;</i>Get Excel&nbsp;</a> |
                                 <a href="{{ route('getGrn',['file'=> $time]) }}" style="background: #c5dfef;">&nbsp;</i>Get GRN&nbsp;</a> 
                              
                            </td>
                           
                        </tr>
                        @endforeach
                        @if($i == 0)
                        <tr><td colspan="7" class="text-center"> No record found for this center. Please select another.</td></tr>
                        @endif
                    </tbody>
                </table>
<script>
    $("#searchForm").hide();
   </script>