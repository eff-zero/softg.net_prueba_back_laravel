<?php

namespace App\Modules\RouteModule;

use App\Modules\UserModule\User;
use App\Modules\VehicleModule\Vehicle;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Route extends Model implements RouteInterface
{
    use HasFactory, SoftDeletes;

    protected $guarded = [];
    protected $hidden = ['active', 'deleted_at', 'created_at', 'updated_at'];

    /** Relations */
    public function driver()
    {
        return $this->belongsTo(User::class, 'driver_id');
    }

    public function vehicle()
    {
        return $this->belongsTo(Vehicle::class, 'vehicle_id');
    }
    /** End Relations */

    public function saveRoute(array $data): Route
    {
        return $this::create($data)->load('driver', 'vehicle');
    }

    public function getRoutes(): array
    {
        return $this::all()->load('driver', 'vehicle')->toArray();
    }

    public function getRoute(int $id): ?Route
    {
        $route = $this::find($id);
        if (!$route) {
            return null;
        }
        return $route->load('driver', 'vehicle');
    }

    public function updateRoute(array $data, int $id): ?Route
    {
        $route = $this::find($id);
        if (!$route) {
            return null;
        }
        $route->update($data);
        return $route;
    }

    public function deleteRoute(int $id): ?Route
    {
        $route = $this::find($id);
        if (!$route) {
            return null;
        }
        return $route;
    }
}
