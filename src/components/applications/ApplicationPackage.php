<?php
namespace deflou\components\applications;

use extas\components\Item;
use extas\components\THasDescription;
use extas\components\THasName;
use extas\components\THasState;
use extas\components\THasStringId;
use extas\components\THasType;

use deflou\components\applications\packages\avatars\THasAvatar;
use deflou\components\applications\packages\events\THasEvents;
use deflou\components\applications\packages\operations\THasOperations;
use deflou\components\applications\packages\options\THasOptions;
use deflou\components\applications\packages\vendors\THasVendor;
use deflou\interfaces\applications\IApplicationPackage;
use extas\components\THasVersion;

class ApplicationPackage extends Item implements IApplicationPackage
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

    public function getPackage(): string
    {
        return $this->config[static::FIELD__PACKAGE] ?? '';
    }

    protected function getSubjectForExtension(): string
    {
        return static::SUBJECT;
    }
}
