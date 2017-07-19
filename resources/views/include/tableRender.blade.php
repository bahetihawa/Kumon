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
                            <?php $time1 = strtotime($v["created_at"]); $i++;?>
                        <tr>
                            <td class="text-info"><a href="#">{{ $k+1 }}</a></td>
                            <td>{{ $v["created_at"] }}</td>
                            
                            <td class="text-warning">{{ @$center[$v["target"]] }}</td>
                             
                             
                            <td class="text-center">
                                <a href="{{ route('downloadRender',['file'=> $time]) }}" style="background: #c5dfef;">&nbsp;</i>Get Excel&nbsp;</a> |
                                 <a href="{{ route('getDn',['file'=> $time]) }}" style="background: #c5dfef;">&nbsp;</i>Get DN&nbsp;</a> 
                              
                            </td>
                           
                        </tr>
                        @endforeach
                        @if($i == 0)
                        <tr><td colspan="7" class="text-center"> No record found for this center. Please select another.</td></tr>
                        @endif
                    </tbody>
                </table>
<script>

    //$("#searchForm").hide();
    $("#searchForm").html('<form>From: <input name="from" class="input-sm from" placeholder="Start Date" required> To: <input name="to" class="input-sm to" placeholder="End Date" required /> <input type="submit" value="Find" ></form>');
    $('.from').datepicker({
            dateFormat: "yy-mm-dd",
            
        });
    $('.to').datepicker({dateFormat: "yy-mm-dd"});

    
   </script>