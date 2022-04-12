<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\NatModel;

class NatController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      $nats = NatModel::all();

      return view('nats.index', compact('nats'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
      $nats = NatModel::all();

      return view('nats.create', compact('nats'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      $data = $request->validate([
        'bezeichnung' => 'required|string|max:255',
      ]);

      $nat = new NatModel($data);
      $nat->save();

      return redirect('/nats')->with('success', 'NAT erfolgreich angelegt!');
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
      $nat = NatModel::findOrFail($id);
      return view( 'nats.edit', compact('nat'));
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
      $data = $request->validate([
        'bezeichnung' => 'required|string|max:255',
      ]);

      NatModel::whereId($id)->update($data);

      return redirect('/nats')->with('success', 'NAT erfolgreich geändert!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
      $nat = NatModel::findOrFail($id);
      $nat->delete();

      return redirect('/nats')->with('success', 'NAT erfolgreich gelöscht!');
    }
    public function changeStatus(Request $request){
      $nats = NatModel::find($request->nat_id);
      $nats->status = $request->status;
      $nats->save();
    }
}
