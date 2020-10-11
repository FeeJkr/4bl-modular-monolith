<?php
declare(strict_types=1);

namespace App\Web\API\Action\Finances\Category;

use App\Modules\Finances\Application\Category\Create\CreateCategoryCommand;
use App\Modules\Finances\Domain\Category\CategoryType;
use App\Modules\Finances\Domain\User\UserId;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\MessageBusInterface;

final class CreateCategoryAction
{
    private MessageBusInterface $bus;

    public function __construct(MessageBusInterface $bus)
    {
        $this->bus = $bus;
    }

    public function __invoke(Request $request): JsonResponse
    {
        $this->bus->dispatch(
            new CreateCategoryCommand(
                UserId::fromInt($request->get('user_id')),
                $request->get('category_name'),
                new CategoryType($request->get('category_type')),
                $request->get('category_icon')
            )
        );

        return new JsonResponse([], Response::HTTP_NO_CONTENT);
    }
}
