<?php
namespace deflou\components\plugins\applications;

use deflou\components\applications\AppReader;
use deflou\components\applications\AppWriter;
use deflou\interfaces\applications\IApplication;
use deflou\interfaces\instances\IInstance;
use deflou\interfaces\stages\IStageInstanceCreated;
use extas\components\plugins\Plugin;

class PluginUpdateAppInfoInstances extends Plugin implements IStageInstanceCreated
{
    public function __invoke(IApplication $app, IInstance $instance)
    {
        $reader = new AppReader();
        $info = $reader->getAppInfo($app->getId());
        $info->incInstancesCount(1);

        $writer = new AppWriter();
        $writer->updateAppInfo($info);
    }
}
