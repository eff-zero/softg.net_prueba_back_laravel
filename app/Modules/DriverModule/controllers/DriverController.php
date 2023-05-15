<?php

namespace App\Modules\DriverModule\controllers;

use App\Helpers\RestActions;
use App\Http\Controllers\Controller;
use App\Modules\DriverModule\Driver;
use App\Modules\DriverModule\validations\StoreDriverRequest;
use App\Modules\DriverModule\validations\UpdateDriverRequest;
use Illuminate\Support\Facades\Hash;

class DriverController extends Controller
{
    use RestActions;

    protected Driver $DriverModel;

    public function __construct()
    {
        $this->DriverModel = new Driver();
    }


    /**
     * @OA\Get(
     *     path="/drivers",
     *     summary="Obtener conductores",
     *     description="Obtiene la lista de todos los conductores",
     *     operationId="getDrivers",
     *     tags={"Drivers"},
     *     security={{"sanctum":{}}}, 
     *     @OA\Response(
     *         response="200",
     *         description="Lista de conductores obtenida exitosamente",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="done"),            
     *             @OA\Property(property="message", type="string", example="Lista de conductores obtenida exitosamente"),
     *         ),
     *     ),
     *     @OA\Response(
     *         response="500",
     *         description="Error al obtener conductores",
     *     ),
     * )
     */
    public function index()
    {
        try {
            $drivers = $this->DriverModel->getDrivers();
            return $this->respondJson('done', $drivers);
        } catch (\Throwable $e) {
            return $this->respondJson('server_error', [], $e->getMessage(), 'Error al obtener conductores');
        }
    }


    /**
     * @OA\Post(
     *     path="/drivers",
     *     summary="Crear conductor",
     *     description="Crear un nuevo conductor",
     *     operationId="createDriver",
     *     tags={"Drivers"},
     *     security={{"sanctum":{}}},
     *     @OA\RequestBody(
     *         required=true,
     *         description="Datos del conductor",
     *         @OA\JsonContent(
     *             required={"first_name", "last_name", "email", "password", "ssn", "dob", "address", "city", "zip", "phone"},
     *             @OA\Property(property="first_name", type="string", example="Jesus"),
     *             @OA\Property(property="last_name", type="string", example=""),
     *             @OA\Property(property="email", type="string", format="email", example=""),
     *             @OA\Property(property="password", type="string", format="password", minLength=8, example=""),
     *             @OA\Property(property="ssn", type="integer", format="int64", example=""),
     *             @OA\Property(property="dob", type="string", format="date", example=""),
     *             @OA\Property(property="address", type="string", example=""),
     *             @OA\Property(property="city", type="string", example=""),
     *             @OA\Property(property="zip", type="string", example=""),
     *             @OA\Property(property="phone", type="integer", format="int64", example=""),
     *         ),
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Conductor creado correctamente",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string"),
     *         ),
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="No autorizado",
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validación fallida",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string"),
     *             @OA\Property(property="errors", type="object"),
     *         ),
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Error interno del servidor",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string"),
     *             @OA\Property(property="error", type="string"),
     *         ),
     *     ),
     * )
     */
    public function store(StoreDriverRequest $request)
    {
        try {
            $data = $request->all();
            $data['password'] = Hash::make($data['password']);

            $driver = $this->DriverModel->saveDriver($data);
            return $this->respondJson('created', $driver, null, 'Conductor creado correctamente');
        } catch (\Throwable $e) {
            return $this->respondJson('server_error', [], $e->getMessage(), 'Error al guardar conductor');
        }
    }

    /**
     * @OA\Get(
     *     path="/drivers/{id}",
     *     summary="Obtener información de un conductor",
     *     description="Obtiene la información de un conductor específico mediante su ID",
     *     operationId="getDriverById",
     *     tags={"Drivers"},
     *     security={{"sanctum":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID del conductor a buscar",
     *         @OA\Schema(
     *             type="integer",
     *             format="int64"
     *         )
     *     ),
     *     @OA\Response(
     *         response="200",
     *         description="Información del conductor",
     *         
     *     ),
     *     @OA\Response(
     *         response="404",
     *         description="El conductor no fue encontrado",
     *     ),
     *     @OA\Response(
     *         response="500",
     *         description="Error interno del servidor",
     *     )
     * )
     */
    public function show(int $id)
    {
        try {
            $result = $this->DriverModel->getDriver($id);
            if (!$result) {
                return $this->respondJson('not_found', [], null, 'Conductor no encontrado');
            }

            return $this->respondJson('done', $result);
        } catch (\Throwable $e) {
            return $this->respondJson('server_error', [], $e->getMessage(), 'Error al encontrar conductor');
        }
    }

