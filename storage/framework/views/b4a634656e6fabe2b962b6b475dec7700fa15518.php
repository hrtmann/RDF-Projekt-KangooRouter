

<?php $__env->startSection('content'); ?>

<!-- card box -->
<?php if(session('success')): ?>
    <div class="alert alert-success">
        <?php echo e(session('success')); ?>

    </div>
<?php endif; ?>
          <?php $__currentLoopData = $fwrules; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $fwrule): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="card">
              <div class="card-header">
                <h4 class="card-title"><strong><?php echo e($fwrule->bezeichnung); ?></strong></h4>
                <div class="card-tools">
                  <!--Status-->
                  <?php if($fwrule->end_status == 0): ?>
                    <button type="button" class="btn" title="Status">
                      <i class="fas fa-check"></i>
                    </button>
                  <?php elseif($fwrule->end_status == -1): ?>
                  <button type="button" class="btn" title="Status">
                    <i class="fas fa-question"></i>
                  </button>
                  <?php elseif($fwrule->end_status != 0): ?>
                  <button type="button" class="btn" title="Status">
                    <i class="fas fa-exclamation"></i>
                  </button>
                  <?php endif; ?>
                  <!--btn-group um Icons nebeneinander zu haben-->
                  <div class="btn-group">
                    <!--Bearbeiten von Interfaces-->
                    <button type="button" class="btn" title="Bearbeiten" onClick="parent.location='<?php echo e(route('firewallrules.index') . '/' . $fwrule->id . '/edit'); ?>'">
                      <i class="fas fa-pen-square"></i>
                    </button>
                    <!-- Löschen von Interfaces-->
                    <form action="<?php echo e(route('firewallrules.destroy',$fwrule->id)); ?>" method="post">
                      <?php echo csrf_field(); ?>
                      <?php echo method_field('DELETE'); ?>
                      <!-- Abfrage ob Löschen gewollt -->
                      <button class="btn" type="submit" onclick="return confirm('Wollen Sie dies wirklich löschen?')"><i class="fas fa-trash-alt"></i></button>
                    </form>
                    <!-- Toggle Box -->
                      <label class="checkbox checkbox-toggle">
                      <input data-id="<?php echo e($fwrule->id); ?>" class="toggle-class loading-page" type="checkbox" data-onstyle="primary" data-offstyle="default" data-toggle="toggle" data-on="EIN" data-off="AUS" data-size="mini" data-width="40" data-height="15" <?php echo e($fwrule->status ? 'checked' : ''); ?>>
                    </label>
                  </div>
                </div>
              </div>

                <div class="card-body">
                  <div class="row">
                  <div style="width: 40%;">
                    <div >
                        <strong>Port: </strong> <?php echo e($fwrule->port); ?>;
                        <strong> PortEnd: </strong> <?php echo e($fwrule->port_end); ?><br>
                        <strong>Protokoll: </strong><?php if($fwrule->tcp == 1): ?> TCP <?php else: ?> UDP <?php endif; ?>
                        <br>
                        <strong>Source: </strong>
                        <br>
                        <strong class="col-sm-6 col-sm-offset-3">Definitions: </strong><br>
                      <ul>
                        <?php $__currentLoopData = $setobjectssource->where('firewallrule_id', $fwrule->id)->whereNull('interface_id'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $source): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <li><?php echo e($definitions->where('id', $source->definition_id)->first()->bezeichnung); ?></li>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                      </ul>

                        <strong class="col-sm-6 col-sm-offset-3">Interfaces: </strong><br>
                      <ul>
                        <?php $__currentLoopData = $setobjectssource->where('firewallrule_id', $fwrule->id)->whereNull('definition_id'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $interface): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <li><?php echo e($interfaces->where('id', $interface->interface_id)->first()->bezeichnung); ?></li>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                      </ul>
                  </div>
                </div>

                <div style="width: 40%;">
                  <div >
                      <br><br>
                      <strong>Destination: </strong>
                      <br>
                      <strong class="col-sm-6 col-sm-offset-3">Definitions: </strong><br>
                      <ul>
                      <?php $__currentLoopData = $setobjectsdest->where('firewallrule_id', $fwrule->id)->whereNull('interface_id'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $source): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                      <li><?php echo e($definitions->where('id', $source->definition_id)->first()->bezeichnung); ?></li>
                      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </ul>

                      <strong class="col-sm-6 col-sm-offset-3">Interfaces: </strong><br>
                    <ul>
                      <?php $__currentLoopData = $setobjectsdest->where('firewallrule_id', $fwrule->id)->whereNull('definition_id'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $interface): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                      <li><?php echo e($interfaces->where('id', $interface->interface_id)->first()->bezeichnung); ?></li>
                      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </ul>
                  </div>
                </div>

                </div>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->

            <!-- Script für Toggle -->
            <script>
            $(document).ajaxSend(function(event, jqxhr, settings){
                $.LoadingOverlay("show");
            });
            $(document).ajaxComplete(function(event, jqxhr, settings){
                //$.LoadingOverlay("hide");
                location.reload();
            });
            //Weitergabe an Route
              $(function() {
                $('.toggle-class').change(function() {
                  var trigger = 1;
                  var status = $(this).prop('checked') == true ? 1 : 0;
                  var firewall_id = $(this).data('id');
                      $.ajax({
                        type: "GET",
                        dataType: "json",
                        url: '/changeStatusFirewall',
                        data: {'status': status, 'firewall_id': firewall_id},
                        async: true,
                        cache: false,
                        success: function(data){
                          console.log('Success');
                        }
                      })
                });
            });
            </script>
          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /media/sf_router/RouterRDF/resources/views/firewalls/index.blade.php ENDPATH**/ ?>