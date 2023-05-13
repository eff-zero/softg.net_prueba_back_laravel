<?php

namespace App\Modules\DriverModule;

use App\Helpers\RestActions;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Driver extends Model
{
    use HasFactory, RestActions, SoftDeletes;

    protected $table = 'users';
    protected $guarded = [];
    protected $hidden = [
        'active',
        'deleted_at',
        'remember_token',
        'created_at',
        'updated_at',
    ];

    public function saveDriver(array $data)
    {
        return $this::create($data);
    }

    public function getDriver(int $id)
    {
        return $this::whereNotNull('ssn')->find($id);
    }

    public function getDrivers()
    {
        return $this::whereNotNull('ssn')->get();
    }

    public function deleteDriver(int $id)
    {
        $driver = $this::whereNotNull('ssn')->find($id);
        if (!$driver) {
            return false;
        }
        $driver->delete();
        return $driver;
    }

    public function updateDriver(array $data, int $id)
    {
        $driver = $this::whereNotNull('ssn')->find($id);
        if (!$driver) {
            return false;
        }
        $driver->update($data);
        return $driver;
    }
}
