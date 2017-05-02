<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use App\Obra;
use App\Cuadro;
use App\Slider;
use App\Remate;
use Illuminate\Support\Facades\Redirect;
use DB;

class TazartController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function __construct()
    {

    }

  public function buscador_ajax(Request $request)
  {
    $consultaBusqueda = $request->input("buscador_int");

    $cuadros=DB::table('cuadro')
      ->where ('estado','=','1')
      ->where ('nombre', 'LIKE', '%'.$consultaBusqueda.'%')
      ->get();

    $remate=DB::table('remate')
      ->where ('estado','=','1')
      ->where ('nombre', 'LIKE', '%'.$consultaBusqueda.'%')
      ->get();

    $sliders=DB::table('slider')
      ->where ('estado','=','1')
      ->orderBy('idslider')
      ->get();

    $destacado=DB::table('cuadro')
      ->where ('destacado','=','on')
      ->orderBy('idcuadro', 'DESC')
      ->limit(6)
      ->get();

    $subastas=DB::table('remate')
      ->where ('estado','=','1')
      ->get();


    return view('web.buscador', ['cuadros' => $cuadros, 'remates' => $remate, 'sliders' => $sliders, 'destacado' => $destacado, 'subastas' => $subastas]);
  }

  public function buscador_art(Request $request){
    $consultaBusqueda = $request->input("buscador_int");

    $artistaid=DB::table('cuadro')
      ->where ('artista','=',$consultaBusqueda)
      ->groupBy('artista')
      ->get();

    $artistaid=(array)$artistaid;
    $id=$artistaid[0]->idcuadro;
    $lo_tiene_el_remate="";

    $remates=DB::table('remate')
      ->get();

    $remates=(array)$remates;
    for ($i=0; $i < count($remates); $i++) { 
      $array="";
      $array=$remates[$i]->imagenes_cuadros;
      $array=json_decode($array);
      
      for ($d=0; $d < count($array) ; $d++) {
        if ($array[$d]==$id) {
          $lo_tiene_el_remate[]=$remates[$i]->idremate;
        }
      }
        
    }

    $remate_enviar=DB::table('remate')
      ->whereIn('idremate', $lo_tiene_el_remate)
      ->get();


    $sliders=DB::table('slider')
      ->where ('estado','=','1')
      ->orderBy('idslider')
      ->get();

    $destacado=DB::table('cuadro')
      ->where ('destacado','=','on')
      ->orderBy('idcuadro', 'DESC')
      ->limit(6)
      ->get();

    $subastas=DB::table('remate')
      ->where ('estado','=','1')
      ->get();
    return view('web.filtroremate', ['remates' => $remate_enviar, 'sliders' => $sliders, 'destacado' => $destacado, 'subastas' => $subastas]);
  }

	public function index(Request $request)
    {
      $cuadros=DB::table('cuadro')
			->where ('estado','=','1')
      ->get();

      $destacado=DB::table('cuadro')
      ->where ('destacado','=','on')
      ->orderBy('idcuadro', 'DESC')
      ->limit(6)
      ->get();

      $sliders=DB::table('slider')
      ->where ('estado','=','1')
      ->orderBy('idslider')
      ->get();

      $subastas=DB::table('remate')
      ->where ('estado','=','1')
      ->get();

      $subastass=DB::table('remate')
      ->where ('estado','=','1');

      return view('web.index',["cuadros"=>$cuadros,"subastas"=>$subastas, "subastass"=>$subastass, "destacado"=>$destacado, "sliders"=>$sliders]);
    }

    public function artistas(Request $request){
      $destacado=DB::table('cuadro')
      ->where ('destacado','=','on')
      ->orderBy('idcuadro', 'DESC')
      ->limit(6)
      ->get();

      return view('web.artistas',["destacado"=>$destacado]);
    }

		public function cuadro($id)
		{
			$idcuadro = $id;
			$cuadros=DB::table('cuadro')
			->where ('idcuadro','=',$idcuadro)
      ->get();

			$destacado=DB::table('cuadro')
      ->where ('destacado','=','on')
      ->orderBy('idcuadro', 'DESC')
      ->limit(6)
      ->get();


			return view('web.detallec',["cuadro"=>$cuadros]);
		}

		public function remate($id)
		{
			$idremate = $id;
			$remate=DB::table('remate')
			->where ('idremate','=',$idremate)
      ->get();

			$destacado=DB::table('cuadro')
      ->where ('destacado','=','on')
      ->orderBy('idcuadro', 'DESC')
      ->limit(6)
      ->get();


			return view('web.detaller',["remate"=>$remate, "destacado"=>$destacado]);
		}

    public function contacto(Request $request)
    {
			$destacado=DB::table('cuadro')
      ->where ('destacado','=','on')
      ->orderBy('idcuadro', 'DESC')
      ->limit(6)
      ->get();


      $sliders=DB::table('slider')
      ->where ('estado','=','1')
      ->orderBy('idslider')
      ->get();

			return view('web.contacto',["destacado"=>$destacado, "sliders"=>$sliders]);
    }


    public function nosotros(Request $request)
    {
			$destacado=DB::table('cuadro')
      ->where ('destacado','=','on')
      ->orderBy('idcuadro', 'DESC')
      ->limit(6)
      ->get();

      $sliders=DB::table('slider')
      ->where ('estado','=','1')
      ->orderBy('idslider')
      ->get();

      return view('web.nosotros',["destacado"=>$destacado, "sliders"=>$sliders]);
    }

    public function obras(Request $request)
    {
      $cuadros=DB::table('cuadro')
      ->where ('estado','=','1')
      ->where ('publicar', '=', 'on')
      ->orderBy('fecha', 'DESC')
      ->get();

			$destacado=DB::table('cuadro')
      ->where ('destacado','=','on')
      ->orderBy('idcuadro', 'DESC')
      ->limit(6)
      ->get();


      $sliders=DB::table('slider')
      ->where ('estado','=','1')
      ->orderBy('idslider')
      ->get();

      return view('web.obras',["cuadros"=>$cuadros, "descatado"=>$destacado, "sliders"=>$sliders]);
    }

    public function remates(Request $request)
    {
      $cuadros=DB::table('cuadro')
      ->where ('estado','=','1')
      ->get();

			$destacado=DB::table('cuadro')
      ->where ('destacado','=','on')
      ->orderBy('idcuadro', 'DESC')
      ->limit(6)
      ->get();

      $subastas=DB::table('remate')
      ->where ('estado','=','1')
      ->where ('publicar', '=', 'on')
      ->orderBy('fecha_mod', 'DESC')
      ->get();

      $sliders=DB::table('slider')
      ->where ('estado','=','1')
      ->orderBy('idslider')
      ->get();

      $list_artistas=DB::table('cuadro')
      ->where('artista', '<>', '')
      ->groupBy('artista')
      ->get();

      return view('web.remates',["list_artistas" => $list_artistas,"destacado"=>$destacado,"cuadros"=>$cuadros, "subastas"=>$subastas, "sliders"=>$sliders]);
    }


}
