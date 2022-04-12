


<?php $__env->startSection('content'); ?>
        <?php if($errors->any()): ?>
        <div class="alert alert-danger">
          <ul>
            <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
              <li><?php echo e($error); ?></li>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
          </ul>
        </div>

        <?php endif; ?>
        <div class="card card-primary">
            <form action ="<?php echo e(route('definitions.store')); ?>" method="post">
            <?php echo csrf_field(); ?>
              <div class="card-body" style="display: block;">
              <div class="form-group">
                <label for="bezeichnung">Bezeichnung</label>
                <input type="text" id="bezeichnung" name="bezeichnung" value="<?php echo e(old('bezeichnung')); ?>" placeholder="Bezeichnung der Definition" class="form-control">
              </div>
              <div class="form-group">
                <label for="IP">IP-Adresse</label>
                <input type="text" id="IP" name="IP" value="<?php echo e(old('IP')); ?>" placeholder="IP-Adresse der Definition" class="form-control">
              </div>
              <div class="form-group">
                  <label for="subnetmask">Subnetzmaske</label>
                  <select id="subnetmask" name="subnetmask" value="<?php echo e(old('subnetmask')); ?>" class="form-control custom-select">
                    <?php for($i = 8; $i < 33; $i++): ?>
                      <?php if($i != 31): ?>
                        <option><?php echo e($i); ?></option>
                      <?php endif; ?>
                    <?php endfor; ?>
                  </select>
                </div>
              <button type="submit" name="DefinitionSubmit" class="btn btn-primary">Anlegen</button>
            </div>
          </form>
          <!-- /.card-body -->
        </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /router/RouterRDF/resources/views/definitions/create.blade.php ENDPATH**/ ?>