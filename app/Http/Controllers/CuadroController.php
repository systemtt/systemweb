<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use App\Cuadro;
use Illuminate\Support\Facades\Redirect;
use DB;

class CuadroController extends Controller {

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
        if ($request)
        {
            $query=trim($request->get('busqueda'));
            $cuadros=DB::table('cuadro')->where('nombre','LIKE','%'.$query.'%')
            ->where ('estado','=','1')
            ->orderBy('idcuadro','desc')
            ->paginate(7);
            return view('admin.cuadro.index',["cuadros"=>$cuadros,"searchText"=>$query]);
        }
    }
    public function create()
    {
        return view("admin.cuadro.create");
    }
    public function store (Request $request) //crear
    {
      $publicar=$request->get('publicar');

      $cuadro=new Cuadro;
      $cuadro->nombre=$request->get('nombre');
      $cuadro->artista=$request->get('artista');
			$cuadro->tecnica=$request->get('tecnica');
			$cuadro->medidas=$request->get('medidas');
			$cuadro->firmado_en=$request->get('firmado_en');
			$cuadro->contacte_precio=$request->get('contacte_precio');
			$cuadro->precio=$request->get('precio');
      $cuadro->estado='1';
      $cuadro->destacado=$request->get('destacado');
      if($publicar=="on")
      {
        $cuadro->publicar="on";
        $cuadro->fecha= date('d-m-Y',time());
      }
      else{
        $cuadro->publicar="off";
      }
      //Subir imagen
      if (Input::hasFile('imagenp')){
        $file=Input::file('imagenp'); // almaceno imagen
        $file->move(public_path().'/imagenes/cuadros/',$file->getClientOriginalName()); //establesco nombre
        $cuadro->imagenp=$file->getClientOriginalName();
      }
      if (Input::hasFile('imagen1')){
        $file=Input::file('imagen1'); // almaceno imagen
        $file->move(public_path().'/imagenes/cuadros/',$file->getClientOriginalName()); //establesco nombre
        $cuadro->imagen1=$file->getClientOriginalName();
      }
      if (Input::hasFile('imagen2')){
        $file=Input::file('imagen2'); // almaceno imagen
        $file->move(public_path().'/imagenes/cuadros/',$file->getClientOriginalName()); //establesco nombre
        $cuadro->imagen2=$file->getClientOriginalName();
      }
      if (Input::hasFile('imagen3')){
        $file=Input::file('imagen3'); // almaceno imagen
        $file->move(public_path().'/imagenes/cuadros/',$file->getClientOriginalName()); //establesco nombre
        $cuadro->imagen3=$file->getClientOriginalName();
      }

      $cuadro->save();
      return Redirect::to('admin/cuadro');

    }
    public function show($id)
    {
        return view("admin.cuadro.show",["cuadro"=>Cuadro::findOrFail($id)]);
    }
    public function edit($id)
    {
        return view("admin.cuadro.edit",["cuadro"=>Cuadro::findOrFail($id)]);
    }
    public function update(Request $request,$id)
    {
      $publicar=$request->get('publicar');
      $cuadro=Cuadro::findOrFail($id);
      $cuadro->nombre=$request->get('nombre');
			$cuadro->artista=$request->get('artista');
			$cuadro->tecnica=$request->get('tecnica');
			$cuadro->medidas=$request->get('medidas');
			$cuadro->firmado_en=$request->get('firmado_en');
			$cuadro->contacte_precio=$request->get('contacte_precio');
			$cuadro->precio=$request->get('precio');
      $cuadro->descripcion=$request->get('descripcion');
      $cuadro->destacado=$request->get('destacado');
      $cuadro->fecha= date('d-m-Y',time());
      if($publicar=="on")
      {
        $cuadro->publicar="on";
        $cuadro->fecha= date('d-m-Y',time());
      }
      else{
        $cuadro->publicar="off";
      }
      //Subir imagen
      if (Input::hasFile('imagenp')){
        $file=Input::file('imagenp'); // almaceno imagen
        $file->move(public_path().'/imagenes/cuadros/',$file->getClientOriginalName()); //establesco nombre
        $cuadro->imagenp=$file->getClientOriginalName();
      }
      if (Input::hasFile('imagen1')){
        $file=Input::file('imagen1'); // almaceno imagen
        $file->move(public_path().'/imagenes/cuadros/',$file->getClientOriginalName()); //establesco nombre
        $cuadro->imagen1=$file->getClientOriginalName();
      }
      if (Input::hasFile('imagen2')){
        $file=Input::file('imagen2'); // almaceno imagen
        $file->move(public_path().'/imagenes/cuadros/',$file->getClientOriginalName()); //establesco nombre
        $cuadro->imagen2=$file->getClientOriginalName();
      }
      if (Input::hasFile('imagen3')){
        $file=Input::file('imagen3'); // almaceno imagen
        $file->move(public_path().'/imagenes/cuadros/',$file->getClientOriginalName()); //establesco nombre
        $cuadro->imagen3=$file->getClientOriginalName();
      }
      $cuadro->update();
      return Redirect::to('admin/cuadro');
    }
    public function destroy($id)
    {
        $cuadro=Cuadro::findOrFail($id);
        $cuadro->estado='0';
        $cuadro->update();
        return Redirect::to('admin/cuadro');
    }

}
