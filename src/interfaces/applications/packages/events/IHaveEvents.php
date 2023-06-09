<?php
namespace deflou\interfaces\applications\packages\events;

use deflou\interfaces\applications\packages\IEvents;

interface IHaveEvents
{
    public const FIELD__EVENTS = 'events';

    public function getEvents(): array;
    public function buildEvents(): IEvents;
}
