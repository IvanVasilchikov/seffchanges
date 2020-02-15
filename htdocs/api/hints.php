<?
require_once $_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_before.php";
$client = \Elasticsearch\ClientBuilder::create()->setHosts(['elastic'])->build();
$query = htmlspecialchars($_REQUEST['value']);
$resDb = $client->search([
    'index' => ELASTIC_INDEX,
    'type' => '_doc',
    'body' => [
        "size" => 1000,
        "suggest" => [
            "object" => [
                "prefix" => $query,
                "completion" => [
                    "field" => "suggest_name",
                    // "skip_duplicates" => true,
                    "size" => 100,
                    "contexts" => [
                        "departament" => htmlspecialchars($_REQUEST['departament']),
                    ],
                ],
            ],
            "name" => [
                "prefix" => $query,
                "completion" => [
                    "field" => "suggest_name_el",
                    // "skip_duplicates" => true,
                    "size" => 100,
                    "contexts" => [
                        "departament" => htmlspecialchars($_REQUEST['departament']),
                    ],
                ],
            ],
            "address" => [
                "prefix" => $query,
                "completion" => [
                    "field" => "suggest_address",
                    "size" => 100,
                    // "skip_duplicates" => true,
                    "contexts" => [
                        "departament" => htmlspecialchars($_REQUEST['departament']),
                    ],
                ],
            ],
            "highway" => [
                "prefix" => $query,
                "completion" => [
                    "field" => "suggest_highway",
                    "size" => 100,
                    // "skip_duplicates" => true,
                    "contexts" => [
                        "departament" => htmlspecialchars($_REQUEST['departament']),
                    ],
                ],
            ],
            "city" => [
                "prefix" => $query,
                "completion" => [
                    "field" => "suggest_city",
                    "size" => 100,
                    // "skip_duplicates" => true,
                    "contexts" => [
                        "departament" => htmlspecialchars($_REQUEST['departament']),
                    ],
                ],
            ],   
            "country" => [
                "prefix" => $query,
                "completion" => [
                    "field" => "suggest_country",
                    "size" => 100,
                    // "skip_duplicates" => true,
                    "contexts" => [
                        "departament" => htmlspecialchars($_REQUEST['departament']),
                    ],
                ],
            ],  
            "tags" => [
                "prefix" => $query,
                "completion" => [
                    "field" => "suggest_tags",
                    "size" => 100,
                    // "skip_duplicates" => true,
                    "contexts" => [
                        "departament" => htmlspecialchars($_REQUEST['departament']),
                    ],
                ],
            ],             
        ],
    ],
]);
$result = [];
foreach ($resDb['suggest'] as $key => $res) {
    $title = '';
    $field = '';
    switch ($key) {
        case 'object':
            $title = 'Объекты';
            $field = 'lot_name';
            break;
        case 'name':
            $title = 'Название';
            $field = 'lot_name';
            break;
        case 'address':
            $title = 'Адрес';
            $field = 'address';
            break;
        case 'highway':
            $title = 'Шоссе';
            $field = 'highway';
            break;
        case 'city':
            $title = 'Город';
            $field = 'city';
            break; 
        case 'country':
            $title = 'Страна';
            $field = 'country';
            break; 
        case 'tags':
            $title = 'Теги';
            $field = 'tags';
            break;      
    }
    $options = $res[0]['options'];
    $items = array_map(function ($item) use ($field) {
        return (is_array($item['_source'][$field]))?$item['_source'][$field][0]:$item['_source'][$field];        
    }, $options);
    if (count($items) > 0) {
        $result[] = ['head' => ['text' => $title], 'items' => array_values(array_unique($items))];
    }
}
echo json_encode($result);
