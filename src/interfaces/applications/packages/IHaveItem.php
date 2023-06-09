<?php
namespace deflou\interfaces\applications\packages;

interface IHaveItem
{
    public function getItem(string $name): array;
}
