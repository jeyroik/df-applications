<?php
namespace deflou\components\applications\options;

use deflou\interfaces\applications\options\IOptions;
use deflou\interfaces\applications\options\IHaveOptions;

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
