<?php
declare(strict_types=1);

namespace App\Web\API\Action\Finances\Category\CreateCategory;

use App\Modules\Finances\Application\Category\Create\CreateCategoryCommand;
use App\Web\API\Action\AbstractAction;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Messenger\MessageBusInterface;

final class CreateCategoryAction extends AbstractAction
{
    private MessageBusInterface $bus;

    public function __construct(MessageBusInterface $bus)
    {
        $this->bus = $bus;
    }

    public function __invoke(Request $request): JsonResponse
    {
        $createCategoryRequest = CreateCategoryRequest::createFromServerRequest($request);
        $this->bus->dispatch(
            new CreateCategoryCommand(
                $createCategoryRequest->getCategoryName(),
                $createCategoryRequest->getCategoryType(),
                $createCategoryRequest->getCategoryIcon()
            )
        );

        return $this->noContentResponse();
    }
}
