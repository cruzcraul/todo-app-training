<?php

namespace App\Http\Controllers;

use App\Todo;
use Illuminate\Http\Request;

/**
 * En esta clase deben implementar los metodos vacios de acuerdo a lo
 * previamente estudiado acerca de RESTFul. Recuerda que DEBEN validar los datos
 * de entrada y de regresar lo que les pide el método correctamente.
 *
 * Class TodoController
 * @package App\Http\Controllers
 */
class TodoController extends Controller
{
    /**
     * Este método del controlador regresa el listado del todos de la app
     * en un response del tipo json ordenados desde el más antiguo al más nuevo.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $todos = Todo::query()->orderBy('created_at', 'DESC')->get();
        return response()->json($todos);
    }

    /**
     * Este método del controlador debe crear un nuevo registro todo
     * y al final regresa el registro creado en un response del tipo
     * json.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $this->validate(request(), [
            'text' => 'required'
        ]);

        $todo = Todo::forceCreate([
            'text' => $request->get('text'),
            'done' => false
        ]);

        return response()->json($todo);
    }

    /**
     * Modifica el item todo con el $id correspondiente
     * y regresa el mismo item modificado.
     *
     * @param integer $id
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update($id, Request $request)
    {
        $rslt = false;
        $todo = Todo::find($id);
        if ($todo) {
            $todo->toggleDone();
            $rslt = true;
        }

        return response()->json(['rslt' => $rslt]);
    }

    /**
     * Elimina el registro y devuelve un response 200 en caso de exito o un 400
     * en caso de fallo pero igual en tipo json.
     *
     * @param integer $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function delete($id)
    {
        $rslt = false;
        $todo = Todo::find($id);
        if ($todo) {
            $todo->delete();
            $rslt = true;
        }
        return response()->json(['rslt' => $rslt]);
    }
}
