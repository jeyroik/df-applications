<?php
namespace deflou\interfaces\applications\vendors;

use extas\interfaces\IHasDescription;
use extas\interfaces\IHasName;
use extas\interfaces\IItem;

interface IVendor extends IItem, IHasName, IHasDescription
{
    public const SUBJECT = 'deflou.application.vendor';

    public const FIELD__CONTACTS = 'contacts';

    public function getContacts(): array;
}
