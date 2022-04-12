

<?php $__env->startSection('content'); ?>

<script>

    $(document).ready(function() {
      var intervalId = window.setInterval(getData, 2000);
      function getData(){

                $.ajax({
                url:"/ajax/getAjaxData",
                type:"GET",
                success:function(JsonArray){
                    document.getElementById("CPU").innerHTML = JsonArray[0].toFixed(2) + '%';
                    document.getElementById("Arbeitsspeicher").innerHTML = JsonArray[1].toFixed(2) + '%';
                    var Netzwerkschnittstellen = JsonArray[2];
                    $('#Netzwerkschnittstellen tbody').empty();
                    Netzwerkschnittstellen.forEach ( Netzwerkschnittstelle => $('#Netzwerkschnittstellen tbody').append("<tr><td>" + Netzwerkschnittstelle[0] + "</td><td>" + Netzwerkschnittstelle[1] + "</td><td>" + Netzwerkschnittstelle[2] + "</td><td>" + Netzwerkschnittstelle[3] + "</td></tr>") );

                    var Services = JsonArray[3];
                    $('#Dienste tbody').empty();
                    Services.forEach ( Service => {
                      $tableData = "<tr><td>" + Service[0] + "</td><td><font color='";
                      switch (Service[2]) {
                        case 'running':
                          $tableData = $tableData + 'green';
                          break;
                        case 'exited':
                          $tableData = $tableData + 'blue';
                          break;
                        case 'failed':
                          $tableData = $tableData + 'red';
                          break;
                        default:
                          $tableData = $tableData + 'yellow';
                          break;
                      }
                      $tableData = $tableData + "'>"+ Service[2] +"</font></td></tr>";
                      $('#Dienste tbody').append($tableData);
                    }
                  );
                    //document.getElementById("Pakete2").innerHTML = JsonArray[5];
                    //$('#Pakete tbody').append("<tr><td>" + Pakete + "</td></tr>");
                  //Pakete.forEach ( Pakete => $('#Pakete tbody').append("<tr><td>" + Zeit + "</td><td>" + Pakete + "</td></tr>") );

                },
                dataType:"json"
              });

            }
    });

      </script>
          <div class="card">
            <label for="Pakete2"></label>
              <header class="card-header">
            		<a href="#" data-toggle="collapse" data-target="#collapse12" aria-expanded="true" class="">
            			<i class="icon-action fa fa-chevron-down"></i>
            			<span class="title">Auslastung </span>
            		</a>
            	</header>
    <article class="card-body">

            <div class="collapse show" id="collapse12" style="">
            <div class="info-box">
                <span class="info-box-icon bg-info elevation-1"><i class="fas fa-cog"></i></span>

                  <div class="info-box-content">
                  <span class="info-box-text">CPU Traffic</span>
                  <span class="info-box-number" id="CPU">
                          0
                  <small>%</small>
                </span>
            </div>

         </div>


           <div class="info-box">
               <span class="info-box-icon bg-info elevation-1"><i class="fas fa-cog"></i></span>

                 <div class="info-box-content">
                   <span class="info-box-text">Arbeitsspeicher</span>
                   <span class="info-box-number" id="Arbeitsspeicher">
                           0
                   <small>%</small>
                  </span>
                </div>
         </div>
      </div>
  </article>

      <header class="card-header">
    		<a href="#" data-toggle="collapse" data-target="#collapse13" aria-expanded="true" class="">
    			<i class="icon-action fa fa-chevron-down"></i>
    			<span class="title">Netzwerkschnittstellen </span>
    		</a>
    	</header>

            <article class="card-body">
      <div class="collapse show" id="collapse13" style="">
      <div>
        <table id="Netzwerkschnittstellen" class="table table-dark">

          <thead>
            <tr>
            <th>
                Name
            </th>
            <th>
              Device
            </th>
            <th>
              Transmitted
            </th>
            <th>
              Received
            </th>
          </tr>
          </thead>
          <tbody>
          </tbody>
        </table>
      </div>
    </div>
  </article>

    <header class="card-header">
		<a href="#" data-toggle="collapse" data-target="#collapse11" aria-expanded="true" class="">
			<i class="icon-action fa fa-chevron-down"></i>
			<span class="title">Dienste </span>
		</a>
	</header>
	<div class="collapse show" id="collapse11" style="">
		<article class="card-body">

        <table id="Dienste" class="table table-dark table-striped">
          <thead>
          <tr>
            <th>
                Dienste
            </th>
            <th>
                Status
            </th>
          </tr>
        </thead>
          <tbody>
          </tbody>
        </table>
		</article>
	</div>
</div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /media/sf_router/RouterRDF/resources/views/dashboard/index.blade.php ENDPATH**/ ?>