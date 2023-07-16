<?php

use deflou\components\applications\options\OptionItem;
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
                                  .'\\' . OptionItem::class . '::encryptOptions($item);'
                                  .'\\' . OptionItem::class . '::hashOptions($item);',
                'create-after' => '\\' . OptionItem::class . '::decryptOptions($result);',

                'update-before' => '\\' . OptionItem::class . '::encryptOptions($item);'
                                  .'\\' . OptionItem::class . '::hashOptions($item);',
                                  
                'one-after' => '\\' . OptionItem::class . '::decryptOptions($result);',
                'all-after' => 'foreach ($result as $index => $item) { \\'.OptionItem::class.'::decryptOptions($item); $result[$index] = $item; }'
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
                'one-after' => 'if ($result) { $result->resetDelta(); }',
                'all-after' => 'foreach ($result as $index => $item) { $item->resetDelta(); $result[$index] = $item; }'
            ]
        ],
    ],
    "envs" => [
        "DF__TEMPLATE_PATH" => [
            "description" => "Current DeFlou template path",
            "default" => "vendor/jeyroik/extas-foundation/resources"
        ],
        "DF__SAVE_PATH" => [
            "description" => "Current DeFlou save path",
            "default" => "runtime"
        ],
    ]
];
