<?php

namespace App\Http\Controllers\V1;

use App\Modules\Scheme\Services\RouteAnnotationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class RouteAnnotationController
{
    public function __construct(
        public RouteAnnotationService $service
    )
    {
    }

    public function item(Request $request)
    {
        $scheme = $this->service->handle(
            $request->operation_id,
            $request->url,
            $request->description,
            $request->tags,
            $request->response_class,
        );

        Storage::disk('public')->put('/output/'.$request->operation_id.'.txt', $scheme);
        return response()->json(['scheme' => $scheme]);
    }
}
