@extends('layouts.master')

@section('content')

<!-- card box -->
@if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif
          @foreach($nats as $nat)
            <div class="card">
              <div class="card-header">
                <h4 class="card-title"><strong>{{$nat->bezeichnung}}</strong></h4>
                <div class="card-tools">
                  <!--btn-group um Icons nebeneinander zu haben-->
                  <div class="btn-group">
                    <!--Bearbeiten von Interfaces-->
                    <button type="button" class="btn" title="Bearbeiten" onClick="parent.location='{{route('nats.index') . '/' . $nat->id . '/edit'}}'">
                      <i class="fas fa-pen-square"></i>
                    </button>
                    <!-- Löschen von Interfaces-->
                    <form action="{{route('nats.destroy',$nat->id)}}" method="post">
                      @csrf
                      @method('DELETE')
                      <!-- Abfrage ob Löschen gewollt -->
                      <button class="btn" type="submit" onclick="return confirm('Wollen Sie dies wirklich löschen?')"><i class="fas fa-trash-alt"></i></button>
                    </form>
                    <!-- Toggle Box -->
                      <label class="checkbox checkbox-toggle">
                      <input data-id="{{$nat->id}}" class="toggle-class test" type="checkbox" data-onstyle="primary" data-offstyle="default" data-toggle="toggle" data-on="EIN" data-off="AUS" data-size="mini" data-width="40" data-height="15" {{$nat->status ? 'checked' : ''}}>
                    </label>
                  </div>
                </div>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          @endforeach
          <!-- Script für Toggle -->
          <script>
          //Weitergabe an Route
            $(function() {
              $('.toggle-class').change(function() {
                var status = $(this).prop('checked') == true ? 1 : 0;
                var nat_id = $(this).data('id');
                    $.ajax({
                      type: "GET",
                      dataType: "json",
                      url: '/changeStatusNat',
                      data: {'status': status, 'nat_id': nat_id},
                      success: function(data){
                        console.log('Success')
                      }
                    })
              });
          });
          </script>
@endsection
