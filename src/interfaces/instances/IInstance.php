<?php
namespace deflou\interfaces\instances;

use deflou\interfaces\applications\IHaveApplication;
use deflou\interfaces\applications\avatars\IHaveAvatar;
use deflou\interfaces\applications\events\IHaveEvents;
use deflou\interfaces\applications\operations\IHaveOperations;
use deflou\interfaces\applications\options\IHaveOptions;
use deflou\interfaces\applications\resolvers\IHaveResolver;
use deflou\interfaces\applications\vendors\IHaveVendor;
use extas\interfaces\IHasClass;
use extas\interfaces\IHasDescription;
use extas\interfaces\IHasName;
use extas\interfaces\IHasType;
use extas\interfaces\IHasVersion;
use extas\interfaces\IHaveUUID;
use extas\interfaces\IItem;

interface IInstance extends IItem, IHasName, IHasDescription, IHasClass, IHasType, IHaveUUID, IHasVersion,
    IHaveAvatar, IHaveVendor, IHaveOptions, IHaveEvents, IHaveOperations, IHaveApplication, IHaveResolver
{
    public const SUBJECT = 'df.instance';
}
