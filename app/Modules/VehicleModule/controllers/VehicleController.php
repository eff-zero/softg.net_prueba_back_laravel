<?php

namespace App\Modules\VehicleModule\controllers;

use App\Helpers\RestActions;
use App\Http\Controllers\Controller;
use App\Modules\VehicleModule\validations\StoreVehicleRequest;
use App\Modules\VehicleModule\validations\UpdateVehicleRequest;
use App\Modules\VehicleModule\Vehicle;
use Illuminate\Support\Facades\DB;
use PhpParser\Node\Stmt\TryCatch;

class VehicleController extends Controller
{
    use RestActions;

    protected Vehicle $VehicleModel;

    public function __construct()
    {
        $this->VehicleModel =  new Vehicle();
    }

    /**
     * @OA\Get(
     *     path="/vehicles",
     *     summary="Obtener vehículos",
     *     description="Obtiene la lista de todos los vehículos",
     *     operationId="getVehicles",
     *     tags={"Vehicles"},
     *     security={{"sanctum":{}}}, 
     *     @OA\Response(
     *         response="200",
     *         description="OK",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="status", type="string", example="done"),
     *             @OA\Property(property="message", type="string", example="Lista de vehiculos obtenido exitosamente"),
     *         )
     *     ),
     *     @OA\Response(
     *         response="500",
     *         description="Error interno del servidor",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="status", type="string", example="server_error"),
     *             @OA\Property(property="message", type="string", example="Error al obtener vehiculos"),
     *             @OA\Property(property="error", type="string")
     *         )
     *     )
     * )
     */
    public function index()
    {
        try {
            $vehicles =  $this->VehicleModel->getVehicles();
            return $this->respondJson('done', $vehicles, null, 'Lista de vehiculos obtenido exitosamente');
        } catch (\Throwable $e) {
            return $this->respondJson('server_error', [], $e->getMessage(), 'Error al obtener vehiculos');
        }
    }

    /**
     * Crear/guardar vehiculo.
     *
     * @OA\Post(
     *     path="/vehicles",
     *     operationId="store",
     *     tags={"Vehicles"},
     *     security={{"sanctum":{}}},
     *     @OA\RequestBody(
     *         required=true,
     *         description="Request body",
     *         @OA\JsonContent(
     *             @OA\Property(property="description", type="string", example="Sedan"),
     *             @OA\Property(property="year", type="integer", example=2020),
     *             @OA\Property(property="mark", type="string", example="Toyota"),
     *             @OA\Property(property="capacity", type="number", example=5.0),
     *         ),
     *     ),
     *     @OA\Response(
     *         response="201",
     *         description="Vehicle created",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="created"),
     *             @OA\Property(property="message", type="string", example="Vehículo creado"),
     *         ),
     *     ),
     *     @OA\Response(
     *         response="500",
     *         description="Server error",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="server_error"),
     *             @OA\Property(property="data", type="object"),
     *             @OA\Property(property="message", type="string", example="Error al crear vehículo"),
     *         ),
     *     ),
     * )
     */
    public function store(StoreVehicleRequest $request)
    {
        try {
            $data =  $request->all();
            $vehicle = $this->VehicleModel->saveVehicle($data);
            return $this->respondJson('created', $vehicle, null, 'Vehículo creado');
        } catch (\Throwable $e) {
            return $this->respondJson('server_error', [], $e->getMessage(), 'Error al crear vehículo');
        }
    }

    /**
     * Display the specified vehicle.
     *
     * @OA\Get(
     *     path="/vehicles/{id}",
     *     summary="Obtener información de un vehículo",
     *     description="Obtener información de un vehículo por su ID.",
     *     operationId="getVehicleById",
     *     tags={"Vehicles"},
     *     security={{ "sanctum": {} }},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID del vehículo",
     *         @OA\Schema(
     *             type="integer",
     *             format="int64"
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Vehículo encontrado",
     *         @OA\JsonContent(
     *             @OA\Property(property="id", type="integer", example="1"),
     *             @OA\Property(property="description", type="string", example="Toyota Corolla"),
     *             @OA\Property(property="year", type="integer", example="2021"),
     *             @OA\Property(property="mark", type="string", example="Toyota"),
     *             @OA\Property(property="capacity", type="number", example="1000"),
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Vehículo no encontrado"
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Error interno del servidor"
     *     )
     * )
     */
    public function show(int $id)
    {
        try {
            $vehicle = $this->VehicleModel->getVehicle($id);
            if (!$vehicle) {
                return $this->respondJson('not_found', [], null, 'Vehículo no encontrado');
            }
            return $this->respondJson('done', $vehicle, null, 'Vehículo encontrado');
        } catch (\Throwable $e) {
            return $this->respondJson('server_error', [], $e->getMessage(), 'Error al encontrar vehículo');
        }
    }

