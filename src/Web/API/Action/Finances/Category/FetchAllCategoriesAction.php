<?php
declare(strict_types=1);

namespace App\Web\API\Action\Finances\Category;

use App\Modules\Finances\Application\Category\FetchAll\FetchAllCategoriesQuery;
use App\Web\API\Action\AbstractAction;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Messenger\Stamp\HandledStamp;

final class FetchAllCategoriesAction extends AbstractAction
{
    private MessageBusInterface $bus;

    public function __construct(MessageBusInterface $bus)
    {
        $this->bus = $bus;
    }

    public function __invoke(Request $request): JsonResponse
    {
        $userId = $this->fetchUserId($this->bus, $request);

        $result = $this->bus
            ->dispatch(new FetchAllCategoriesQuery($userId))
            ->last(HandledStamp::class)
            ->getResult()
            ->toArray();

        return new JsonResponse($result);
    }
}