    /**
     * @OA\Put(
     *     path="/drivers/{id}",
     *     summary="Actualizar conductor",
     *     description="Actualiza los datos de un conductor existente",
     *     operationId="updateDriver",
     *     tags={"Drivers"},
     *     security={{"sanctum":{}}}, 
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID del conductor a actualizar",
     *         required=true,
     *         @OA\Schema(
     *             type="integer",
     *             format="int64"
     *         )
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         description="Los datos del conductor a actualizar",
     *         @OA\JsonContent(
     *             @OA\Property(property="first_name", type="string"),
     *             @OA\Property(property="last_name", type="string"),
     *             @OA\Property(property="email", type="string", format="email"),
     *             @OA\Property(property="password", type="string"),
     *             @OA\Property(property="ssn", type="string"),
     *             @OA\Property(property="dob", type="string", format="date"),
     *             @OA\Property(property="address", type="string"),
     *             @OA\Property(property="city", type="string"),
     *             @OA\Property(property="zip", type="string"),
     *             @OA\Property(property="phone", type="string")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="El conductor ha sido actualizado exitosamente",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="done"),
     *             @OA\Property(property="data", type="object", example="{first_name: 'John', last_name: 'Doe', email: 'john.doe@example.com', ssn: '123-45-6789', dob: '1980-01-01', address: '123 Main St', city: 'Anytown', zip: '12345', phone: '555-1234'}")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="No se encontró el conductor",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="not_found"),
     *             @OA\Property(property="message", type="string", example="Conductor no encontrado")
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Error al actualizar el conductor",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="server_error"),
     *             @OA\Property(property="message", type="string", example="Error al actualizar conductor"),
     *             @OA\Property(property="error", type="string", example="Error message")
     *         )
     *     )
     * )
     */
    public function update(UpdateDriverRequest $request, int $id)
    {
        try {
            $data = $request->all();
            $result = $this->DriverModel->updateDriver($data, $id);

            if (!$result) {
                return $this->respondJson('not_found', [], null, 'Conductor no encontrado');
            }

            return $this->respondJson('done', $result, null, 'Conductor actualizado');
        } catch (\Throwable $e) {
            return $this->respondJson('server_error', [], $e->getMessage(), 'Error al eliminar conductor');
        }
    }

    /**
     * @OA\Delete(
     *     path="/drivers/{id}",
     *     summary="Eliminar conductor",
     *     description="Elimina un conductor por su ID",
     *     operationId="deleteDriver",
     *     tags={"Drivers"},
     *     security={{"sanctum":{}}}, 
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID del conductor a eliminar",
     *         required=true,
     *         @OA\Schema(
     *             type="integer",
     *             format="int64"
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Conductor eliminado correctamente",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="done"),
     *             @OA\Property(property="data", type="boolean", example=true),
     *             @OA\Property(property="message", type="string", example="Conductor eliminado correctamente")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="No se encontró el conductor",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="not_found"),
     *             @OA\Property(property="data", type="boolean", example=false),
     *             @OA\Property(property="message", type="string", example="No se encontró el conductor")
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Error al eliminar conductor",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="server_error"),
     *             @OA\Property(property="data", type="boolean", example=false),
     *             @OA\Property(property="message", type="string", example="Error al eliminar conductor")
     *         )
     *     )
     * )
     */
    public function destroy(int $id)
    {
        try {
            $result = $this->DriverModel->deleteDriver($id);
            if (!$result) {
                return $this->respondJson('not_found', $result, null, 'No se encontro el condutor');
            }
            return $this->respondJson('done', $result, null, 'Conductor eliminado correctamente');
        } catch (\Throwable $e) {
            return $this->respondJson('server_error', [], $e->getMessage(), 'Error al eliminar conductor');
        }
    }
}
