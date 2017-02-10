<li class="dropdown">
    <a class="dropdown-toggle" data-toggle="dropdown" href="javascript:voide(0)">Inventory
     <span class="caret"></span>
    </a>
    <ul class="dropdown-menu">
        <li><a href="{{ url('inventory/stock') }}">Availble Stock</a></li>
        <li><a href="{{ url('inventory/stockCenters') }}">Stock @ Centers</a></li>
        <li><a href="{{ url('inventory/stockWarehouses') }}">Stock @ Warehouses</a></li>
        <li><a href="{{ url('inventory/create') }}">New Stock</a></li>
        <li><a href="{{ url('inventory/transfer') }}">Stock : Transfer @ Warehouses</a></li>
        <li><a href="{{ url('inventory/render') }}">Stock : Render to Center</a></li>
    </ul>
</li>


<li class="dropdown">
    <a class="dropdown-toggle" data-toggle="dropdown" href="javascript:voide(0)">Profile
     <span class="caret"></span>
    </a>
    <ul class="dropdown-menu">
        
        <li><a href="{{ url('/users/logs') }}">Logs</a></li>
    </ul>
</li>