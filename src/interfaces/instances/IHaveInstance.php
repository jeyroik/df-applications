<?php
namespace deflou\interfaces\instances;

interface IHaveInstance
{
    public const FIELD__INSTANCE_ID = 'iid';

    public function getInstanceId(): string;
    public function getInstance(): ?IInstance;
    public function setInstanceId(string $id): static;
}
