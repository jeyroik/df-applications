<?php
namespace deflou\interfaces\stages;

use deflou\interfaces\instances\IInstanceInfo;

interface IStageInstanceInfoUpdated
{
    public const NAME = 'deflou.instance.info.updated';

    public function __invoke(IInstanceInfo $info);
}
