<?php
declare(strict_types=1);

namespace App\Web\API\Action\Finances\Category;

use App\Modules\Finances\Application\Category\Update\UpdateCategoryCommand;
use App\Modules\Finances\Domain\Category\CategoryId;
use App\Modules\Finances\Domain\Category\CategoryType;
use App\Modules\Finances\Domain\User\UserId;
use App\Web\API\Action\AbstractAction;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
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
        $userId = $this->fetchUserId($this->bus, $request);

        $this->bus->dispatch(
            new UpdateCategoryCommand(
                CategoryId::fromInt((int) $request->get('id')),
                $userId,
                $request->get('category_name'),
                new CategoryType($request->get('category_type')),
                $request->get('category_icon')
            )
        );

        return new JsonResponse([], Response::HTTP_NO_CONTENT);
    }
}
