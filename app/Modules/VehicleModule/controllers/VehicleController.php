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

    public function index()
    {
        try {
            $vehicles =  $this->VehicleModel->getVehicles();
            return $this->respondJson('done', $vehicles);
        } catch (\Throwable $e) {
            return $this->respondJson('server_error', [], $e->getMessage(), '');
        }
    }

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

    public function show(int $id)
    {
        try {
            $vehicle = $this->VehicleModel->getVehicle($id);
            if (!$vehicle) {
                return $this->respondJson('not_found');
            }
            return $this->respondJson('done', $vehicle);
        } catch (\Throwable $e) {
            return $this->respondJson('server_error', [], $e->getMessage(), 'Vehículo encontrado');
        }
    }

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
