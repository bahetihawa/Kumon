<li class="dropdown">
    <a class="dropdown-toggle" data-toggle="dropdown" href="javascript:voide(0)">Inventory
     <span class="caret"></span>
    </a>
    <ul class="dropdown-menu">
        <li><a href="{{ url('stock') }}">Available Stock : CI,NCI,Bags</a></li>
        <li><a href="{{ url('wksLevel') }}">Available wks: Level Wise</a></li>
        <li><a href="{{ url('wks') }}">Available Wks : Item Wise</a></li>
        <li><a href="{{ url('stockCenters/0') }}">WKS Stock @ Centers</a></li>
        <li><a href="{{ url('stockCentersCiNci/0') }}">CI/NCIStock @ Centers</a></li>
        <li><a href="{{ url('consignments') }}">Purchases</a></li>
        <li><a href="{{ url('transfer/0') }}">Stock : Transfer @ Warehouses</a></li>
        <li><a href="{{ url('render/0') }}">Stock : Issue to Center</a></li>
        <li><a href="{{ url('consume/0') }}">Stock : Consumed By Center</a></li>
        <li><a href="{{ url('return/0') }}">Stock : Returned By Center</a></li>
    </ul>
</li>


<li class="dropdown">
    <a class="dropdown-toggle" data-toggle="dropdown" href="javascript:voide(0)">Stock Status
     <span class="caret"></span>
    </a>
    <ul class="dropdown-menu">
        <li><a href="javascript:void(0)" data-toggle="modal" data-target="#opening1">Closing Stock Month Wise</a></li>
        <!--li><a href="{{ url('stockStatus') }}">Download Stock Status</a></li-->
        
    </ul>
</li>