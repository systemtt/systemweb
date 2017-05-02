<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use App\Slider;
use Illuminate\Support\Facades\Redirect;
use DB;

class SliderController extends Controller {

	public function __construct()
    {

    }
    public function index(Request $request)
    {
      $sliders=DB::table('slider')
      ->where ('estado','=','1')
      ->orderBy('idslider')
      ->paginate(7);
      return view('admin.slider.index',["sliders"=>$sliders]);
    }
    public function create()
    {
        return view("admin.slider.create");
    }
    /*
    public function store (Request $request) //crear
    {
      $slider=new slider;
      $slider->nombre=$request->get('nombre');
      $slider->descripcion=$request->get('descripcion');
      $slider->estado='1';
      $slider->destacado=$request->get('destacado');
      //Subir imagen
      if (Input::hasFile('imagen')){
        $file=Input::file('imagen'); // almaceno imagen
        $file->move(public_path().'/imagenes/sliders/',$file->getClientOriginalName()); //establesco nombre
        $slider->imagenp=$file->getClientOriginalName();
      }

      $slider->save();
      return Redirect::to('slider');

    }
    */
    public function show($id)
    {
        return view("admin.slider.show",["slider"=>Slider::findOrFail($id)]);
    }
    public function edit($id)
    {
        return view("admin.slider.edit",["slider"=>Slider::findOrFail($id)]);
    }
    public function update(Request $request,$id)
    {
      $slider=Slider::findOrFail($id);
      $slider->nombre=$request->get('nombre');
      $slider->descripcion=$request->get('descripcion');
      //Subir imagen
      if (Input::hasFile('imagen')){
        $file=Input::file('imagen'); // almaceno imagen
        $file->move(public_path().'/imagenes/sliders/',$file->getClientOriginalName()); //establesco nombre
        $slider->imagen=$file->getClientOriginalName();
      }
      $slider->update();
      return Redirect::to('admin/slider');
    }
    /*
    public function destroy($id)
    {
        $slider=Slider::findOrFail($id);
        $slider->estado='0';
        $slider->update();
        return Redirect::to('slider');
    }
    */

}