    /**
     * Update an existing vehicle.
     *
     * @OA\Put(
     *     path="/vehicles/{id}",
     *     summary="Actualizar un vehiculo",
     *     tags={"Vehicles"},
     *     security={{"sanctum":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID of the vehicle to update",
     *         @OA\Schema(
     *             type="integer",
     *             format="int64",
     *         ),
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="id", type="integer", example="1"),
     *             @OA\Property(property="description", type="string", example="Toyota Corolla"),
     *             @OA\Property(property="year", type="integer", example="2021"),
     *             @OA\Property(property="mark", type="string", example="Toyota"),
     *             @OA\Property(property="capacity", type="number", example="1000"),
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Success response",
     *         @OA\JsonContent(
     *             @OA\Property(
     *                 property="message",
     *                 type="string",
     *                 description="Success message",
     *             ),
     *             @OA\Property(
     *                 property="data",
     *             ),
     *         ),
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Not found",
     *         @OA\JsonContent(
     *             @OA\Property(
     *                 property="message",
     *                 type="string",
     *                 description="Error message",
     *                 example="Vehicle not found",
     *             ),
     *         ),
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Server error",
     *         @OA\JsonContent(
     *             @OA\Property(
     *                 property="message",
     *                 type="string",
     *                 description="Error message",
     *                 example="Error updating vehicle",
     *             ),
     *         ),
     *     ),
     * )
     */
    public function update(UpdateVehicleRequest $request, int $id)
    {
        try {
            $data = $request->all();
            $result = $this->VehicleModel->updateVehicle($data, $id);

            if (!$result) {
                return $this->respondJson('not_found', [], null, 'Vehículo no encontrado');
            }

            return $this->respondJson('done', $result, null, 'Vehículo actualizado');
        } catch (\Throwable $e) {
            return $this->respondJson('server_error', [], $e->getMessage(), 'Error al actualizar vehículo');
        }
    }

    /**
     * Elimina un vehículo
     *
     * @OA\Delete(
     *     path="/vehicles/{id}",
     *     summary="Eliminar vehículo",
     *     description="Elimina un vehículo dado su ID",
     *     operationId="destroy",
     *     tags={"Vehicles"},
     *     security={{"sanctum":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID del vehículo a eliminar",
     *         required=true,
     *         @OA\Schema(
     *             type="integer"
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Vehículo eliminado con éxito",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="status",
     *                 type="string",
     *                 example="done"
     *             ),
     *             @OA\Property(
     *                 property="data",
     *                 type="object",
     *                 example={}
     *             ),
     *             @OA\Property(
     *                 property="message",
     *                 type="string",
     *                 example="Vehículo eliminado con éxito"
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Vehículo no encontrado",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="status",
     *                 type="string",
     *                 example="not_found"
     *             ),
     *             @OA\Property(
     *                 property="data",
     *                 type="object",
     *                 example={}
     *             ),
     *             @OA\Property(
     *                 property="message",
     *                 type="string",
     *                 example="Vehículo no encontrado"
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Error al eliminar vehículo",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="status",
     *                 type="string",
     *                 example="server_error"
     *             ),
     *             @OA\Property(
     *                 property="data",
     *                 type="object",
     *                 example={}
     *             ),
     *             @OA\Property(
     *                 property="message",
     *                 type="string",
     *                 example="Error al eliminar vehículo"
     *             )
     *         )
     *     )
     * )
     */
    public function destroy(int $id)
    {
        try {
            $result =  $this->VehicleModel->deleteVehicle($id);
            if (!$result) {
                return $this->respondJson('not_found', [], null, 'Vehículo no encontrado');
            }
            return $this->respondJson('done', $result, null, 'Vehículo eliminado con exito');
        } catch (\Throwable $e) {
            return $this->respondJson('server_error', [], $e->getMessage(), 'Error al eliminar vehículo');
        }
    }
}
