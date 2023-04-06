<?php

namespace App\Http\Controllers\V1;

use App\Modules\Scheme\Services\SchemeService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SchemeController
{
    public function __construct(
        public SchemeService $service
    )
    {
    }

    public function item(Request $request)
    {
        $scheme = $this->service->handle($request->title, $request->description, $request->json);
        Storage::disk('public')->put('/output/'.$request->title.'.txt', $scheme);
        return response()->json(['scheme' => $scheme]);
    }
}
