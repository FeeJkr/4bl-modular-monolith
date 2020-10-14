<?php
declare(strict_types=1);

namespace App\Web\API\Action\Finances\Category;

use App\Modules\Finances\Application\Category\FetchOneById\FetchOneCategoryByIdQuery;
use App\Modules\Finances\Domain\Category\CategoryId;
use App\Modules\Finances\Domain\User\UserId;
use App\Web\API\Action\AbstractAction;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Messenger\Stamp\HandledStamp;

final class FetchOneCategoryByIdAction extends AbstractAction
{
    private MessageBusInterface $bus;

    public function __construct(MessageBusInterface $bus)
    {
        $this->bus = $bus;
    }

    public function __invoke(Request $request): JsonResponse
    {
        $userId = $this->fetchUserId($this->bus, $request);

        $query = new FetchOneCategoryByIdQuery(
            $userId,
            CategoryId::fromInt((int) $request->get('id'))
        );

        $result = $this->bus
            ->dispatch($query)
            ->last(HandledStamp::class)
            ->getResult();

        return new JsonResponse($result);
    }
}
