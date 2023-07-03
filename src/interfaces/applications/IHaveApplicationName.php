<?php
namespace deflou\interfaces\applications;

interface IHaveApplicationName
{
    public const FIELD__APPLICATION_NAME = 'app_name';

    public function getApplicationName(): string;
    public function setApplicationName(string $name): static;
    public function getApplication(): ?IApplication;
}
