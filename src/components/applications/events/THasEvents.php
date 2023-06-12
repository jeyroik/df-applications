<?php
namespace deflou\components\applications\events;

use deflou\interfaces\applications\events\IHaveEvents;
use deflou\interfaces\applications\events\IEvents;

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
