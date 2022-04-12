@extends('layouts.master')

@section('content')

<!-- card box -->
@if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif
          @foreach($definitions as $definition)
            <div class="card">
              <div class="card-header">
                <h4 class="card-title"><strong>{{$definition->bezeichnung}}</strong></h4>
                <div class="card-tools">
                  <!--btn-group um Icons nebeneinander zu haben-->
                  <div class="btn-group">
                    <!--Bearbeiten von Interfaces-->
                    <button type="button" class="btn" title="Bearbeiten" onClick="parent.location='{{route('definitions.index') . '/' . $definition->id . '/edit'}}'">
                      <i class="fas fa-pen-square"></i>
                    </button>
                    <!-- Löschen von Interfaces-->
                    <form action="{{route('definitions.destroy',$definition->id)}}" method="post">
                      @csrf
                      @method('DELETE')
                      <!-- Abfrage ob Löschen gewollt -->
                      <button class="btn" type="submit" onclick="return confirm('Wollen Sie dies wirklich löschen?')"><i class="fas fa-trash-alt"></i></button>
                    </form>
                  </div>
                </div>
              </div>
              <div class="card-body">
                <div class="row">
                  <div>
                    <strong>IP-Adresse:</strong> {{$definition->ipblock1 . '.' . $definition->ipblock2 . '.' . $definition->ipblock3 . '.' . $definition->ipblock4 . ' / ' . $definition->subnetmask}}<br>
                  </div>
                </div>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          @endforeach
@endsection
