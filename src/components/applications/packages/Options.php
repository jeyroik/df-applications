<?php
namespace deflou\components\applications\packages;

use extas\components\Item;
use deflou\interfaces\applications\packages\IOption;
use deflou\interfaces\applications\packages\IOptions;

/**
 * "options": {
 *  "login": {
 *      ... // see Option for details
 *  },
 *  ...
 * }
 */
class Options extends Item implements IOptions
{
    use THasItem;
    use TBuildItems;

    public function buildItem(string $name): IOption
    {
        return new Option($this->getItem($name));
    }

    protected function getSubjectForExtension(): string
    {
        return static::SUBJECT;
    }
}
