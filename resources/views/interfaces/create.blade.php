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
            <form action ="{{route('interfaces.store')}}" method="post">
            @csrf
              <div class="card-body" style="display: block;">
              <div class="form-group">
                <label for="bezeichnung">Bezeichnung</label>
                <input type="text" id="bezeichnung" name="bezeichnung" value="{{old('bezeichnung')}}"  placeholder="Bezeichnung der Schnittstelle" class="form-control">
              </div>
              <div class="form-group">
                <label for="IP">IP-Adresse</label>
                <input type="text" id="IP" name="IP" value="{{old('IP')}}" placeholder="IP-Adresse der Schnittstelle" class="form-control">
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
              <div class="form-group">
                <label for="vlan">VLAN</label>
                <input type="text" id="vlan" name="vlan" value="{{old('vlan')}}" placeholder="VLAN der Schnittstelle" class="form-control">
              </div>
              <div class="form-group">
                  <label for="subnetmask">Hardwareschnittstelle</label>
                  <select id="hardwareinterface_id" name="hardwareinterface_id" value="{{old('hardwareinterface_id')}}" class="form-control custom-select">
                    @foreach ($hardwareinterfaces as $hardwareinterface)
                        <option value="{{$hardwareinterface->id}}">{{$hardwareinterface->bezeichnung}}</option>
                    @endforeach
                  </select>
                </div>
              <button type="submit" name="InterfaceSubmit" class="btn btn-primary">Anlegen</button>
            </div>
          </form>
          <!-- /.card-body -->
        </div>
@endsection
