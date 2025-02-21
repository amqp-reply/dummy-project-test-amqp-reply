<?php
declare(strict_types=1);

namespace App\Query;

use Shared\Query\MyQuery;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

final class OtherResponse {
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

class KnownException extends \LogicException
{
    public function __construct(private mixed $otherAttribute, int $code = 406)
    {
        parent::__construct('Known exception', $code);
    }

    public function getOtherAttribute(): mixed
    {
        return $this->otherAttribute;
    }
}


#[AsMessageHandler]
class MyQueryHandler
{

    public function __invoke(MyQuery $message): OtherResponse
    {
        if($message->message() === 'error') {
            throw new KnownException(-10000);
        }

        if($message->message() === 'unknown-error') {
            throw new class extends \LogicException{};
        }

        $original = $message->message();
        $upperCase = strtoupper($message->message());
        $lowerCase = strtolower($message->message());
        $snakeCase = strtolower(preg_replace(['/([a-z])([A-Z])/', '/([A-Z])([A-Z][a-z])/', '/\s+/'], ['$1_$2', '$1_$2', '_'], $original));
        $consumerIp = gethostbyname(gethostname());
        return new OtherResponse($original, $upperCase, $lowerCase, $snakeCase, $consumerIp);
    }
}
