<?php
declare(strict_types=1);

namespace App\Web\API\Action\Finances\Category;

use App\Modules\Finances\Application\Category\GetOneById\CategoryDTO;
use App\Modules\Finances\Application\Category\GetOneById\GetOneCategoryByIdQuery;
use App\Web\API\Action\AbstractAction;
use App\Web\API\Request\Finances\Category\GetOneCategoryByIdRequest;
use App\Web\API\Response\Finances\Category\CategoryResponse;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Messenger\Stamp\HandledStamp;

final class GetOneCategoryByIdAction extends AbstractAction
{
    private MessageBusInterface $bus;

    public function __construct(MessageBusInterface $bus)
    {
        $this->bus = $bus;
    }

    public function __invoke(Request $request): JsonResponse
    {
        $getCategoryByIdRequest = GetOneCategoryByIdRequest::createFromServerRequest($request);
        /** @var CategoryDTO $category */
        $category = $this->bus
            ->dispatch(new GetOneCategoryByIdQuery($getCategoryByIdRequest->getCategoryId()))
            ->last(HandledStamp::class)
            ->getResult();

        $response = new CategoryResponse(
            $category->getId(),
            $category->getUserId(),
            $category->getName(),
            $category->getType(),
            $category->getIcon(),
            $category->getCreatedAt()
        );

        return $this->json($response->getResponse());
    }
}
