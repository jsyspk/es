<?php
declare(strict_types=1);

/**
 * created by Ali Masood<ali@jsys.pk>
 * Date: 2019-08-29 16:35
 */

namespace J\ES;

class Index implements store
{
    private $name;

    public function __construct(string $name)
    {
        $this->name = $name;
    }

    public function countExists(string $feature, bool $nested = false): int
    {
        if($nested){
            $params = [
                'index' => $this->name,
                'body' => [
                    'query' => [
                        'nested' => [
                            'path' => $feature,
                            'query' => [
                                'bool' => [
                                    'must' => [
                                        'exists' => [
                                            'field' => $feature
                                        ]
                                    ]
                                ]
                            ]
                        ]
                    ]
                ]
            ];
        } else {
            $params = [
                'index' => $this->name,
                'body' => [
                    'query' => [
                        'exists' => [
                            'field' => $feature
                        ]
                    ]
                ]
            ];
        }

        $result = $this->es->count($params);
        return $result['count'];
    }
}
