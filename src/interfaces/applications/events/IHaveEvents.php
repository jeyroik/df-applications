<?php
namespace deflou\interfaces\applications\events;

use extas\interfaces\parameters\IParametredCollection;

interface IHaveEvents
{
    public const FIELD__EVENTS = 'events';

    public function getEvents(): array;
    public function buildEvents(): IParametredCollection;
}
