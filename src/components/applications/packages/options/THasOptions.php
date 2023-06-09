<?php
namespace deflou\components\applications\packages\options;

use deflou\components\applications\packages\Options;
use deflou\interfaces\applications\packages\IOptions;
use deflou\interfaces\applications\packages\options\IHaveOptions;

/**
 * @property array $config
 */
trait THasOptions
{
    public function getOptions(): array
    {
        return $this->config[IHaveOptions::FIELD__OPTIONS] ?? '';
    }

    public function buildOptions(): IOptions
    {
        return new Options($this->getOptions());
    }
}
