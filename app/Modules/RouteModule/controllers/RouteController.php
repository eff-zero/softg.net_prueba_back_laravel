<?php

namespace App\Modules\RouteModule\controllers;

use App\Helpers\RestActions;
use App\Http\Controllers\Controller;
use App\Modules\RouteModule\Route;
use App\Modules\RouteModule\validations\StoreRouteRequest;
use App\Modules\RouteModule\validations\UpdateRouteRequest;
use Illuminate\Database\Eloquent\SoftDeletes;

class RouteController extends Controller
{
    use RestActions, SoftDeletes;

    protected Route $RouteModel;

    public function __construct()
    {
        $this->RouteModel = new Route();
    }

    /**
     * @OA\Get(
     *     path="/routes",
     *     summary="Obtiene una lista de todas las rutas",
     *     tags={"Routes"},
     *     @OA\Response(
     *         response=200,
     *         description="Lista de rutas obtenidas exitosamente",*         
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Error al obtener la lista de rutas"
     *     ),
     *     security={{"sanctum": {}}}
     * )
     */
    public function index()
    {
        try {
            $routes = $this->RouteModel->getRoutes();
            return $this->respondJson('done', $routes, null, 'Lista de rutas obtenidas exitosamente');
        } catch (\Throwable $e) {
            return $this->respondJson('server_error', [], $e->getMessage(), 'Error a crear ruta');
        }
    }

    /**
     * @OA\Post(
     *      path="/routes",
     *      tags={"Routes"},
     *      summary="Crear una nueva ruta",
     *      security={{"sanctum":{}}},
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(
     *              @OA\Property(property="name", type="string", example="Ruta 1"),
     *              @OA\Property(property="description", type="string", example="Descripción de la Ruta 1"),
     *              @OA\Property(property="driver_id", type="integer", example=1),
     *              @OA\Property(property="vehicle_id", type="integer", example=1),
     *          ),
     *      ),
     *      @OA\Response(
     *          response="201",
     *          description="Ruta creada exitosamente",
     *          @OA\JsonContent(
     *              @OA\Property(property="status", type="string", example="created"),
     *              @OA\Property(property="message", type="string", example="Ruta creada"),
     *          ),
     *      ),
     *      @OA\Response(
     *          response="401",
     *          description="No autorizado",
     *      ),
     *      @OA\Response(
     *          response="422",
     *          description="Datos de entrada invalidos",
     *      ),
     *      @OA\Response(
     *          response="500",
     *          description="Error interno del servidor",
     *      ),
     * )
     */
    public function store(StoreRouteRequest $request)
    {
        try {
            $data = $request->all();
            $route = $this->RouteModel->saveRoute($data);
            return $this->respondJson('created', $route, null, 'Ruta creada');
        } catch (\Throwable $e) {
            return $this->respondJson('server_error', [], $e->getMessage(), 'Error a crear ruta');
        }
    }

    /**
     * Show the specified route.
     *
     * @OA\Get(
     *     path="/routes/{id}",
     *     summary="Get a specific route",
     *     description="Get the details of a specific route.",
     *     operationId="getRouteById",
     *     tags={"Routes"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID of the route to get.",
     *         required=true,
     *         @OA\Schema(
     *             type="integer",
     *             format="int64"
     *         )
     *     ),
     *     @OA\Response(
     *         response="200",
     *         description="Successful operation",
     *     ),
     *     @OA\Response(
     *         response="404",
     *         description="Route not found",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="message",
     *                 type="string",
     *                 example="Route not found"
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response="500",
     *         description="Internal server error",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="message",
     *                 type="string",
     *                 example="Error a crear ruta"
     *             )
     *         )
     *     ),
     *     security={
     *         {"sanctum": {}}
     *     }
     * )
     */
    public function show(int $id)
    {
        try {
            $route = $this->RouteModel->getRoute($id);
            if (!$route) {
                return $this->respondJson('not_found', [], null, 'Ruta no encontrada');
            }
            return $this->respondJson('done', $route, null, 'Ruta encontrada');
        } catch (\Throwable $e) {
            return $this->respondJson('server_error', [], $e->getMessage(), 'Error al encontrar ruta');
        }
    }


    /**
     * Update an existing route.
     *
     * @OA\Put(
     *     path="/routes/{id}",
     *     summary="Update an existing route",
     *     description="Update an existing route in the system with the specified ID using the data provided in the request.",
     *     operationId="updateRoute",
     *     tags={"Routes"},
     *     @OA\Parameter(
     *         name="id",
     *         description="ID of the route to update",
     *         required=true,
     *         in="path",
     *         @OA\Schema(
     *             type="integer",
     *             format="int64"
     *         )
     *     ),
     *     @OA\RequestBody(
     *         description="Data for the route update",
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="name", type="string"),
     *             @OA\Property(property="description", type="string"),
     *             @OA\Property(property="driver_id", type="integer"),
     *             @OA\Property(property="vehicle_id", type="integer"),
     *         ),
     *     ),
     *     @OA\Response(
     *         response="200",
     *         description="Route updated successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="done"),
     *             @OA\Property(property="message", type="string", example="Ruta actualizada")
     *         )
     *     ),
     *     @OA\Response(
     *         response="404",
     *         description="Route not found",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="not_found"),
     *             @OA\Property(property="message", type="string", example="Ruta no encontrada")
     *         )
     *     ),
     *     @OA\Response(
     *         response="500",
     *         description="Server error",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="server_error"),
     *             @OA\Property(property="message", type="string", example="Error al actualizar ruta")
     *         )
     *     ),
     *     security={
     *         {"sanctum": {}}
     *     }
     * )
     */
    public function update(UpdateRouteRequest $request, int $id)
    {
        try {
            $data = $request->all();
            $result = $this->RouteModel->updateRoute($data, $id);
            if (!$result) {
                return $this->respondJson('not_found', [], null, 'Ruta no encontrada');
            }
            return $this->respondJson('done', $result, null, 'Ruta actualizada');
        } catch (\Throwable $e) {
            return $this->respondJson('server_error', [], $e->getMessage(), 'Error al actualizar ruta');
        }
    }


    /**
     * @OA\Delete(
     *     path="/routes/{id}",
     *     summary="Eliminar una ruta",
     *     description="Eliminar una ruta",
     *     operationId="deleteRoute",
     *     tags={"Routes"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID de la ruta a eliminar",
     *         required=true,
     *         @OA\Schema(
     *             type="integer",
     *             format="int64"
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Ruta eliminada con éxito",
     *         @OA\JsonContent(
     *             @OA\Property(
     *                 property="data",
     *                 type="object",
     *                 description="Objeto que contiene información sobre la ruta eliminada"
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Ruta no encontrada",
     *         @OA\JsonContent(
     *             @OA\Property(
     *                 property="error",
     *                 type="string",
     *                 description="Mensaje de error indicando que la ruta no fue encontrada"
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Error al eliminar la ruta",
     *         @OA\JsonContent(
     *             @OA\Property(
     *                 property="error",
     *                 type="string",
     *                 description="Mensaje de error indicando que hubo un problema al eliminar la ruta"
     *             )
     *         )
     *     ),
     *     security={{"sanctum": {}}}
     * )
     */
    public function destroy(int $id)
    {
        try {
            $result = $this->RouteModel->deleteRoute($id);
            if (!$result) {
                return $this->respondJson('not_found', [], null, 'Ruta no encontrada');
            }
            return $this->respondJson('done', $result, null, 'Ruta eliminada con exito');
        } catch (\Throwable $e) {
            return $this->respondJson('server_error', [], $e->getMessage(), 'Error al eliminar ruta');
        }
    }
}
