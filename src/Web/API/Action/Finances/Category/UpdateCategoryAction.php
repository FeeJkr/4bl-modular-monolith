<?php
declare(strict_types=1);

namespace App\Web\API\Action\Finances\Category;

use App\Modules\Finances\Application\Category\Update\UpdateCategoryCommand;
use App\Web\API\Action\AbstractAction;
use App\Web\API\Request\Finances\Category\UpdateCategoryRequest;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Messenger\MessageBusInterface;

final class UpdateCategoryAction extends AbstractAction
{
    private MessageBusInterface $bus;

    public function __construct(MessageBusInterface $bus)
    {
        $this->bus = $bus;
    }

    public function __invoke(Request $request): JsonResponse
    {
        $updateCategoryRequest = UpdateCategoryRequest::createFromServerRequest($request);
        $this->bus->dispatch(
            new UpdateCategoryCommand(
                $updateCategoryRequest->getCategoryId(),
                $updateCategoryRequest->getCategoryName(),
                $updateCategoryRequest->getCategoryType(),
                $updateCategoryRequest->getCategoryIcon()
            )
        );

        return $this->noContentResponse();
    }
}
