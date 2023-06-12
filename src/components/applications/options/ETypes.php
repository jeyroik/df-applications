<?php
namespace deflou\components\applications\options;

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
