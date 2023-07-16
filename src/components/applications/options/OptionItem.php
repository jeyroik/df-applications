<?php
namespace deflou\components\applications\options;

use deflou\interfaces\applications\options\IHaveOptions;
use deflou\interfaces\applications\options\IOption;
use extas\components\Item;
use deflou\interfaces\applications\options\IOptionItem;
use extas\components\exceptions\MissedOrUnknown;
use extas\components\secrets\resolvers\ResolverPhpEncryption;
use extas\components\secrets\Secret;
use extas\interfaces\extensions\secrets\IExtensionSecretWithPassword;
use extas\interfaces\IHasName;
use extas\interfaces\repositories\IRepository;
use extas\interfaces\secrets\ISecret;

/**
 * @method IRepository secrets()
 */
class OptionItem extends Item implements IOptionItem
{
    public static function encryptOptions(IHaveOptions|IHasName &$item): void
    {
        /**
         * @var IOption[] $options
         */
        $options = $item->buildOptions()->buildAll();
        $optionsRaw = $item->getOptions();
        $self = new static();

        foreach ($options as $option) {
            if (!$option->isNeedToEncode()) {
                continue;
            }
            $option = $self->encryptOption($option, $item);
            $optionsRaw[$option->getName()] = $option->__toArray();
        }

        $item[IHaveOptions::FIELD__OPTIONS] = $optionsRaw;
    }

    public static function decryptOptions(IHaveOptions|IHasName &$item = null): void
    {
        if (!$item) {
            return;
        }

        /**
         * @var IOption[] $options
         */
        $options = $item->buildOptions()->buildAll();
        $optionsRaw = $item->getOptions();

        foreach ($options as $option) {
            if ($option->isNeedToEncode()) {
                $secretName = $item->getName() . '.' . $option->getName();
                
                /**
                 * @var IExtensionSecretWithPassword|ISecret $secret
                 */
                $secret = (new static())->secrets()->one([ISecret::FIELD__NAME => $secretName]);
                if (!$secret) {
                    throw new MissedOrUnknown('secret for option "' . $option->getName() . '"');
                }
                $secret->withPassword($secretName)->decrypt();
                $option->setValue($secret->getValue());

                $optionsRaw[$option->getName()] = $option->__toArray();
            }
        }

        $item[IHaveOptions::FIELD__OPTIONS] = $optionsRaw;
    }

    public static function hashOptions(IHaveOptions|IHasName &$item): void
    {
        /**
         * @var IOption[] $options
         */
        $options = $item->buildOptions()->buildAll();
        $optionsRaw = $item->getOptions();

        foreach ($options as $option) {
            if ($option->isNeedToHash()) {
                $option->setValue(sha1($option->getValue()));
                $optionsRaw[$option->getName()] = $option->__toArray();
            }
        }

        $item[IHaveOptions::FIELD__OPTIONS] = $optionsRaw;
    }

    protected function encryptOption(IOption $option, IHasName $item): IOption
    {
        $self = new static();
        $secretName = $item->getName() . '.' . $option->getName();
        $secret = $self->secrets()->one([ISecret::FIELD__NAME => $secretName]);
        $secretNew = $self->createEncryptedSecret($option->getValue(), $secretName);

        if (!$secret) {
            $secret = $self->secrets()->create($secretNew);
        } elseif ($secret->getValue() != $secretNew->getValue()) {
            $secret->setValue($secretNew->getValue());
            $self->secrets()->update($secret);
        }
        $option->setValue($secret->getValue());
        
        return $option;
    }

    protected function createEncryptedSecret(string $value, string $password): ISecret
    {
        /**
         * @var IExtensionSecretWithPassword|ISecret $secret
         */
        $secret = new Secret([
            Secret::FIELD__CLASS => ResolverPhpEncryption::class,
            Secret::FIELD__VALUE => $value,
            Secret::FIELD__NAME => $password
        ]);

        $secret->withPassword($password)->encrypt();

        return $secret;
    }

    protected function getSubjectForExtension(): string
    {
        return static::SUBJECT;
    }
}
