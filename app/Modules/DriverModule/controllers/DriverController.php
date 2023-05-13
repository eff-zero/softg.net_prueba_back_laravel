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
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
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
 *     security={{"bearerAuth":{}}},
 *     @OA\RequestBody(
 *         required=true,
 *         description="Datos del conductor",
 *         @OA\JsonContent(
 *             required={"first_name", "last_name", "email", "password", "ssn", "dob", "address", "city", "zip", "phone"},
 *             @OA\Property(property="first_name", type="string"),
 *             @OA\Property(property="last_name", type="string"),
 *             @OA\Property(property="email", type="string", format="email"),
 *             @OA\Property(property="password", type="string", format="password", minLength=8),
 *             @OA\Property(property="ssn", type="integer", format="int64"),
 *             @OA\Property(property="dob", type="string", format="date"),
 *             @OA\Property(property="address", type="string"),
 *             @OA\Property(property="city", type="string"),
 *             @OA\Property(property="zip", type="string"),
 *             @OA\Property(property="phone", type="integer", format="int64"),
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
     * Display the specified resource.
     *
     * @param  \App\Models\Driver  $driver
     * @return \Illuminate\Http\Response
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
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Driver  $driver
     * @return \Illuminate\Http\Response
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
