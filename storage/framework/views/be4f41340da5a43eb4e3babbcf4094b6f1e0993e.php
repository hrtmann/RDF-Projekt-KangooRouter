


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
            <form action ="<?php echo e(route('interfaces.update', $interface->id)); ?>" method="post">
            <?php echo csrf_field(); ?>
            <?php echo method_field('PATCH'); ?>
              <div class="card-body" style="display: block;">
              <div class="form-group">
                <label for="bezeichnung">Bezeichnung</label>
                <input type="text" id="bezeichnung" name="bezeichnung" value="<?php echo e($interface->bezeichnung); ?>" placeholder="Bezeichnung der Schnittstelle" class="form-control">
              </div>
              <div class="form-group">
                <label for="IP">IP-Adresse</label>
                <?php
                  $ipoutput = $interface->ipblock1 . '.' . $interface->ipblock2 . '.' . $interface->ipblock3 . '.' . $interface->ipblock4;
                ?>
                <input type="text" id="IP" name="IP" value="<?php echo e($ipoutput); ?>" placeholder="IP-Adresse der Schnittstelle" class="form-control">
              </div>
              <div class="form-group">
                  <label for="subnetmask">Subnetzmaske</label>
                  <select id="subnetmask" name="subnetmask" value="<?php echo e($interface->subnetmask); ?>" class="form-control custom-select">
                    <?php for($i = 8; $i < 33; $i++): ?>
                      <?php if($i != 31): ?>
                        <?php if($i == $interface->subnetmask): ?>
                          <option selected="selected" value="<?php echo e($i); ?>"><?php echo e($i); ?></option>
                        <?php else: ?>
                          <option value="<?php echo e($i); ?>"><?php echo e($i); ?></option>
                        <?php endif; ?>
                      <?php endif; ?>
                    <?php endfor; ?>
                  </select>
                </div>
              <div class="form-group">
                <label for="vlan">VLAN</label>
                <input type="text" id="vlan" name="vlan" value="<?php echo e($interface->vlan); ?>" placeholder="VLAN der Schnittstelle" class="form-control">
              </div>
              <div class="form-group">
                  <label for="hardwareinterface_id">Hardwareschnittstelle</label>
                  <select id="hardwareinterface_id" name="hardwareinterface_id" class="form-control custom-select">
                    <?php $__currentLoopData = $hardwareinterfaces; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $hardwareinterface): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                      <?php if($hardwareinterface['id'] == $interface->hardwareinterface_id): ?>
                        <option selected="selected" value="<?php echo e($hardwareinterface['id']); ?>"><?php echo e($hardwareinterface['bezeichnung']); ?></option>
                      <?php else: ?>
                        <option value="<?php echo e($hardwareinterface['id']); ?>"><?php echo e($hardwareinterface['bezeichnung']); ?></option>
                      <?php endif; ?>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                  </select>
                </div>
              <button type="submit" name="InterfaceEdit" class="btn btn-primary">Ändern</button>
            </div>
          </form>
          <!-- /.card-body -->
        </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /media/sf_router/RouterRDF/resources/views/interfaces/edit.blade.php ENDPATH**/ ?>