<?php
namespace deflou\components\applications;

use extas\components\Item;
use extas\components\THasDescription;
use extas\components\THasName;
use extas\components\THasState;
use extas\components\THasStringId;
use extas\components\THasType;

use deflou\components\applications\packages\Events;
use deflou\components\applications\packages\Operations;
use deflou\components\applications\packages\Options;
use deflou\components\applications\packages\Vendor;
use deflou\interfaces\applications\packages\IEvents;
use deflou\interfaces\applications\packages\IOperations;
use deflou\interfaces\applications\packages\IOptions;
use deflou\interfaces\applications\packages\IVendor;
use deflou\interfaces\applications\IApplicationPackage;

class ApplicationPackage extends Item implements IApplicationPackage
{
    use THasName;
    use THasStringId;
    use THasDescription;
    use THasState;
    use THasType;

    public function getPackage(): string
    {
        return $this->config[static::FIELD__PACKAGE] ?? '';
    }

    public function getAvatar(): string
    {
        return $this->config[static::FIELD__AVATAR] ?? '';
    }
    
    public function getOptions(): array
    {
        return $this->config[static::FIELD__OPTIONS] ?? '';
    }

    public function buildOptions(): IOptions
    {
        return new Options($this->getOptions());
    }

    public function getEvents(): array
    {
        return $this->config[static::FIELD__EVENTS] ?? '';
    }

    public function buildEvents(): IEvents
    {
        return new Events($this->getEvents());
    }

    public function getOperations(): array
    {
        return $this->config[static::FIELD__OPERATIONS] ?? '';
    }

    public function buildOperations(): IOperations
    {
        return new Operations($this->getOperations());
    }

    public function getVendor(): array
    {
        return $this->config[static::FIELD__VENDOR] ?? '';
    }

    public function buildVendor(): IVendor
    {
        return new Vendor($this->getVendor());
    }

    protected function getSubjectForExtension(): string
    {
        return static::SUBJECT;
    }
}
