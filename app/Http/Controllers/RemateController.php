<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use App\Remate;
use App\Cuadro;
use Illuminate\Support\Facades\Redirect;
use DB;

class RemateController extends Controller {

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
      $remates=DB::table('remate')
			->where ('estado','=','1')
      ->orderBy('idremate')
      ->paginate(7);
      return view('admin.remate.index',["remates"=>$remates]);
    }
    public function create()
    {
				$cuadros=DB::table('cuadro')
				->where ('estado','=','1')
        ->groupBy('artista')
	      ->get();

        return view("admin.remate.create",["cuadros"=>$cuadros]);
    }
    public function store (Request $request) //crear
    {
      $publicar=$request->get('publicar');

      
      $remate=new Remate;
      $remate->nombre=$request->get('nombre'); //s
      $remate->artista=$request->get('artista');
      $remate->fecha=$request->get('fecha'); //s
      $remate->horario=$request->get('horario'); //s
      $remate->direccion=$request->get('direccion'); // s
			$remate->lote=$request->get('lote'); // s
      $remate->descripcion=$request->get('descripcion'); //s
      $remate->estimativo=$request->get('estimativo'); //s
      $remate->horarios_de_exhibicion=$request->get('horarios_de_exhibicion'); // horarios de

      if (Input::hasFile('foto')){
        $file=Input::file('foto'); // almaceno imagen
        $file->move(public_path().'/imagenes/remates/',$file->getClientOriginalName()); //establesco nombre
        $remate->foto=$file->getClientOriginalName();
      }

      if (Input::hasFile('imagen1')){
        $file=Input::file('imagen1'); // almaceno imagen
        $file->move(public_path().'/imagenes/remates/',$file->getClientOriginalName()); //establesco nombre
        $remate->imagen1=$file->getClientOriginalName();
      }

      if (Input::hasFile('imagen2')){
        $file=Input::file('imagen2'); // almaceno imagen
        $file->move(public_path().'/imagenes/remates/',$file->getClientOriginalName()); //establesco nombre
        $remate->imagen2=$file->getClientOriginalName();
      }

      if (Input::hasFile('imagen3')){
        $file=Input::file('imagen3'); // almaceno imagen
        $file->move(public_path().'/imagenes/remates/',$file->getClientOriginalName()); //establesco nombre
        $remate->imagen3=$file->getClientOriginalName();
      }

      $remate->rematador=$request->get('rematador'); // rematador
			
			$imagenes_cuadro=json_encode($request->get('imagenes_cuadros'));
			$item=json_encode($request->get('item'));
			$remate->imagenes_cuadros=$imagenes_cuadro;
			$remate->item=$item;
      if($publicar=="on")
      {
        $remate->publicar="on";
        $remate->fecha_mod= date('d-m-Y',time());
      }
      else{
        $remate->publicar="off";
      }

			$remate->estado=1;
      $remate->save();
      return Redirect::to('admin/remate');

    }
    public function show($id)
    {
        return view("admin.remate.show",["remate"=>Remate::findOrFail($id)]);
    }
    public function edit($id)
    {
				$cuadros=DB::table('cuadro')
				->where ('estado','=','1')
        ->groupBy('artista')
	      ->get();
        return view("admin.remate.edit",["remate"=>Remate::findOrFail($id), "cuadros"=>$cuadros]);
    }
    public function update(Request $request,$id)
    {
      $publicar=$request->get('publicar');
      
      $remate=Remate::findOrFail($id);
      $remate->nombre=$request->get('nombre'); //s
      $remate->artista=$request->get('artista'); //s
      $remate->fecha=$request->get('fecha'); //s
      $remate->horario=$request->get('horario'); //s
      $remate->direccion=$request->get('direccion'); // s
      $remate->lote=$request->get('lote'); // s
      $remate->descripcion=$request->get('descripcion'); //s
      $remate->estimativo=$request->get('estimativo'); //s
      $remate->horarios_de_exhibicion=$request->get('horarios_de_exhibicion'); // horarios de
      
      if (Input::hasFile('foto')){
        $file=Input::file('foto'); // almaceno imagen
        $file->move(public_path().'/imagenes/remates/',$file->getClientOriginalName()); //establesco nombre
        $remate->foto=$file->getClientOriginalName();
      }

      if (Input::hasFile('imagen1')){
        $file=Input::file('imagen1'); // almaceno imagen
        $file->move(public_path().'/imagenes/remates/',$file->getClientOriginalName()); //establesco nombre
        $remate->imagen1=$file->getClientOriginalName();
      }

      if (Input::hasFile('imagen2')){
        $file=Input::file('imagen2'); // almaceno imagen
        $file->move(public_path().'/imagenes/remates/',$file->getClientOriginalName()); //establesco nombre
        $remate->imagen2=$file->getClientOriginalName();
      }

      if (Input::hasFile('imagen3')){
        $file=Input::file('imagen3'); // almaceno imagen
        $file->move(public_path().'/imagenes/remates/',$file->getClientOriginalName()); //establesco nombre
        $remate->imagen3=$file->getClientOriginalName();
      }
      
      $remate->rematador=$request->get('rematador'); // rematador
      $imagenes_cuadro=json_encode($request->get('imagenes_cuadros'));
      $item=json_encode($request->get('item'));
      $remate->imagenes_cuadros=$imagenes_cuadro;
      $remate->item=$item;
      if($publicar=="on")
      {
        $remate->publicar="on";
        $remate->fecha_mod= date('d-m-Y',time());
      }
      else{
        $remate->publicar="off";
      }

      $remate->update();
      return Redirect::to('admin/remate');
    }
    public function destroy($id)
    {
        $remate=Remate::findOrFail($id);
        $remate->estado='0';
        $remate->update();
        return Redirect::to('admin/remate');
    }

}
