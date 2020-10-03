<?php
declare(strict_types=1);

namespace App\Modules\Finances\Infrastructure\UI\Http\Api\Category;

use App\Modules\Finances\Application\Category\FetchOneById\FetchOneCategoryByIdQuery;
use App\Modules\Finances\Domain\Category\CategoryId;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Messenger\Stamp\HandledStamp;

final class FetchOneCategoryByIdAction extends AbstractController
{
    private MessageBusInterface $bus;

    public function __construct(MessageBusInterface $bus)
    {
        $this->bus = $bus;
    }

    public function __invoke(Request $request): JsonResponse
    {
        $query = new FetchOneCategoryByIdQuery(
            $request->get('user_id'),
            CategoryId::fromInt((int) $request->get('id'))
        );

        $result = $this->bus->dispatch($query)
            ->last(HandledStamp::class)
            ->getResult();

        return $this->json($result);
    }
}
