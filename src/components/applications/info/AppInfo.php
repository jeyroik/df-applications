<?php
namespace deflou\components\applications\info;

use deflou\components\applications\THasApplication;
use deflou\components\applications\vendors\THasVendor;
use deflou\interfaces\applications\info\IAppInfo;
use extas\components\Item;
use extas\components\THasCreatedAt;
use extas\components\THasStringId;

class AppInfo extends Item implements IAppInfo
{
    use THasStringId;
    use THasVendor;
    use THasApplication;
    use THasInfo;
    use THasCreatedAt;

    public function getInstancesCount(): int
    {
        return $this->config[static::FIELD__INSTANCES_COUNT] ?? 0;
    }

    public function setInstancesCount(int $count): static
    {
        $this->config[static::FIELD__INSTANCES_COUNT] = $count;

        return $this;
    }

    public function incInstancesCount(int $inc): static
    {
        return $this->setInstancesCount($this->getInstancesCount() + $inc);
    }

    protected function getSubjectForExtension(): string
    {
        return static::SUBJECT;
    }
}
