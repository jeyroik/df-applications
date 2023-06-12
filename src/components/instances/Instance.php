<?php
namespace deflou\components\instances;

use deflou\components\applications\avatars\THasAvatar;
use deflou\components\applications\events\THasEvents;
use deflou\components\applications\operations\THasOperations;
use deflou\components\applications\options\THasOptions;
use deflou\components\applications\resolvers\THasResolver;
use deflou\components\applications\vendors\THasVendor;
use deflou\components\applications\THasApplication;
use deflou\interfaces\instances\IInstance;
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
    use THasResolver;

    protected function getSubjectForExtension(): string
    {
        return static::SUBJECT;
    }
}
