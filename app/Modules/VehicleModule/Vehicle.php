<?php

namespace App\Modules\VehicleModule;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Vehicle extends Model implements VehicleInterface
{
    use SoftDeletes, HasFactory;

    public function saveVehicle(array $data): Vehicle
    {
        return $this::create($data);
    }

    public function getVehicle(int $id): ?Vehicle
    {
        return $this::find($id);
    }

    public function getVehicles(): array
    {
        return $this::all()->toArray();
    }

    public function updateVehicle(array $data, int $id): bool
    {
        return $this::find($id)->update($data);
    }

    public function deleteVehicle(int $id): bool
    {
        return $this::find($id)->delete();
    }
}