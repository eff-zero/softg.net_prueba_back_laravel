<?php

namespace App\Modules\VehicleModule\controllers;

use App\Helpers\RestActions;
use App\Http\Controllers\Controller;
use App\Modules\VehicleModule\validations\StoreVehicleRequest;
use App\Modules\VehicleModule\validations\UpdateVehicleRequest;
use App\Modules\VehicleModule\Vehicle;
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
            return $this->respondJson('server_error', [], $e->getMessage(), '');
        }
    }


    public function show(int $id)
    {
        try {
            //code...
        } catch (\Throwable $e) {
            return $this->respondJson('server_error', [], $e->getMessage(), '');
        }
    }


    public function update(UpdateVehicleRequest $request, int $id)
    {
        try {
            //code...
        } catch (\Throwable $e) {
            return $this->respondJson('server_error', [], $e->getMessage(), '');
        }
    }


    public function destroy(int $id)
    {
        try {
            //code...
        } catch (\Throwable $e) {
            return $this->respondJson('server_error', [], $e->getMessage(), '');
        }
    }
}
