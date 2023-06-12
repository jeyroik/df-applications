<?php
namespace deflou\components\applications;

use extas\components\Item;
use extas\components\THasDescription;
use extas\components\THasName;
use extas\components\THasState;
use extas\components\THasStringId;
use extas\components\THasType;
use extas\components\THasVersion;

use deflou\components\applications\avatars\THasAvatar;
use deflou\components\applications\events\THasEvents;
use deflou\components\applications\operations\THasOperations;
use deflou\components\applications\options\THasOptions;
use deflou\components\applications\resolvers\THasResolver;
use deflou\components\applications\vendors\THasVendor;
use deflou\interfaces\applications\IApplication;

class Application extends Item implements IApplication
{
    use THasName;
    use THasStringId;
    use THasDescription;
    use THasState;
    use THasType;
    use THasVersion;
    use THasAvatar;
    use THasVendor;
    use THasOptions;
    use THasEvents;
    use THasOperations;
    use THasResolver;

    public function getPackage(): string
    {
        return $this->config[static::FIELD__PACKAGE] ?? '';
    }

    protected function getSubjectForExtension(): string
    {
        return static::SUBJECT;
    }
}
