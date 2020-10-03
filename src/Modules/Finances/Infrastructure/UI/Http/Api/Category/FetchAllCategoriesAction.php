<?php
declare(strict_types=1);

namespace App\Modules\Finances\Infrastructure\UI\Http\Api\Category;

use App\Modules\Finances\Application\Category\FetchAll\FetchAllCategoriesQuery;
use App\Modules\Finances\Domain\User\UserId;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Messenger\Stamp\HandledStamp;

final class FetchAllCategoriesAction
{
    private MessageBusInterface $bus;

    public function __construct(MessageBusInterface $bus)
    {
        $this->bus = $bus;
    }

    public function __invoke(Request $request): JsonResponse
    {
        $query = new FetchAllCategoriesQuery(
            UserId::fromInt($request->get('user_id'))
        );

        $result = $this->bus->dispatch($query)
            ->last(HandledStamp::class)
            ->getResult()
            ->toArray();

        return new JsonResponse($result);
    }
}
