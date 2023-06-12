<?php
namespace deflou\components\applications\options;

use deflou\components\applications\items\TBuildItems;
use deflou\components\applications\items\THasItem;
use extas\components\Item;
use deflou\interfaces\applications\options\IOption;
use deflou\interfaces\applications\options\IOptions;

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
