<?php
namespace deflou\components\applications\packages;

use extas\components\Item;
use extas\components\THasDescription;
use extas\components\THasName;
use extas\components\THasType;
use deflou\interfaces\applications\packages\IOption;
use extas\components\THasValue;

class Option extends Item implements IOption
{
    use THasName;
    use THasDescription;
    use THasType;
    use THasValue;

    public function getDefault(): mixed
    {
        return $this->config[static::FIELD__DEFAULT] ?? null;
    }

    public function getRequired(): bool
    {
        return $this->config[static::FIELD__REQUIRED] ?? false;
    }

    public function getEncode(): bool
    {
        return $this->config[static::FIELD__ENCODE] ?? false;
    }

    public function getHashing(): bool
    {
        return $this->config[static::FIELD__HASHING] ?? false;
    }

    //syntax sugar
    
    public function isRequired(): bool
    {
        return $this->getRequired();
    }

    public function isNeedToEncode(): bool
    {
        return $this->getEncode();
    }

    public function isNeedToHash(): bool
    {
        return $this->getHashing();
    }

    protected function getSubjectForExtension(): string
    {
        return static::SUBJECT;
    }
}
