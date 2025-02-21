<?php
declare(strict_types=1);

namespace App\Controller;

use Shared\Query\MyQuery;
use Shared\Query\MyQueryResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Messenger\Stamp\HandledStamp;
use Symfony\Component\Routing\Attribute\Route;

class QueryController extends AbstractController
{
    public function __construct(private MessageBusInterface $bus)
    {
    }

    #[Route('/query/{id}', name: 'query')]
    public function index(string $id): Response
    {
        /** @var MyQueryResponse|\stdClass $response */
        $response = $this->bus->dispatch(new MyQuery($id))->last(HandledStamp::class)->getResult();

        $responseValue = $response instanceof MyQueryResponse ? $response->toArray() : (array)$response;

        $ipServer = gethostbyname(gethostname());
        return $this->json(
            array_merge(
                $responseValue,
                ['ipServer' => $ipServer]
            )
        );
    }
}
