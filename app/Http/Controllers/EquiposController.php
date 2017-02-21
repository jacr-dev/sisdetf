<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Requests\EquipoRequest;
use App\Equipo;
use Laracasts\Flash\Flash;
use App\Marca;
use App\Modelo;
class EquiposController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      $equipos = Equipo::orderBy('id', 'DESC')->paginate(5);
      $equipos->each(function ($equipos){
          $equipos->modelo;
      });

      return view('admin.equipos.index')
          ->with('equipos', $equipos);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
      $modelos = Modelo::orderBy('modelo', 'ASC')->lists('modelo','id');
      $marcas = Marca::orderBy('marca', 'ASC')->lists('marca','id');

      return view('admin.equipos.create')
          ->with('modelos', $modelos)
          ->with('marcas', $marcas);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(EquipoRequest $request)
    {
      $equipo = new Equipo($request->all());
      $equipo->save();

      Flash::success("Se ha registrado el equipo ". $equipo->equipo. " exitosamente!");

      return redirect()->route('admin.equipos.index');
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
      $equipo = Equipo::find($id);
      $equipo->modelo;

      $modelos = Modelo::orderBy('modelo', 'ASC')->lists('modelo','id');
      $marcas = Marca::orderBy('marca', 'ASC')->lists('marca','id');
      return view('admin.equipos.edit')
          ->with('modelos', $modelos)
          ->with('marcas', $marcas)
          ->with('equipo', $equipo);
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
      $equipo = Equipo::find($id);
      $equipo->fill($request->all());
      $equipo->save();

      Flash::warning('El equipo : ' . $equipo->equipo . ' ha sido editado exitosamente');
      return redirect()->route('admin.equipos.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
      $equipo = Equipo::find($id);
      $equipo->delete();
      flash('El equipo ' . $equipo->equipo . 'se borro exitosamente', 'danger');
      return redirect()->route('admin.equipos.index');
    }
}
