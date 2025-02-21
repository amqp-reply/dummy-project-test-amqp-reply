<?php
declare(strict_types=1);

namespace Shared\Query;

class MyQueryResponse
{
    public function __construct(
        private readonly string $original,
        private readonly string $upperCase,
        private readonly string $lowerCase,
        private readonly string $snakeCase,
        private readonly string $ipConsumer,
    )
    {
    }

    public function toArray(): array
    {
        return [
            'original' => $this->original,
            'upperCase' => $this->upperCase,
            'lowerCase' => $this->lowerCase,
            'snakeCase' => $this->snakeCase,
            'ipConsumer' => $this->ipConsumer,
        ];
    }
}
