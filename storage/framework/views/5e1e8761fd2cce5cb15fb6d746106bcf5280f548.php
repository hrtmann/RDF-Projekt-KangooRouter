

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
            <form action ="<?php echo e(route('routes.update', $route->id)); ?>" method="post">
            <?php echo csrf_field(); ?>
            <?php echo method_field('PATCH'); ?>
              <div class="card-body" style="display: block;">
              <div class="form-group">
                <label for="bezeichnung">Bezeichnung</label>
                <input type="text" id="bezeichnung" name="bezeichnung" value="<?php echo e($route->bezeichnung); ?>" placeholder="Bezeichnung der Route" class="form-control">
              </div>
              <div class="form-group">
                <label for="next_hop">Next-Hop</label>
                  <select class="form-control js-states"  id="next_hop" name="next_hop">
                    <?php $__currentLoopData = $definitions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $definition): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php if($definition['id'] == $route->next_hop): ?>
                        <option selected="selected" value="<?php echo e($definition['id']); ?>"><?php echo e($definition['bezeichnung']); ?></option>
                        <?php else: ?>
                        <option value="<?php echo e($definition['id']); ?>"><?php echo e($definition['bezeichnung']); ?></option>
                        <?php endif; ?>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                  </select>
                </div>
                <div class="form-group">
                  <label for="definition_id">Ziel-Netzwerk</label>
                    <select class="form-control js-states"  id="target" name="target">
                      <?php $__currentLoopData = $definitions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $definition): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                          <?php if($definition['id'] == $route->target): ?>
                          <option selected="selected" value="<?php echo e($definition['id']); ?>"><?php echo e($definition['bezeichnung']); ?></option>
                          <?php else: ?>
                          <option value="<?php echo e($definition['id']); ?>"><?php echo e($definition['bezeichnung']); ?></option>
                          <?php endif; ?>
                      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                  </div>

                <!--Script für Dropdown mit Suche-->
                <script>
                      $(document).ready(function() { $("#definition_id").select2(); });
                </script>
                  <button type="submit" name="InterfaceEdit" class="btn btn-primary">Ändern</button>
              </div>
            </form>
          </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /router/RouterRDF/resources/views/routes/edit.blade.php ENDPATH**/ ?>