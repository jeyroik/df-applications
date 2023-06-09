<?php

use extas\components\repositories\RepoItem;

return [
    "name" => "jeyroik/df-applications",
    "tables" => [
        "application_packages" => [
            "namespace" => "deflou\\repositories",
            "item_class" => "deflou\\components\\applications\\ApplicationPackage",
            "pk" => "name",
            "aliases" => ["applicationPackages", "application_packages", "appPackages"],
            "hooks" => [],
            "code" => [
                'create-before' => '\\' . RepoItem::class . '::setId($item);'
                                  .'\\' . RepoItem::class . '::throwIfExist($this, $item, [\'name\']);'
            ]
        ],
        "application_instances" => [
            "namespace" => "deflou\\repositories",
            "item_class" => "deflou\\components\\applications\\instances\\Instance",
            "pk" => "name",
            "aliases" => ["applicationInstances", "application_instances", "appInstances"],
            "hooks" => [],
            "code" => [
                'create-before' => '\\' . RepoItem::class . '::setId($item);'
                                  .'\\' . RepoItem::class . '::throwIfExist($this, $item, [\'name\']);'
            ]
        ],
        "application_instances_info" => [
            "namespace" => "deflou\\repositories",
            "item_class" => "deflou\\components\\applications\\instances\\InstanceInfo",
            "pk" => "name",
            "aliases" => ["applicationInstancesInfo", "application_instances_info", "appInstancesInfo"],
            "hooks" => [],
            "code" => [
                'create-before' => '\\' . RepoItem::class . '::setId($item);'
                                  .'\\' . RepoItem::class . '::throwIfExist($this, $item, [\'iid\']);'
            ]
        ],
    ]
];
