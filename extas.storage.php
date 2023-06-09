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
        ]
    ]
];
