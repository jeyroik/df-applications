<?php
namespace deflou\interfaces\stages;

use deflou\interfaces\applications\IApplication;
use deflou\interfaces\instances\IInstance;

interface IStageInstanceCreated
{
    public const NAME = 'deflou.instance.created';

    public function __invoke(IApplication $app, IInstance $instance);
}
