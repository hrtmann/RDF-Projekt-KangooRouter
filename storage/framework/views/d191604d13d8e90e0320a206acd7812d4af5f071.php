<?php $__env->startSection('content'); ?>

<script>

    $(document).ready(function() {
      var intervalId = window.setInterval(getData, 2000);
      function getData(){

                $.ajax({
                url:"/ajax/getAjaxData",
                type:"GET",
                success:function(JsonArray){
                  var Pakete = JsonArray[4];
                  var Zeit = JsonArray[5];
                  var aktZeit = new Date(Zeit).getTime();
                  $('#Pakete tbody').empty();
                  Pakete.reverse().forEach(Paket => {
                      strPaket = String(Paket);
                      millis = parseFloat(strPaket.substring(strPaket.indexOf("[") + 1, strPaket.indexOf("]"))) * 1000;
                      fehlerZeit = new Date(aktZeit + millis);

                      //formatfehlerZeit = dateFormat(fehlerZeit, "dddd, mmmm dS, yyyy, h:MM:ss TT");
                      //formatfehlerZeit = dateFormat(fehlerZeit, "dd.mm.yyyy, h:MM:ss TT");
                      $('#Pakete tbody').append("<tr><td>" + fehlerZeit.toLocaleString() + "</td><td>" + strPaket.substring(strPaket.indexOf("]") + 1, strPaket.length) + "</td></tr>");
                  });
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
  <header class="card-header">
  <a href="#" data-toggle="collapse" data-target="#collapse14" aria-expanded="true" class="">
    <i class="icon-action fa fa-chevron-down"></i>
    <span class="title">Abgelehnte Pakete </span>
  </a>
</header>
<div class="collapse show" id="collapse14" style="">
  <article class="card-body">

      <table id="Pakete" class="table table-dark table-striped">
        <thead>
        <tr>
          <th>
              Zeit
          </th>
          <th>
              Paket
          </th>
        </tr>
      </thead>
        <tbody>
        </tbody>
      </table>
  </article>
</div>
</div>
</div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /router/RouterRDF/resources/views/dashboard/packets.blade.php ENDPATH**/ ?>