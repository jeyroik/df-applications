<?php
namespace deflou\components\applications\packages\events;

use deflou\components\applications\packages\Events;
use deflou\interfaces\applications\packages\events\IHaveEvents;
use deflou\interfaces\applications\packages\IEvents;

/**
 * @property array $config
 */
trait THasEvents
{
    public function getEvents(): array
    {
        return $this->config[IHaveEvents::FIELD__EVENTS] ?? '';
    }

    public function buildEvents(): IEvents
    {
        return new Events($this->getEvents());
    }
}
