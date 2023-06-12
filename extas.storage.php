<?php

use extas\components\repositories\RepoItem;

return [
    "name" => "jeyroik/df-applications",
    "tables" => [
        "applications" => [
            "namespace" => "deflou\\repositories",
            "item_class" => "deflou\\components\\applications\\Application",
            "pk" => "name",
            "aliases" => ["applications", "apps"],
            "hooks" => [],
            "code" => [
                'create-before' => '\\' . RepoItem::class . '::setId($item);'
                                  .'\\' . RepoItem::class . '::throwIfExist($this, $item, [\'name\']);'
            ]
        ],
        "applications_info" => [
            "namespace" => "deflou\\repositories",
            "item_class" => "deflou\\components\\applications\\info\\AppInfo",
            "pk" => "id",
            "aliases" => ["applications_info", "appInfo"],
            "hooks" => [],
            "code" => [
                'create-before' => '\\' . RepoItem::class . '::setId($item);'
                                  .'\\' . RepoItem::class . '::throwIfExist($this, $item, [\'aid\']);'
            ]
        ],
        "instances" => [
            "namespace" => "deflou\\repositories",
            "item_class" => "deflou\\components\\instances\\Instance",
            "pk" => "name",
            "aliases" => ["instances", "instances"],
            "hooks" => [],
            "code" => [
                'create-before' => '\\' . RepoItem::class . '::setId($item);'
                                  .'\\' . RepoItem::class . '::throwIfExist($this, $item, [\'name\']);'
            ]
        ],
        "instances_info" => [
            "namespace" => "deflou\\repositories",
            "item_class" => "deflou\\components\\instances\\InstanceInfo",
            "pk" => "id",
            "aliases" => ["instancesInfo", "instances_info", "instancesInfo"],
            "hooks" => [],
            "code" => [
                'create-before' => '\\' . RepoItem::class . '::setId($item);'
                                  .'\\' . RepoItem::class . '::throwIfExist($this, $item, [\'iid\']);',
                'one-after' => '$result->resetDelta();',
                'all-after' => 'foreach ($result as $index => $item) { $item->resetDelta(); $result[$index] = $item; }'
            ]
        ],
    ]
];
