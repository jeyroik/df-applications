<?php
namespace deflou\components\applications\instances;

use deflou\components\applications\packages\avatars\THasAvatar;
use deflou\components\applications\packages\events\THasEvents;
use deflou\components\applications\packages\operations\THasOperations;
use deflou\components\applications\packages\options\THasOptions;
use deflou\components\applications\packages\vendors\THasVendor;
use deflou\components\applications\THasApplication;
use deflou\interfaces\applications\instances\IInstance;
use extas\components\Item;
use extas\components\THasClass;
use extas\components\THasDescription;
use extas\components\THasName;
use extas\components\THasStringId;
use extas\components\THasType;
use extas\components\THasVersion;

class Instance extends Item implements IInstance
{
    use THasStringId;
    use THasAvatar;
    use THasOptions;
    use THasEvents;
    use THasOperations;
    use THasVendor;
    use THasName;
    use THasDescription;
    use THasClass;
    use THasType;
    use THasApplication;
    use THasVersion;

    protected function getSubjectForExtension(): string
    {
        return static::SUBJECT;
    }
}
