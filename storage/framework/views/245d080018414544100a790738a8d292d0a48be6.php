<!DOCTYPE html>
<html lang="en">
<head>
    <?php echo $__env->make('include.head', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
</head>
<body>
    <div id="app">
        <?php echo $__env->make('include.header', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
        <?php echo $__env->yieldContent('content'); ?>
        <?php echo $__env->make('include.footer', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
    </div>
    <div id="renameModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button> 
        <h4 class="modal-title">Rename </h4>
      </div>
      <div class="modal-body">
		<form class="form-horizontal" role="form" method="POST" action="<?php echo e(route('organiger.create')); ?>" id="frm3" onsubmit="renameEntity(this)">
			  <?php echo e(csrf_field()); ?>

			 
			  <div class="form-group<?php echo e($errors->has('parent') ? ' has-error' : ''); ?>">
				  <input type="hidden" id="renameId" name="id"/>
                                  <label for="parent" class="col-md-3 control-label"></label>
                                  <div class="col-md-6">
					  <input id="newName" type="text" class="form-control" name="newName" value="<?php echo e(old('newName')); ?>" required autofocus >
					  
					  <?php if($errors->has('newName')): ?>
					  <span class="help-block">
						  <strong><?php echo e($errors->first('newName')); ?></strong>
					  </span>
					  <?php endif; ?>
				  </div>
			  </div>
			   <input type="hidden" name="model" id="renamemod" value=""/>
                          <?php if(isset($item)): ?>
                           <div class="form-group<?php echo e($errors->has('parent') ? ' has-error' : ''); ?>">
				 
                                  <label for="code" class="col-md-3 control-label"></label>
                                  <div class="col-md-6">
					  <input id="newCode" type="text" class="form-control" name="newCode" value="<?php echo e(old('newCode')); ?>" required autofocus >
					  
					  <?php if($errors->has('newCode')): ?>
					  <span class="help-block">
						  <strong><?php echo e($errors->first('newCode')); ?></strong>
					  </span>
					  <?php endif; ?>
				  </div>
			  </div>
                          <?php endif; ?>
		  </form>
      </div>
      <div class="modal-footer">
		<button type="button" class="btn btn-default" onclick='$("#frm3").submit()'>Submit</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>
    <!-- Scripts -->
    <script src="/js/app.js"></script>
</body>
</html>
