<?php
namespace deflou\components\applications\packages;

enum EStates: string
{
    public const LANG__RUSSIAN = 'ru';

    case Pending = 'pending';
    case Accepted = 'accepted';
    case Published = 'published';
    case Declined = 'declined';
    case Canceled = 'canceled';

    public function is(string $state): bool
    {
        return $this->value === $state;
    }

    public function to(string $lang): string
    {
        $state = $this->value;

        //todo get from cfg
        $langs = [
            'ru' => [
                'pending' => 'На модерации',
                'accepted' => 'Принято',
                'published' => 'Опубликовано',
                'declined' => 'Отклонено',
                'canceled' => 'Готово к модерации'
            ]
        ];

        return isset($langs[$lang], $langs[$lang][$state]) ? $langs[$lang][$state] : $state;
    }
}
