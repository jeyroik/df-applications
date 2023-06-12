<?php
namespace deflou\components\applications\vendors;

use extas\components\Item;
use extas\components\THasDescription;
use extas\components\THasName;
use deflou\interfaces\applications\vendors\IVendor;

class Vendor extends Item implements IVendor
{
    use THasName;
    use THasDescription;

    public function getContacts(): array
    {
        return $this->config[static::FIELD__CONTACTS] ?? [];
    }

    protected function getSubjectForExtension(): string
    {
        return static::SUBJECT;
    }
}
