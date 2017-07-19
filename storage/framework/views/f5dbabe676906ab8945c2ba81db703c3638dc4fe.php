<li class="dropdown">
    <a class="dropdown-toggle" data-toggle="dropdown" href="javascript:voide(0)">Organizer
     <span class="caret"></span>
    </a>
    <ul class="dropdown-menu">
        <li><a href="<?php echo e(url('/organiger/catagories')); ?>">Categories</a></li>
        <!--li><a href="<?php echo e(url('organiger/levels')); ?>">Wks Levels</a></li-->
        <li><a href="<?php echo e(url('/organiger/Items')); ?>">Items</a></li>
        <!--li><a href="<?php echo e(url('/addItemList')); ?>">Add Bulk Items</a></li-->
    </ul>
</li>
<li class="dropdown">
    <a class="dropdown-toggle" data-toggle="dropdown" href="javascript:voide(0)">Inventory
     <span class="caret"></span>
    </a>
    <ul class="dropdown-menu">
        <li><a href="<?php echo e(route('inventory.stockWarehouses',['store'=>0])); ?>">Stock @ Warehouses : CI,NCI,Bags</a></li>
        <li><a href="<?php echo e(route('inventory.wksLevel',['store'=>0])); ?>">Stock @ Warehouses : Wks Level Wise</a></li>
        <li><a href="<?php echo e(route('inventory.wks',['store'=>0])); ?>">Stock @ Warehouses : Wks Item Wise</a></li>
        <li><a href="<?php echo e(url('inventory/orders/0')); ?>">Purchases</a></li>
        <!--li><a href="<?php echo e(url('inventory/stockCenters')); ?>">Stock @ Centers</a></li>
        <!--li><a href="<?php echo e(url('inventory/create')); ?>">New Stock</a></li-->
        <!--li><a href="<?php echo e(url('inventory/transfer')); ?>">Stock : Transfer @ Warehouses</a></li>
        <li><a href="<?php echo e(url('inventory/render')); ?>">Stock : Render to Center</a></li-->
    </ul>
</li>
<li class="dropdown">
    <a class="dropdown-toggle" data-toggle="dropdown" href="javascript:voide(0)">Stock Status
     <span class="caret"></span>
    </a>
    <ul class="dropdown-menu">
         <li><a href="javascript:void(0)" data-toggle="modal" data-target="#opening">Closing Stock Month Wise</a></li>
        <!--li><a href="<?php echo e(url('stockStatusAll')); ?>">Download Stock Status</a></li-->
       
    </ul>
</li>
<li class="dropdown">
    <a class="dropdown-toggle" data-toggle="dropdown" href="javascript:voide(0)">Users
     <span class="caret"></span>
    </a>
    <ul class="dropdown-menu">
        <li><a href="<?php echo e(url('/register')); ?>">New Account</a></li>
        <li><a href="<?php echo e(url('/users/accounts')); ?>">Accounts</a></li>
        <li><a href="<?php echo e(url('/users/integration')); ?>">Warehouse & Center integration</a></li>
        <li><a href="<?php echo e(url('/users/activitylog')); ?>">Activity Logs</a></li>
    </ul>
</li>
<li class="dropdown">
    <a class="dropdown-toggle" data-toggle="dropdown" href="javascript:voide(0)">Set Up
     <span class="caret"></span>
    </a>
    <ul class="dropdown-menu">
        <li><a href="<?php echo e(url('/setup/locations')); ?>">Locations</a></li>
        <li><a href="<?php echo e(url('/setup/centers')); ?>">Centers</a></li>
        <li><a href="<?php echo e(url('/setup/warehouses')); ?>">Warehouses</a></li>
    </ul>
</li>


<li class="dropdown">
    <a class="dropdown-toggle" data-toggle="dropdown" href="javascript:voide(0)">Backup/Restore
     <span class="caret"></span>
    </a>
    <ul class="dropdown-menu">
        <li><a href="<?php echo e(route('backup')); ?>">Backup</a></li>
        <li><a href="<?php echo e(route('restore')); ?>">Restore</a></li>
        
    </ul>
</li>