<?php
namespace deflou\components\plugins\applications;

use deflou\components\applications\AppReader;
use deflou\components\applications\AppWriter;
use deflou\interfaces\instances\IInstanceInfo;
use deflou\interfaces\stages\IStageInstanceInfoUpdated;
use extas\components\plugins\Plugin;

class PluginUpdateAppInfoDelta extends Plugin implements IStageInstanceInfoUpdated
{
    public function __invoke(IInstanceInfo $info)
    {
        $delta = $info->getDelta();

        if (!empty($delta)) {
            $appId = $info->getApplicationId();
            
            $reader = new AppReader();
            $appInfo = $reader->getAppInfo($appId);

            foreach ($delta as $fieldName => $deltaInc) {
                if ($appInfo->has($fieldName) && ($fieldName != $appInfo::FIELD__LAST_EXECUTED_AT)) {
                    $appInfo[$fieldName] = $appInfo[$fieldName] + $deltaInc;
                    continue;
                }
                if (($fieldName == $appInfo::FIELD__LAST_EXECUTED_AT) && ($appInfo->getLastExecutedAt() < $deltaInc)) {
                    $appInfo->setLastExecutedAt($deltaInc);
                }
            }

            $writer = new AppWriter();
            $writer->updateAppInfo($appInfo);
        }
    }
}
