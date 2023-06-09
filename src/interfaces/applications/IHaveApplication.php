<?php
namespace deflou\interfaces\applications;

interface IHaveApplication
{
    public const FIELD__APPLICATION_ID = 'aid';

    public function getApplicationId(): string;
    public function getApplication(): ?IApplicationPackage;

    public function setApplicationId(string $id): static;
}
