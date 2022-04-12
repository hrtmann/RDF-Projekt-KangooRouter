


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
            <form action ="<?php echo e(route('firewallrules.update', $fwrule->id)); ?>" method="post" enctype="multipart/form-data">
            <?php echo csrf_field(); ?>
            <?php echo method_field('PATCH'); ?>
              <div class="card-body" style="display: block;">
              <div class="form-group">
                <label for="bezeichnung">Bezeichnung</label>
                <input type="text" id="bezeichnung" name="bezeichnung" value="<?php echo e($fwrule->bezeichnung); ?>" placeholder="Bezeichnung der Regel" class="form-control">
              </div>
              <div class="form-group">
                <label for="list">Source</label>
                <select id="source" name="source[]" value="" multiple="multiple" class="form-control custom-select">
                  <?php $__currentLoopData = $definitions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $definition): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php if($setobjectssource->where('definition_id', $definition->id)->count() > 0): ?>
                      <option value="d<?php echo e($definition->id); ?>" selected="selected">DEF. <?php echo e($definition->bezeichnung . ' | ' . $definition->ipblock1 . '.' . $definition->ipblock2 . '.' . $definition->ipblock3 . '.' . $definition->ipblock4 . ' / ' . $definition->subnetmask); ?></option>
                    <?php else: ?>
                      <option value="d<?php echo e($definition->id); ?>">DEF. <?php echo e($definition->bezeichnung . ' | ' . $definition->ipblock1 . '.' . $definition->ipblock2 . '.' . $definition->ipblock3 . '.' . $definition->ipblock4 . ' / ' . $definition->subnetmask); ?></option>
                    <?php endif; ?>
                  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                  <?php $__currentLoopData = $interfaces; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $interface): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php if($setobjectssource->where('interface_id', $interface->id)->count() > 0): ?>
                      <option value="i<?php echo e($interface->id); ?>" selected="selected">INT. <?php echo e($interface->bezeichnung . ' | ' . $interface->ipblock1 . '.' . $interface->ipblock2 . '.' . $interface->ipblock3 . '.' . $interface->ipblock4 . ' / ' . $interface->subnetmask); ?></option>
                    <?php else: ?>
                      <option value="i<?php echo e($interface->id); ?>">INT. <?php echo e($interface->bezeichnung . ' | ' . $interface->ipblock1 . '.' . $interface->ipblock2 . '.' . $interface->ipblock3 . '.' . $interface->ipblock4 . ' / ' . $interface->subnetmask); ?></option>
                    <?php endif; ?>
                  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
              </div>
              <div class="form-group">
                <label for="port">Port</label>
                <?php if(empty($fwrule->port_end)): ?>
                  <input type="text" id="port" name="port" value="<?php echo e($fwrule->port); ?>" placeholder="Port" class="form-control">
                <?php else: ?>
                  <input type="text" id="port" name="port" value="<?php echo e($fwrule->port); ?>-<?php echo e($fwrule->port_end); ?>" placeholder="Port" class="form-control">
                <?php endif; ?>
              </div>

              <label>Protokoll</label>
                <select class="form-control" name="tcp">
                  <?php if($fwrule->tcp == 1): ?>
                    <option value="1" selected="selected">TCP</option>
                    <option value="0">UDP</option>
                  <?php endif; ?>
                  <?php if($fwrule->tcp == 0): ?>
                    <option value="1">TCP</option>
                    <option value="0" selected="selected">UDP</option>
                  <?php endif; ?>
                </select>
              <br>
              <div class="form-group">
                <label for="list">Destination</label>
                <select id="destination" name="destination[]" value="" multiple="multiple" class="form-control custom-select">
                  <?php $__currentLoopData = $definitions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $definition): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php if($setobjectsdest->where('definition_id', $definition->id)->count() > 0): ?>
                      <option value="d<?php echo e($definition->id); ?>" selected="selected">DEF. <?php echo e($definition->bezeichnung . ' | ' . $definition->ipblock1 . '.' . $definition->ipblock2 . '.' . $definition->ipblock3 . '.' . $definition->ipblock4 . ' / ' . $definition->subnetmask); ?></option>
                    <?php else: ?>
                      <option value="d<?php echo e($definition->id); ?>">DEF. <?php echo e($definition->bezeichnung . ' | ' . $definition->ipblock1 . '.' . $definition->ipblock2 . '.' . $definition->ipblock3 . '.' . $definition->ipblock4 . ' / ' . $definition->subnetmask); ?></option>
                    <?php endif; ?>
                  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                  <?php $__currentLoopData = $interfaces; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $interface): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php if($setobjectsdest->where('interface_id', $interface->id)->count() > 0): ?>
                      <option value="i<?php echo e($interface->id); ?>" selected="selected">INT. <?php echo e($interface->bezeichnung . ' | ' . $interface->ipblock1 . '.' . $interface->ipblock2 . '.' . $interface->ipblock3 . '.' . $interface->ipblock4 . ' / ' . $interface->subnetmask); ?></option>
                    <?php else: ?>
                      <option value="i<?php echo e($interface->id); ?>">INT. <?php echo e($interface->bezeichnung . ' | ' . $interface->ipblock1 . '.' . $interface->ipblock2 . '.' . $interface->ipblock3 . '.' . $interface->ipblock4 . ' / ' . $interface->subnetmask); ?></option>
                    <?php endif; ?>
                  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
              </div>
              <script>
              var source = $('#source').bootstrapDualListbox();
              var destination = $('#destination').bootstrapDualListbox();
              </script>
              <button type="submit" name="FirewallEdit" class="btn btn-primary">Ändern</button>
            </div>
          </form>
          <!-- /.card-body -->
        </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /media/sf_router/RouterRDF/resources/views/firewalls/edit.blade.php ENDPATH**/ ?>