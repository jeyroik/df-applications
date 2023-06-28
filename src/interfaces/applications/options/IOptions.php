<?php
namespace deflou\interfaces\applications\options;

use extas\components\exceptions\MissedOrUnknown;
use extas\interfaces\collections\ICollection;
use extas\interfaces\IItem;

interface IOptions extends IItem, ICollection
{
    public const SUBJECT = 'deflou.application.options';

    /**
     * Throw an error if item is missed and $errorOnMissed is true.
     * 
     * @throws MissedOrUnknown
     */
    public function buildOne(string $name, bool $errorIfMissed = false): IOption;

    /**
     * Throw an error if item is missed and $errorOnMissed is true.
     * 
     * @return IOption[]
     * @throws MissedOrUnknown
     */
    public function buildAll(array $names = [], bool $errorIfMissed = false): array;
}
