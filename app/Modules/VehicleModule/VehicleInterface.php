<?php

namespace App\Modules\VehicleModule;

interface VehicleInterface
{
  public function getVehicles(): array;
  public function getVehicle(int $id): ?Vehicle;
  public function saveVehicle(array $data): Vehicle;
  public function updateVehicle(array $data, int $id): bool;
  public function deleteVehicle(int $id): bool;
}
