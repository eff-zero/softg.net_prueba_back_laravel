<?php

namespace App\Modules\RouteModule;

interface RouteInterface
{
  public function getRoutes(): array;
  public function getRoute(int $id): ?Route;
  public function saveRoute(array $data): Route;
  public function updateRoute(array $data, int $id): ?Route;
  public function deleteRoute(int $id): ?Route;
}
