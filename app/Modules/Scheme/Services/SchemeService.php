<?php

namespace App\Modules\Scheme\Services;

use Illuminate\Support\Facades\Storage;

class SchemeService
{
    public const PATH = '/templates/responses/1/';
    public function handle(string $title, string $description, array $json)
    {
        $result = Storage::disk('public')->get(self::PATH.'class.txt');
        $result = str_ireplace('#TITLE#', $title, $result);
        $result = str_ireplace('#DESCRIPTION#', $description, $result);

        $items = $json;
        $propSingleTemplate = Storage::disk('public')->get(self::PATH.'prop.txt');
        $propArrayTemplate = Storage::disk('public')->get(self::PATH.'prop-with-array.txt');
        $propInlineTemplate = Storage::disk('public')->get(self::PATH.'prop-inline.txt');

        $props = '';

        foreach ($items as $key => $item) {

            $type = $this->getType($item);
            $propTemplate = $propSingleTemplate;

            if(is_array($item)){

                $propTemplate = $propArrayTemplate;
                $subprops = '';

                foreach ($item as $keySub => $subitem) {
                    $subtype = $this->getType($subitem);
                    $subprop = str_ireplace('#PROP_TYPE#', $subtype, $propInlineTemplate);
                    $subprop = str_ireplace('#PROP_NAME#', $keySub, $subprop);
                    $subprop = str_ireplace('#PROP_EXAMPLE#', $subitem, $subprop);
                    $subprops .= $subprop;
                }

                $prop = str_ireplace('#PROP_TYPE#', $type, $propTemplate);
                $prop = str_ireplace('#PROP_NAME#', $key, $prop);
                $prop = str_ireplace('#ARRAY_ITEMS#', $subprops, $prop);

            }else{

                $prop = str_ireplace('#PROP_TYPE#', $type, $propTemplate);
                $prop = str_ireplace('#PROP_NAME#', $key, $prop);
                $prop = str_ireplace('#PROP_EXAMPLE#', $item, $prop);
            }


            $props .= $prop;
        }

        return str_ireplace('#ITEMS#', $props, $result);
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
