<!DOCTYPE html>
<html lang="en">
<head>
    <?php echo $__env->make('include.head', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
</head>
<style>
.footer{
    bottom: 0;
}
</style>
<body>
    <div id="app">
        <nav class="navbar navbar-inverse navbar-static-top">
            <div class="container">
                <div class="navbar-header">

                    <!-- Collapsed Hamburger -->
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse">
                        <span class="sr-only">Toggle Navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>

                    <!-- Branding Image -->
                    <a class="navbar-brand" href="<?php echo e(url('/')); ?>">
                        <img src="/logo.jpg" style="
                            height: auto;
                            width: 100px;
                            margin: -8px;
                        ">
                    </a>
                    <a class="navbar-brand" href="<?php echo e(url('/')); ?>" style="border-right: 1px solid">
                        <?php echo e(config('app.name', 'Laravel')); ?>

                    </a>
                </div>

                <div class="collapse navbar-collapse" id="app-navbar-collapse">
                    <!-- Left Side Of Navbar -->
                    <ul class="nav navbar-nav ">
                        <?php if(Auth::check()): ?>
                            <?php if(Auth::user()->role == 1): ?>
                                <?php echo $__env->make('include.topnav', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                            <?php elseif(Auth::user()->role == 2): ?>
                                <?php echo $__env->make('include.topnavC', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                            <?php elseif(Auth::user()->role == 3): ?>
                                <?php echo $__env->make('include.topnavW', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                            <?php endif; ?>
                        <?php endif; ?>
                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="nav navbar-nav navbar-right">
                        <!-- Authentication Links -->
                        <?php if(Auth::guest()): ?>
                            <li><a href="<?php echo e(url('/login')); ?>">Login</a></li>
                          
                        <?php else: ?>
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                <?php if(Auth::user()->role == 1): ?>
                                    Super User :
                                <?php else: ?>
                                    Warehouse:
                                <?php endif; ?>    
                                   <?php echo e(Auth::user()->name); ?> <span class="caret"></span>
                                </a>

                                <ul class="dropdown-menu" role="menu">
                                    <li>
                                        <a href="<?php echo e(url('/logout')); ?>"
                                            onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                            Logout
                                        </a>

                                        <form id="logout-form" action="<?php echo e(url('/logout')); ?>" method="POST" style="display: none;">
                                            <?php echo e(csrf_field()); ?>

                                        </form>
                                    </li>
                                </ul>
                            </li>
                        <?php endif; ?>
                    </ul>
                </div>
            </div>
        </nav>
        <div class="container text-danger" id="crumb"><?php echo e(config('app.breadcrumb')[Request::route()->getName()]); ?></div>
<?php if(Session::has('message')): ?>
<div class="alert <?php echo e(Session::get('alert-class', 'alert-danger text-center')); ?>"><?php echo e(Session::get('message')); ?></div>
<?php endif; ?>
        <?php echo $__env->yieldContent('content'); ?>
        <?php echo $__env->make('include.footer', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
    </div>

    <!-- Scripts -->
    <script>
    $("input").on("click",function(){
        var cent = $(this).val();
        if(cent == 2 ){ var d = "center";}else{ var d = "warehouse";}
        $("#assign").text(d);
        $(".registrationShow").removeClass("fade");
        $.post("/utility/registerCenter",{data:cent},function(r){
            $("#asigned").html(' <option value="0">-------Select-------</option>').append(r);
        });
    });
</script>
    <script src="/js/app.js"></script>
</body>
</html>
