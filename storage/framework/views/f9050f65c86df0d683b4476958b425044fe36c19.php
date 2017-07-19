<?php $__currentLoopData = $location; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $loc): $__env->incrementLoopIndices(); $loop = $__env->getFirstLoop(); ?>
		<?php if($mod == "Province"): ?>
		<li href='<?php echo e($loc->province); ?>' data="<?php echo e($loc->id); ?>" class="list-group-item"><b><?php echo e($loc->province); ?></b><span class="pull-right"><a href="javascript:void(0)" onclick="rename(this,'Province')">Rename</a>/<a href="<?php echo e(route('setup.delete',['model'=>'Province','id'=>$loc->id])); ?>">Delete</a></span></li>
		<?php elseif($mod == "District"): ?>
		<li href='<?php echo e($loc->district); ?>' data="<?php echo e($loc->id); ?>" class="list-group-item"><b><?php echo e($loc->district); ?></b><span class="pull-right"><a href="javascript:void(0)" onclick="rename(this,'District')">Rename</a>/<a href="<?php echo e(route('setup.delete',['model'=>'District','id'=>$loc->id])); ?>">Delete</a></span></li>
		<?php elseif($mod == "catagory"): ?>
                <li href='<?php echo e($loc->category); ?>' data="<?php echo e($loc->id); ?>" class="list-group-item"><b><?php echo e($loc->category); ?></b><span class="pull-right"><a href="javascript:void(0)" onclick="rename(this,'Category')">Rename</a>/<a href="<?php echo e(route('organiser.delete',['model'=>'categories','id'=>$loc->id])); ?>">Delete</a></span></li>
                <?php elseif($mod == "regCenter"): ?>
                <option value="<?php echo e($loc->id); ?>"><?php echo e($loc->centerName); ?></option>
                 
                <?php endif; ?>
<?php endforeach; $__env->popLoop(); $loop = $__env->getFirstLoop(); ?>
                        