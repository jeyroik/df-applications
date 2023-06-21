<?php
namespace deflou\interfaces\applications\items;

interface IHaveItem
{
    public function getItem(string $name): array;
    public function getItems(): array;
}
