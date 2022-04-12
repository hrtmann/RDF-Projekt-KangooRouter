

<?php $__env->startSection('content'); ?>

<!-- card box -->
<?php if(session('success')): ?>
    <div class="alert alert-success">
        <?php echo e(session('success')); ?>

    </div>
<?php endif; ?>
<?php if(session('error_kr')): ?>
    <div class="alert alert-danger">
      <h6>Folgender Fehler ist aufgetreten:</h6>
      <ul>
      <?php $__currentLoopData = session('error_kr'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <li>
        <?php echo e($error); ?>

        </li>
      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
      </ul>
    </div>
    <?php echo e(session()->forget('error_kr')); ?>

<?php endif; ?>
          <?php $__currentLoopData = $routes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $route): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="card">
              <div class="card-header">
                <h4 class="card-title"><strong><?php echo e($route->bezeichnung); ?></strong></h4>
                <div class="card-tools">
                  <!--btn-group um Icons nebeneinander zu haben-->
                  <div class="btn-group">
                    <!--Status-->
                    <?php if($route->end_status == 0): ?>
                      <button type="button" class="btn" title="Status">
                        <i class="fas fa-check"></i>
                      </button>
                    <?php elseif($route->end_status == -1): ?>
                    <button type="button" class="btn" title="Status">
                      <i class="fas fa-question"></i>
                    </button>
                    <?php elseif($route->end_status != 0): ?>
                    <button type="button" class="btn" title="Status">
                      <i class="fas fa-exclamation"></i>
                    </button>
                    <?php endif; ?>
                    <!--Bearbeiten von Interfaces-->
                    <button type="button" class="btn" title="Bearbeiten" onClick="parent.location='<?php echo e(route('routes.index') . '/' . $route->id . '/edit'); ?>'">
                      <i class="fas fa-pen-square"></i>
                    </button>
                    <!-- Löschen von Interfaces-->
                    <form action="<?php echo e(route('routes.destroy',$route->id)); ?>" method="post">
                      <?php echo csrf_field(); ?>
                      <?php echo method_field('DELETE'); ?>
                      <!-- Abfrage ob Löschen gewollt -->
                      <button class="btn" type="submit" onclick="return confirm('Wollen Sie dies wirklich löschen?')"><i class="fas fa-trash-alt"></i></button>
                    </form>
                    <!-- Toggle Box -->
                      <label class="checkbox checkbox-toggle">
                      <input data-id="<?php echo e($route->id); ?>" class="toggle-class test" type="checkbox" data-onstyle="primary" data-offstyle="default" data-toggle="toggle" data-on="EIN" data-off="AUS" data-size="mini" data-width="40" data-height="15" <?php echo e($route->status ? 'checked' : ''); ?>>
                    </label>
                  </div>
                </div>
              </div>
              <div class="card-body">
                <div class="row">
                  <div>
                    <strong>Ziel-Netzwerk:</strong> <?php echo e($targets[$route->id]['bezeichnung']); ?><br>
                    <strong>Next-Hop:</strong> <?php echo e($next_hops[$route->id]['bezeichnung']); ?><br>
                  </div>
                </div>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
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
                var status = $(this).prop('checked') == true ? 1 : 0;
                var route_id = $(this).data('id');
                    $.ajax({
                      type: "GET",
                      dataType: "json",
                      url: '/changeStatusRoute',
                      data: {'status': status, 'route_id': route_id},
                      async: true,
                      cache: false,
                      success: function(data){
                        console.log('Success');
                      },
                      error: function(data) {
                        console.log('Error');
                      }
                    })
              });
          });


          </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /router/RouterRDF/resources/views/routes/index.blade.php ENDPATH**/ ?>