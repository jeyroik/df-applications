<?php
namespace deflou\components\applications\packages\options;

enum ETypes: string
{
    case String = 'string';
    case List = 'list';
    case Text = 'text';
    
    public function is(string $type): bool
    {
        return $this->value === $type;
    }
}
