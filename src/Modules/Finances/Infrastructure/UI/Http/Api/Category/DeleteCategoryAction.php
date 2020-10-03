<?php
declare(strict_types=1);

namespace App\Modules\Finances\Infrastructure\UI\Http\Api\Category;

use App\Modules\Finances\Application\Category\Delete\DeleteCategoryCommand;
use App\Modules\Finances\Domain\Category\CategoryId;
use App\Modules\Finances\Domain\User\UserId;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\MessageBusInterface;

final class DeleteCategoryAction
{
    private MessageBusInterface $bus;

    public function __construct(MessageBusInterface $bus)
    {
        $this->bus = $bus;
    }

    public function __invoke(Request $request): JsonResponse
    {
        $this->bus->dispatch(
            new DeleteCategoryCommand(
                CategoryId::fromInt((int) $request->get('id')),
                UserId::fromInt($request->get('user_id'))
            )
        );

        return new JsonResponse([], Response::HTTP_NO_CONTENT);
    }
}
