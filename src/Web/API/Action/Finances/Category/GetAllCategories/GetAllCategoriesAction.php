<?php
declare(strict_types=1);

namespace App\Web\API\Action\Finances\Category\GetAllCategories;

use App\Modules\Finances\Application\Category\GetAll\CategoriesCollection;
use App\Modules\Finances\Application\Category\GetAll\GetAllCategoriesQuery;
use App\Web\API\Action\AbstractAction;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Messenger\Stamp\HandledStamp;

final class GetAllCategoriesAction extends AbstractAction
{
    private MessageBusInterface $bus;

    public function __construct(MessageBusInterface $bus)
    {
        $this->bus = $bus;
    }

    public function __invoke(Request $request): JsonResponse
    {
        /** @var CategoriesCollection $data */
        $collection = $this->bus->dispatch(new GetAllCategoriesQuery())->last(HandledStamp::class)->getResult();
        $response = GetAllCategoriesResponse::createFromCollection($collection);

        return $this->json(
            $response->getResponse()
        );
    }
}
