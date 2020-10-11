<?php
declare(strict_types=1);

namespace App\Web\API\Action\Finances\Category;

use App\Modules\Finances\Application\Category\FetchOneById\FetchOneCategoryByIdQuery;
use App\Modules\Finances\Domain\Category\CategoryId;
use App\Modules\Finances\Domain\User\UserId;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Messenger\Stamp\HandledStamp;

final class FetchOneCategoryByIdAction
{
    private MessageBusInterface $bus;

    public function __construct(MessageBusInterface $bus)
    {
        $this->bus = $bus;
    }

    public function __invoke(Request $request): JsonResponse
    {
        $query = new FetchOneCategoryByIdQuery(
            UserId::fromInt($request->get('user_id')),
            CategoryId::fromInt((int) $request->get('id'))
        );

        $result = $this->bus->dispatch($query)
            ->last(HandledStamp::class)
            ->getResult();

        return new JsonResponse($result);
    }
}
