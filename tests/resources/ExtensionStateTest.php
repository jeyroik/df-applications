<?php
namespace tests\resources;

use deflou\components\applications\EStates;
use extas\components\extensions\Extension;

class ExtensionStateTest extends Extension implements IExtensionStateTest
{
    public function test(EStates $state = null): bool
    {
        return $state->is(EStates::Pending->value);
    }
}
