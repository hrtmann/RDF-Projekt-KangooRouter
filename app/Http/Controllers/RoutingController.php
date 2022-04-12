<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RoutingModel;
use App\Models\DefinitionModel;

use App\Http\Controllers\osclasses\iprouteController;

class RoutingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $routes = RoutingModel::all();

        $targets = array();
        $next_hops = array();

        foreach($routes as $route) {
          $targets[$route->id] = DefinitionModel::findOrFail($route->target)->toArray();
          $next_hops[$route->id] = DefinitionModel::findOrFail($route->next_hop)->toArray();
        }

        $tr = new iprouteController();
        //$tr->CreateRoute(12);
        return view('routes.index', compact('routes', 'targets', 'next_hops'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $definitions = DefinitionModel::all();
        $routes = RoutingModel::all();

        return view('routes.create', compact('routes', 'definitions'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $data = $request->validate([
          'bezeichnung' => 'required|string|max:255',
          'next_hop' => 'required|integer',
          'target' => 'required|integer'
        ]);

        $routing = new RoutingModel($data);
        $routing->save();

        return redirect('/routes')->with('success', 'Route erfolgreich angelegt!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //

        $route = RoutingModel::findOrFail($id);
        $definitions = DefinitionModel::all()->toArray();

        //dd($definitions);

        return view( 'routes.edit', compact('route', 'definitions'));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        $data = $request->validate([
          'bezeichnung' => 'required|string|max:255',
          'next_hop' => 'required|integer',
          'target' => 'required|integer'
        ]);

        $routing = RoutingModel::findOrFail($id);
        if($routing->status == 1) {
          $rt = new iprouteController();
          $rt->DelRoute($id);

        }

        RoutingModel::whereId($id)->update($data);

        if($routing->status == 1) {
          $rt->CreateRoute($id);
        }

        return redirect('/routes')->with('success', 'Route erfolgreich geändert!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $routing = RoutingModel::findOrFail($id);
        if($routing->status == 1) {
          $rt = new iprouteController();
          $rt->DelRoute($id);
          $rt->CreateRoute($id);
        }

        $routing->delete();

        return redirect('/routes')->with('success', 'Route erfolgreich gelöscht!');
    }


    public function changeStatus(Request $request){
      $routes = RoutingModel::find($request->route_id);
      $routes->status = $request->status;
      $routes->save();

      $rt = RoutingModel::findOrFail($routes->id);
      if($rt->status == 0) {
        $iproute = new iprouteController();
        $status = $iproute->DelRoute($rt->id);
      }
      else if($rt->status == 1) {
        $iproute = new iprouteController();
        $status = $iproute->CreateRoute($rt->id);
      }
      return $status;
    }

}
