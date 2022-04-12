

<?php $__env->startSection('content'); ?>

<!-- card box -->
<?php if(session('success')): ?>
    <div class="alert alert-success">
        <?php echo e(session('success')); ?>

    </div>
<?php endif; ?>
          <?php $__currentLoopData = $hardwareinterfaces; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $hardwareinterface): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="card">
              <div class="card-header">
                <h4 class="card-title"><strong><?php echo e($hardwareinterface->bezeichnung); ?></strong></h4>
              </div>
              <div class="card-body">
                <div class="row">
                  <div>
                    <strong>MAC-Adresse:</strong> <?php echo e($hardwareinterface->macaddr); ?><br>
                  </div>
                </div>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /media/sf_router/RouterRDF/resources/views/hardwareinterfaces/index.blade.php ENDPATH**/ ?>