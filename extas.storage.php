<?php

use extas\components\repositories\RepoItem;

return [
    "name" => "jeyroik/df-applications",
    "tables" => [
        "application_packages" => [
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
        "application_instances" => [
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
        "application_instances_info" => [
            "namespace" => "deflou\\repositories",
            "item_class" => "deflou\\components\\instances\\InstanceInfo",
            "pk" => "name",
            "aliases" => ["instancesInfo", "instances_info", "instancesInfo"],
            "hooks" => [],
            "code" => [
                'create-before' => '\\' . RepoItem::class . '::setId($item);'
                                  .'\\' . RepoItem::class . '::throwIfExist($this, $item, [\'iid\']);'
            ]
        ],
    ]
];
