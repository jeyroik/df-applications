<?php
namespace deflou\components\applications\events;

use deflou\interfaces\applications\events\IHaveEvents;
use extas\components\parameters\ParametredCollection;
use extas\interfaces\parameters\IParametredCollection;

/**
 * @property array $config
 */
trait THasEvents
{
    public function getEvents(): array
    {
        return $this->config[IHaveEvents::FIELD__EVENTS] ?? '';
    }

    public function buildEvents(): IParametredCollection
    {
        return new ParametredCollection($this->getEvents());
    }
}
