<?php

namespace App\Helpers;

trait RestActions
{
  private $statusCodes = [
    'done' => 200,
    'created' => 201,
    'removed' => 204,
    'not_valid' => 400,
    'not_found' => 404,
    'conflict' => 409,
    'unauthorized' => 401,
    'server_error' => 500,
    'unprocessable_entity' => 422,
  ];

  public function respond($status, $data = [], $error = null, $message = '')
  {
    return ['data' => $data, 'status' => $this->statusCodes[$status], 'message' => $message, 'error' => $error];
  }

  public function respondJson($status, $data = [], $error = null, $message = '')
  {
    return response()->json(
      ['data' => $data, 'error' => $error, 'message' => $message],
      $this->statusCodes[$status]
    );
  }
}
