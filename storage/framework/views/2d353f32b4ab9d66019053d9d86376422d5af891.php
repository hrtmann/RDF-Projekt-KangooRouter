


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
            <form action ="<?php echo e(route('firewallrules.store')); ?>" method="post">
            <?php echo csrf_field(); ?>
              <div class="card-body" style="display: block;">
              <div class="form-group">
                <label for="bezeichnung">Bezeichnung</label>
                <input type="text" id="bezeichnung" name="bezeichnung" value="<?php echo e(old('bezeichnung')); ?>" placeholder="Bezeichnung der Regel" class="form-control">
              </div>

              <div class="form-group">
                <label for="list">Source</label>
                <select id="source" name="source[]" value="" multiple="multiple" class="form-control custom-select">
                  <?php $__currentLoopData = $definitions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $definition): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                      <option value="d<?php echo e($definition->id); ?>">DEF. <?php echo e($definition->bezeichnung . ' | ' . $definition->ipblock1 . '.' . $definition->ipblock2 . '.' . $definition->ipblock3 . '.' . $definition->ipblock4 . ' / ' . $definition->subnetmask); ?></option>
                  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                  <?php $__currentLoopData = $interfaces; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $interface): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                      <option value="i<?php echo e($interface->id); ?>">INT. <?php echo e($interface->bezeichnung . ' | ' . $interface->ipblock1 . '.' . $interface->ipblock2 . '.' . $interface->ipblock3 . '.' . $interface->ipblock4 . ' / ' . $interface->subnetmask); ?></option>
                  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
                <br>
              </div>
              <div class="form-group">
                <label for="port">Port</label>
                <input type="text" id="port" name="port" value="<?php echo e(old('port')); ?>" placeholder="Port" class="form-control">
              </div>
              <label>Protokoll</label>
                <select class="form-control" name="tcp">
                    <option value="1" selected="selected">TCP</option>
                    <option value="0">UDP</option>
                </select>
              <br>
              <div class="form-group">
                <label for="list">Destination</label>
                <select id="destination" name="destination[]" value="" multiple="multiple" class="form-control custom-select">
                  <?php $__currentLoopData = $definitions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $definition): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                      <option value="d<?php echo e($definition->id); ?>">DEF. <?php echo e($definition->bezeichnung . ' | ' . $definition->ipblock1 . '.' . $definition->ipblock2 . '.' . $definition->ipblock3 . '.' . $definition->ipblock4 . ' / ' . $definition->subnetmask); ?></option>
                  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                  <?php $__currentLoopData = $interfaces; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $interface): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                      <option value="i<?php echo e($interface->id); ?>">INT. <?php echo e($interface->bezeichnung . ' | ' . $interface->ipblock1 . '.' . $interface->ipblock2 . '.' . $interface->ipblock3 . '.' . $interface->ipblock4 . ' / ' . $interface->subnetmask); ?></option>
                  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
              </div>
              <script>
              var source = $('#source').bootstrapDualListbox();
              var destination = $('#destination').bootstrapDualListbox();
              </script>

              <button type="submit" name="FirewallSubmit" class="btn btn-primary">Anlegen</button>
            </div>
          </form>
          <!-- /.card-body -->
        </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /router/RouterRDF/resources/views/firewalls/create.blade.php ENDPATH**/ ?>