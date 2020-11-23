<?php
declare(strict_types=1);

namespace App\Web\API\Action\Finances\Category\DeleteCategory;

use App\Modules\Finances\Application\Category\Delete\DeleteCategoryCommand;
use App\Web\API\Action\AbstractAction;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Messenger\MessageBusInterface;

final class DeleteCategoryAction extends AbstractAction
{
    private MessageBusInterface $bus;

    public function __construct(MessageBusInterface $bus)
    {
        $this->bus = $bus;
    }

    public function __invoke(Request $request): JsonResponse
    {
        $deleteCategoryRequest = DeleteCategoryRequest::createFromServerRequest($request);
        $this->bus->dispatch(
            new DeleteCategoryCommand(
                $deleteCategoryRequest->getCategoryId()
            )
        );

        return $this->noContentResponse();
    }
}
