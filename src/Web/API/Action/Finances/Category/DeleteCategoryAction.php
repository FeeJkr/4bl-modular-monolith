<?php
declare(strict_types=1);

namespace App\Web\API\Action\Finances\Category;

use App\Modules\Finances\Application\Category\Delete\DeleteCategoryCommand;
use App\Web\API\Action\AbstractAction;
use App\Web\API\Request\Finances\Category\DeleteCategoryRequest;
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
