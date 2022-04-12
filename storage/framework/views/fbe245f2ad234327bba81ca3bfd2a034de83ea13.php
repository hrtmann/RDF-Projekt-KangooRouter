


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
            <form action ="<?php echo e(route('interfaces.store')); ?>" method="post">
            <?php echo csrf_field(); ?>
              <div class="card-body" style="display: block;">
              <div class="form-group">
                <label for="bezeichnung">Bezeichnung</label>
                <input type="text" id="bezeichnung" name="bezeichnung" value="<?php echo e(old('bezeichnung')); ?>"  placeholder="Bezeichnung der Schnittstelle" class="form-control">
              </div>
              <div class="form-group">
                <label for="IP">IP-Adresse</label>
                <input type="text" id="IP" name="IP" value="<?php echo e(old('IP')); ?>" placeholder="IP-Adresse der Schnittstelle" class="form-control">
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
              <div class="form-group">
                <label for="vlan">VLAN</label>
                <input type="text" id="vlan" name="vlan" value="<?php echo e(old('vlan')); ?>" placeholder="VLAN der Schnittstelle" class="form-control">
              </div>
              <div class="form-group">
                  <label for="subnetmask">Hardwareschnittstelle</label>
                  <select id="hardwareinterface_id" name="hardwareinterface_id" value="<?php echo e(old('hardwareinterface_id')); ?>" class="form-control custom-select">
                    <?php $__currentLoopData = $hardwareinterfaces; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $hardwareinterface): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($hardwareinterface->id); ?>"><?php echo e($hardwareinterface->bezeichnung); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                  </select>
                </div>
              <button type="submit" name="InterfaceSubmit" class="btn btn-primary">Anlegen</button>
            </div>
          </form>
          <!-- /.card-body -->
        </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /media/sf_router/RouterRDF/resources/views/interfaces/create.blade.php ENDPATH**/ ?>