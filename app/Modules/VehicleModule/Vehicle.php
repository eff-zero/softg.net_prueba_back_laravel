<?php

namespace App\Modules\VehicleModule;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Vehicle extends Model implements VehicleInterface
{
    use SoftDeletes, HasFactory;

    protected $guarded = [];
    protected $hidden =
    [
        'active',
        'deleted_at',
        'created_at',
        'updated_at'
    ];

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

    public function updateVehicle(array $data, int $id): ?Vehicle
    {
        return $this::find($id)->update($data);
    }

    public function deleteVehicle(int $id): ?Vehicle
    {
        $vehicle = $this::find($id);
        if (!$vehicle) {
            return null;
        }
        $vehicle->delete();
        return $vehicle;
    }
}
