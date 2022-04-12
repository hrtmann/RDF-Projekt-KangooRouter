<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DefinitionModel;
use App\Models\FirewallSDModel;

use App\Http\Controllers\osclasses\firewalldController;


class DefinitionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $definitions = DefinitionModel::all();

        return view('definitions.index', compact('definitions'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $definitions = DefinitionModel::all();

        return view('definitions.create', compact('definitions'));
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
        'IP' => 'required|ip',
        'subnetmask' => 'required|integer|between:8,32',
      ]);

      $ipexplode = explode('.', $data['IP']);
      unset($data['IP']);
      $data['ipblock1'] = $ipexplode[0];
      $data['ipblock2'] = $ipexplode[1];
      $data['ipblock3'] = $ipexplode[2];
      $data['ipblock4'] = $ipexplode[3];

      $definition = new DefinitionModel($data);
      $definition->save();

      return redirect('/definitions')->with('success', 'Definition erfolgreich angelegt!');

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
        $definition = DefinitionModel::findOrFail($id);
        return view( 'definitions.edit', compact('definition'));
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
        'IP' => 'required|ip',
        'subnetmask' => 'required|integer|between:8,32',
      ]);

      $firewalld = new firewalldController();
      $firewalld->FlushRuleSet();

      $ipexplode = explode('.', $data['IP']);
      unset($data['IP']);
      $data['ipblock1'] = $ipexplode[0];
      $data['ipblock2'] = $ipexplode[1];
      $data['ipblock3'] = $ipexplode[2];
      $data['ipblock4'] = $ipexplode[3];

      DefinitionModel::whereId($id)->update($data);

      $firewalld->CreateRuleSet();

      return redirect('/definitions')->with('success', 'Definition erfolgreich geändert!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
      $firewalld = new firewalldController();
      $firewalld->FlushRuleSet();

      $definition = DefinitionModel::findOrFail($id);
      $definition->delete();

      $firewallSD = FirewallSDModel::where('definition_id', $id);
      foreach($firewallSD as $SD) {
        $SD->delete();
      }

      $firewalld->CreateRuleSet();

      return redirect('/definitions')->with('success', 'Definition erfolgreich gelöscht!');
    }
}
