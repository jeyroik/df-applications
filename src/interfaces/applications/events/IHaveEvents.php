<?php
namespace deflou\interfaces\applications\events;

interface IHaveEvents
{
    public const FIELD__EVENTS = 'events';

    public function getEvents(): array;
    public function buildEvents(): IEvents;
}
