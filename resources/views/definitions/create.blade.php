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
            <form action ="{{route('definitions.store')}}" method="post">
            @csrf
              <div class="card-body" style="display: block;">
              <div class="form-group">
                <label for="bezeichnung">Bezeichnung</label>
                <input type="text" id="bezeichnung" name="bezeichnung" value="{{old('bezeichnung')}}" placeholder="Bezeichnung der Definition" class="form-control">
              </div>
              <div class="form-group">
                <label for="IP">IP-Adresse</label>
                <input type="text" id="IP" name="IP" value="{{old('IP')}}" placeholder="IP-Adresse der Definition" class="form-control">
              </div>
              <div class="form-group">
                  <label for="subnetmask">Subnetzmaske</label>
                  <select id="subnetmask" name="subnetmask" value="{{old('subnetmask')}}" class="form-control custom-select">
                    @for ($i = 8; $i < 33; $i++)
                      @if ($i != 31)
                        <option>{{$i}}</option>
                      @endif
                    @endfor
                  </select>
                </div>
              <button type="submit" name="DefinitionSubmit" class="btn btn-primary">Anlegen</button>
            </div>
          </form>
          <!-- /.card-body -->
        </div>
@endsection
