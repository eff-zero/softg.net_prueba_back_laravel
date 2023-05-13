<?php

namespace App\Modules\RouteModule\controllers;

use App\Helpers\RestActions;
use App\Http\Controllers\Controller;
use App\Modules\RouteModule\Route;
use App\Modules\RouteModule\validations\StoreRouteRequest;
use App\Modules\RouteModule\validations\UpdateRouteRequest;

class RouteController extends Controller
{
    use RestActions;

    protected Route $RouteModel;

    public function __construct()
    {
        $this->RouteModel = new Route();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreRouteRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreRouteRequest $request)
    {
        try {
            $data = $request->all();
            $route = $this->RouteModel->saveRoute($data);
            return $this->respondJson('created', $route, null, 'Ruta creada');
        } catch (\Throwable $e) {
            return $this->respondJson('server_error', [], $e->getMessage(), 'Error a crear ruta');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Route  $route
     * @return \Illuminate\Http\Response
     */
    public function show(int $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateRouteRequest  $request
     * @param  \App\Models\Route  $route
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateRouteRequest $request, int $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Route  $route
     * @return \Illuminate\Http\Response
     */
    public function destroy(int $id)
    {
        //
    }
}
