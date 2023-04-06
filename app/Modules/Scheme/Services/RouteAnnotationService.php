<?php

namespace App\Modules\Scheme\Services;

use Illuminate\Support\Facades\Storage;

class RouteAnnotationService
{
    public const PATH = '/templates/responses/2/';
    public function handle(
        $operation_id,
        $url,
        $description,
        $tags,
        $response_class,
    )
    {
        $result = Storage::disk('public')->get(self::PATH.'route-annotaition.txt');

        $baseUrl = parse_url($url, PHP_URL_PATH);
        $query = parse_url($url, PHP_URL_QUERY);
        $query = explode('&', $query);

        foreach ($query as $queryItem){
            $data = explode('=',$queryItem);
            $items[$data[0]] = $data[1];
        }

        $result = str_ireplace('#OPERATION_ID#', $operation_id, $result);
        $result = str_ireplace('#DESCRIPTION#', $description, $result);
        $result = str_ireplace('#URL#', $baseUrl, $result);
        $result = str_ireplace('#TAGS#', $tags, $result);
        $result = str_ireplace('#RESPONSE_CLASS#', $response_class, $result);


        $paramTemplate = Storage::disk('public')->get(self::PATH.'param.txt');
        $params = '';

        foreach ($items as $key => $item) {

            $type = $this->getType($item);

            $param = str_ireplace('#PARAM_NAME#', $key, $paramTemplate);
            $param = str_ireplace('#PARAM_TYPE#', $type, $param);
            $param = str_ireplace('#PARAM_EXAMPLE#', $item, $param);
            $params .= $param;
        }

        return str_ireplace('#PARAMS#', $params, $result);
    }

    private function getType($value)
    {
        return match (gettype($value)) {
            'integer' => 'int',
            'string' => 'string',
            'array' => 'array',
            'object' => 'string',
            'null' => 'string',
            default => 'string',
        };
    }
}
