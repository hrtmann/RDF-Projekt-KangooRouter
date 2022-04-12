@extends('layouts.master')


@section('content')
        @if($errors->any())
        <div class="alert alert-danger">
          <ul>
            @foreach($errors->all() as $error)
              <li>{{$error}}</li>
            @endforeach
          </ul>
        </div>
        @endif

        <div class="card card-primary">
            <form action ="{{route('routes.store')}}" method="post">
            @csrf
              <div class="card-body" style="display: block;">
              <div class="form-group">
                <label for="bezeichnung">Bezeichnung</label>
                <input type="text" id="bezeichnung" name="bezeichnung" value="{{old('bezeichnung')}}" placeholder="Bezeichnung der Route" class="form-control">
              </div>
              <div class="form-group">
                <label for="next_hop">Next Hop</label>
                  <select class="form-control js-states"  id="next_hop" name="next_hop">
                    @foreach ($definitions as $definition)
                        <option value="{{$definition->id}}">{{$definition->bezeichnung}}</option>
                    @endforeach
                  </select>
                </div>
            <div class="form-group">
              <label for="target">Ziel-Netzwerk</label>
                <select class="form-control js-states"  id="target" name="target">
                  @foreach ($definitions as $definition)
                      <option value="{{$definition->id}}">{{$definition->bezeichnung}}</option>
                  @endforeach
                </select>
              </div>

              <!--Script für Select2-->
              <script>
                    $(document).ready(function() { $("#next_hop").select2(); });
                    $(document).ready(function() { $("#target").select2(); });
              </script>

              <button type="submit" name="DefinitionSubmit" class="btn btn-primary">Anlegen</button>
            </div>
          </form>
          <!-- /.card-body -->
        </div>
@endsection
