<?php

namespace App\Modules\RouteModule;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Route extends Model implements RouteInterface
{
    use HasFactory;

    protected $guarded = [];
    protected $hidden = [
        'active',
        'deleted_at',
        'created_at',
        'updated_at'
    ];

    public function saveRoute(array $data): Route
    {
        return $this;
    }

    public function getRoutes(): array
    {
        return [];
    }

    public function getRoute(int $id): ?Route
    {
        return $this;
    }

    public function updateRoute(array $data, int $id): ?Route
    {
        return $this;
    }

    public function deleteRoute(int $id): ?Route
    {
        return $this;
    }
}
