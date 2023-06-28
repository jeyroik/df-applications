<?php
namespace deflou\components\applications\options;


use extas\components\Item;
use deflou\interfaces\applications\options\IOption;
use deflou\interfaces\applications\options\IOptions;
use extas\components\collections\TBuildAll;
use extas\components\collections\TCollection;

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
    use TCollection;
    use TBuildAll;

    public function buildOne(string $name, bool $errorIfMissed = false): IOption
    {
        $this->hasOne($name, $errorIfMissed);
        
        return new Option($this->getOne($name));
    }

    protected function getSubjectForExtension(): string
    {
        return static::SUBJECT;
    }
}
