<?php $__env->startSection('left_title'); ?>
    Countries
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
<div class="container minHeight">
    <div class="row">
        <div class="col-md-4 col-md-4 Category">
            <div class="panel panel-info">
                <div class="panel-heading">Categories <a class="pull-right" id="addCat" href="javascript:void(0)">Add Category</a></div>
                <div class="panel-body">
                    <ul class="list-group">
                    <?php $__currentLoopData = $category; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cat): $__env->incrementLoopIndices(); $loop = $__env->getFirstLoop(); ?>
                        <?php if($cat->parent == 0): ?>
                            <li href='<?php echo e($cat->category); ?>' data="<?php echo e($cat->id); ?>" class="list-group-item"><b><?php echo e($cat->category); ?></b><span class="pull-right"><a href="javascript:void(0)" onclick="rename(this,'Category')">Rename</a>/<a href="<?php echo e(route('organiser.delete',['model'=>'categories','id'=>$cat->id])); ?>">Delete</a></span></li>
                        <?php endif; ?>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getFirstLoop(); ?>
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-md-4 col-md-4 fade Sub-Category">
            <div class="panel panel-info">
                <div class="panel-heading"><span class="CountryName"> Sub Category</span></div>

                <div class="panel-body">
                    <ul class="list-group">
                        <li class="list-group-item">Loading . . . . . . .</li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-md-4 col-md-4 fade sSub-Category">
            <div class="panel panel-info">
                <div class="panel-heading"><span class="stateName"> State</span> </div>

                <div class="panel-body">
                   <ul class="list-group">
                         <li class="list-group-item">Loading . . . . . . .</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button> 
        <h4 class="modal-title">Add New Country </h4>
      </div>
      <div class="modal-body">
		<form class="form-horizontal" role="form" method="POST" action="<?php echo e(route('organiger.create')); ?>" id="frm">
			  <?php echo e(csrf_field()); ?>

			 
			  <div class="form-group<?php echo e($errors->has('parent') ? ' has-error' : ''); ?>">
				  <label for="parent" class="col-md-4 control-label">Parent Category</label>
				  
				  <div class="col-md-6">
					  <select id="parent" type="text" class="form-control" name="parent" value="<?php echo e(old('parent')); ?>" required autofocus >
                                              <option value="0">Root</option>
                                              
                                              <?php $__currentLoopData = $category; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cat): $__env->incrementLoopIndices(); $loop = $__env->getFirstLoop(); ?>:?>
                                              <option value="<?php echo e($cat->id); ?>"><?php echo e($cat->category); ?></option>
                                             <?php endforeach; $__env->popLoop(); $loop = $__env->getFirstLoop(); ?>;
                                              
                                          </select>
					  <?php if($errors->has('parent')): ?>
					  <span class="help-block">
						  <strong><?php echo e($errors->first('parent')); ?></strong>
					  </span>
					  <?php endif; ?>
				  </div>
                                  <br>
                                  <label for="parent" class="col-md-4 control-label">Category Name</label>
                                  <div class="col-md-6">
					  <input id="category" type="text" class="form-control" name="category" value="<?php echo e(old('category')); ?>" required autofocus >
					  
					  <?php if($errors->has('category')): ?>
					  <span class="help-block">
						  <strong><?php echo e($errors->first('category')); ?></strong>
					  </span>
					  <?php endif; ?>
				  </div>
			  </div>
			   <input type="hidden" name="model" id="inputModel1a" value="Category"/>
		  </form>
      </div>
      <div class="modal-footer">
		<button type="button" class="btn btn-default" onclick='$("#frm").submit()'>Submit</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>
<style type="text/css">
  .level2{
    color: #7c7c7c;
    pointer-events: none;
    display: none;
  }
</style>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.primary', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>