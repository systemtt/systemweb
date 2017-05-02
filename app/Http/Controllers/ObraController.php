<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use App\Obra;
use App\Cuadro;
use Illuminate\Support\Facades\Redirect;
use DB;

class ObraController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function __construct()
    {

    }
		public function index(Request $request)
    {
      $obras=DB::table('obra')
			->where ('estado','=','1')
      ->orderBy('idobra')
      ->paginate(7);
      return view('admin.obra.index',["obras"=>$obras]);
    }
    public function create()
    {
				$cuadros=Cuadro::all();
        return view("admin.obra.create",["cuadros"=>$cuadros]);
    }
    public function store (Request $request) //crear
    {
      $obra=new Obra;
      $obra->artista=$request->get('artista');
      $obra->tecnica=$request->get('tecnica');
      $obra->titulo_de_obra=$request->get('titulo_de_obra');
			$obra->medidas=$request->get('medidas'); //
			$obra->firmado_en=$request->get('firmado_y_fechado'); //
      $obra->precio=$request->get('precio');
			$imagenes_cuadro=json_encode($request->get('imagenes_cuadros'));
			$item=json_encode($request->get('item'));
			$obra->imagenes_cuadros=$imagenes_cuadro;
      $obra->item=$item;
      //Subir imagen
      if (Input::hasFile('imagenp')){
        $file=Input::file('imagenp'); // almaceno imagen
        $file->move(public_path().'/imagenes/obra/',$file->getClientOriginalName()); //establesco nombre
        $obra->imagenp=$file->getClientOriginalName();
      }
			$obra->estado=1;
      $obra->save();
      return Redirect::to('admin/obra');

    }
    public function show($id)
    {
        return view("admin.obra.show",["obra"=>Obra::findOrFail($id)]);
    }
    public function edit($id)
    {
				$cuadros=Cuadro::all();
        return view("admin.obra.edit",["obra"=>Obra::findOrFail($id), "cuadros"=>$cuadros]);
    }
    public function update(Request $request,$id)
    {
      $obra=Obra::findOrFail($id);
      $obra->artista=$request->get('artista');
      $obra->tecnica=$request->get('tecnica');
      $obra->titulo_de_obra=$request->get('titulo_de_obra');
      $obra->medidas=$request->get('medidas'); //
      $obra->firmado_en=$request->get('firmado_y_fechado'); //
      $obra->precio=$request->get('precio');
      $imagenes_cuadro=json_encode($request->get('imagenes_cuadros'));
      $item=json_encode($request->get('item'));
      $obra->imagenes_cuadros=$imagenes_cuadro;
      $obra->item=$item;
      if (Input::hasFile('imagenp')){
        $file=Input::file('imagenp'); // almaceno imagen
        $file->move(public_path().'/imagenes/obra/',$file->getClientOriginalName()); //establesco nombre
        $obra->imagenp=$file->getClientOriginalName();
      }
      $obra->update();
      return Redirect::to('admin/obra');
    }
    public function destroy($id)
    {
        $obra=Obra::findOrFail($id);
        $obra->estado='0';
        $obra->update();
        return Redirect::to('admin/obra');
    }

}
