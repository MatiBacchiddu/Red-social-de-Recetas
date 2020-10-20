<?php

namespace App\Http\Controllers;

use App\CategoriaReceta;
use App\Receta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\Facades\Image;

class RecetaController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth', ['except' => ['show', 'search']]); // proteger autenticacion
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       // Auth::user()->recetas->dd();
      // $recetas = Auth::user()->recetas;

      $usuario =  Auth()->user()->id;

      // recetas con paginación

     $recetas = Receta::where('user_id', $usuario)->paginate(3);

       return view('recetas.index')->with('recetas', $recetas);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //DB::table('categoria_receta')->get()->pluck('nombre', "id")->dd();

        //obtener las categorias sin modelo
       // $categorias = DB::table('categoria_recetas')->get()->pluck('nombre', "id");

        //con modelo
        $categorias = CategoriaReceta::all(['id', 'nombre']);

        return view('recetas.create')->with('categorias', $categorias);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

       // dd( $request['imagen']->store('upload-recetas', 'public') );

       // validacion
        $data = $request->validate([
            'titulo' => 'required|min:6',
            'preparacion' => 'required',
            'ingredientes' => 'required',
            'categoria' => 'required', // todos estos nombre se leeen por el name
            'imagen' => 'required|image',
        ]);

        //obtener la ruta de la imagen
        $ruta_imagen = $request['imagen']->store('upload-recetas', 'public');

        // resize de la imagen
        $img = Image::make( public_path("storage/{$ruta_imagen}"))->fit(1000, 550);
        $img->save();

        //almacenar en la db sin modelo
      //  DB::table('recetas')->insert([
        //    'titulo' => $data['titulo'],
          //  'preparacion' => $data['preparacion'],
            //'ingredientes' => $data['ingredientes'],
            //'imagen' => $ruta_imagen,
           // 'user_id' => Auth::user()->id,
            //'categoria_id' => $data['categoria'],
        //]);

            // almacenar en la bd con modelo
            Auth()->user()->recetas()->create([
                'titulo' => $data['titulo'],
                'preparacion' => $data['preparacion'],
                'ingredientes' => $data['ingredientes'],
                'imagen' => $ruta_imagen,
                'categoria_id' => $data['categoria'],
            ]);



        // redireccionar
        return redirect()->action('RecetaController@index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Receta  $receta
     * @return \Illuminate\Http\Response
     */
    public function show(Receta $receta)
    {
        return view('recetas.show', compact('receta'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Receta  $receta
     * @return \Illuminate\Http\Response
     */
    public function edit(Receta $receta)
    {
        $this->authorize('view', $receta);

        $categorias = CategoriaReceta::all(['id', 'nombre']);
       return view('recetas.edit', compact('categorias', 'receta'));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Receta  $receta
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Receta $receta)
    {

        //Revisar policy
        $this->authorize('update', $receta);

        $data = $request->validate([
            'titulo' => 'required|min:6',
            'preparacion' => 'required',
            'ingredientes' => 'required',
            'categoria' => 'required', // todos estos nombre se leeen por el name
        ]);

        //asignar valores
        $receta->titulo = $data['titulo'];
        $receta->preparacion = $data['preparacion'];
        $receta->ingredientes = $data['ingredientes'];
        $receta->categoria_id = $data['categoria'];

            // si el usuario sube una nueva imagen
            if(request('imagen')) {

                $ruta_imagen = $request['imagen']->store('upload-recetas', 'public');

                // resize de la imagen
                $img = Image::make( public_path("storage/{$ruta_imagen}"))->fit(1000, 550);
                $img->save();

                // asignar al objeto
                $receta->imagen = $ruta_imagen;
            }



        $receta->save();

        //redireccionar
        return redirect()->action('RecetaController@index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Receta  $receta
     * @return \Illuminate\Http\Response
     */
    public function destroy(Receta $receta)
    {
        //ejecutar el policy
        $this->authorize('delete', $receta);

        // eliminar la receta
        $receta->delete();

        return redirect()->action('RecetaController@index');
    }


    public function search(Request $request)
    {
        //$busqueda = $request['buscar']; // escribimos buscar ya que es el name del input
        $busqueda = $request->get('buscar');

        $recetas = Receta::where('titulo', 'like', '%' . $busqueda . '%' )->paginate(10);
        $recetas->appends(['buscar' => $busqueda]);
        return view('busquedas.show', compact('recetas', 'busqueda'));
    }
}
