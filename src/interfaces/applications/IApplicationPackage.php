<?php
namespace deflou\interfaces\applications;

use extas\interfaces\IHasDescription;
use extas\interfaces\IHasName;
use extas\interfaces\IHasState;
use extas\interfaces\IHasType;
use extas\interfaces\IHaveUUID;
use extas\interfaces\IItem;
use deflou\interfaces\applications\packages\IEvents;
use deflou\interfaces\applications\packages\IOperations;
use deflou\interfaces\applications\packages\IOptions;
use deflou\interfaces\applications\packages\IVendor;

interface IApplicationPackage extends IItem, IHaveUUID, IHasName, IHasDescription, IHasType, IHasState
{
    public const SUBJECT = 'deflou.appication.package';

    public const FIELD__PACKAGE = 'package';
    public const FIELD__AVATAR = 'avatar';
    public const FIELD__OPTIONS = 'options';
    public const FIELD__EVENTS = 'events';
    public const FIELD__OPERATIONS = 'operations';
    public const FIELD__VENDOR = 'vendor';

    //todo переделать в enum
    public const STATE__AWAITING = 'awaiting';
    public const STATE__ACCEPTED = 'accepted';
    public const STATE__PUBLISHED = 'published';
    public const STATE__DECLINED = 'declined';

    public function getPackage(): string;
    public function getAvatar(): string;
    
    public function getOptions(): array;
    public function buildOptions(): IOptions;

    public function getEvents(): array;
    public function buildEvents(): IEvents;

    public function getOperations(): array;
    public function buildOperations(): IOperations;

    public function getVendor(): array;
    public function buildVendor(): IVendor;
}
