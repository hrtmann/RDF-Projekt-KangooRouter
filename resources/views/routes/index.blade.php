@extends('layouts.master')

@section('content')

<!-- card box -->
@if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif
@if (session('error_kr'))
    <div class="alert alert-danger">
      <h6>Folgender Fehler ist aufgetreten:</h6>
      <ul>
      @foreach(session('error_kr') as $error)
        <li>
        {{$error}}
        </li>
      @endforeach
      </ul>
    </div>
    {{session()->forget('error_kr')}}
@endif
          @foreach($routes as $route)
            <div class="card">
              <div class="card-header">
                <h4 class="card-title"><strong>{{$route->bezeichnung}}</strong></h4>
                <div class="card-tools">
                  <!--btn-group um Icons nebeneinander zu haben-->
                  <div class="btn-group">
                    <!--Status-->
                    @if($route->end_status == 0)
                      <button type="button" class="btn" title="Status">
                        <i class="fas fa-check"></i>
                      </button>
                    @elseif($route->end_status == -1)
                    <button type="button" class="btn" title="Status">
                      <i class="fas fa-question"></i>
                    </button>
                    @elseif($route->end_status != 0)
                    <button type="button" class="btn" title="Status">
                      <i class="fas fa-exclamation"></i>
                    </button>
                    @endif
                    <!--Bearbeiten von Interfaces-->
                    <button type="button" class="btn" title="Bearbeiten" onClick="parent.location='{{route('routes.index') . '/' . $route->id . '/edit'}}'">
                      <i class="fas fa-pen-square"></i>
                    </button>
                    <!-- Löschen von Interfaces-->
                    <form action="{{route('routes.destroy',$route->id)}}" method="post">
                      @csrf
                      @method('DELETE')
                      <!-- Abfrage ob Löschen gewollt -->
                      <button class="btn" type="submit" onclick="return confirm('Wollen Sie dies wirklich löschen?')"><i class="fas fa-trash-alt"></i></button>
                    </form>
                    <!-- Toggle Box -->
                      <label class="checkbox checkbox-toggle">
                      <input data-id="{{$route->id}}" class="toggle-class test" type="checkbox" data-onstyle="primary" data-offstyle="default" data-toggle="toggle" data-on="EIN" data-off="AUS" data-size="mini" data-width="40" data-height="15" {{$route->status ? 'checked' : ''}}>
                    </label>
                  </div>
                </div>
              </div>
              <div class="card-body">
                <div class="row">
                  <div>
                    <strong>Ziel-Netzwerk:</strong> {{$targets[$route->id]['bezeichnung']}}<br>
                    <strong>Next-Hop:</strong> {{$next_hops[$route->id]['bezeichnung']}}<br>
                  </div>
                </div>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          @endforeach
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
@endsection
