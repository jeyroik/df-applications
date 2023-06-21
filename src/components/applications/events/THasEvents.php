<?php
namespace deflou\components\applications\events;

use deflou\components\applications\params\ParametredCollection;
use deflou\interfaces\applications\events\IHaveEvents;
use deflou\interfaces\applications\params\IParametredCollection;

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
