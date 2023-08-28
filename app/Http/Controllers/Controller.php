<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Laravel\Lumen\Routing\Controller as BaseController;

/**
 * @OA\Info(
 *     version="1.0.0",
 *     title="HIMS Api Documentation",
 *     description="HIMS Api Documentation",
 *     @OA\Contact(
 *         name="Satish Soni",
 *         email="satish.soni@globalspace.in"
 *     ),
 *     @OA\License(
 *         name="Apache 2.0",
 *         url="http://www.apache.org/licenses/LICENSE-2.0.html"
 *     )
 * ),
 * @OA\Server(
 *     url="/api",
 * ),

 */
class Controller extends BaseController
{
    public static function generateTimestamp()
    {
        return Carbon::now();
    }


    /**
     * Operation heartbeat
     *
     *  This API is meant for HIP should notify HIECM when new health record is generated and abha address is not avaliable
     *
     *
     * @return Http response
     */

    /**
     * @OA\GET(
     *      path="api/heartbeat",
     *      operationId="heartbeat",
     *      tags={"Server Status"},
     *      summary="Informs about server status",
     *     @OA\Response(
     *          response=200, description="Success",
     *          @OA\Schema(type="application/pdf"),
     *          @OA\JsonContent(
     *             @OA\Property(property="status", type="integer", example=""),
     *             @OA\Property(property="data",type="object")
     *          )
     *       )
     *  )
     */
    public function heartbeat()
    {
        return response()->json(['status' => "UP", 'timestamp' => $this->generateTimestamp()]);
    }
}
