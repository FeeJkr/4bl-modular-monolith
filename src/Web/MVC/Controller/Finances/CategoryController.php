<?php
declare(strict_types=1);

namespace App\Web\MVC\Controller\Finances;

use App\Modules\Accounts\Application\User\GetToken\GetTokenQuery;
use App\Modules\Finances\Application\Category\Create\CreateCategoryCommand;
use App\Modules\Finances\Application\Category\GetAllGroupedByType\GetAllGroupedByTypeQuery;
use App\Modules\Finances\Application\Category\GetAllGroupedByType\GroupedByTypeCategoriesCollection;
use App\Web\MVC\Controller\AbstractController;
use App\Web\MVC\Presenter\Finances\Category\GroupedByTypeCategoriesCollectionPresenter;
use Assert\Assert;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Messenger\Stamp\HandledStamp;

final class CategoryController extends AbstractController
{
    public function __construct(private MessageBusInterface $bus){}

    public function showCategoriesPage(): Response
    {
        /** @var GroupedByTypeCategoriesCollection $categories */
        $categories = $this->bus
            ->dispatch(new GetAllGroupedByTypeQuery())
            ->last(HandledStamp::class)
            ->getResult();

        return $this->render('finances/category/index.html.twig', [
            'categoriesByType' => GroupedByTypeCategoriesCollectionPresenter::present($categories),
        ]);
    }

    public function showCreateCategoryPage(): Response
    {
        return $this->render('finances/category/create.html.twig');
    }

    public function createCategory(Request $request): Response
    {
        $name = $request->get('categoryName');
        $type = $request->get('categoryType');
        $icon = $request->get('categoryIcon');

        Assert::lazy()
            ->that($name, 'categoryName')->notEmpty()
            ->that($type, 'categoryType')->notEmpty()
            ->that($icon, 'categoryIcon')->notEmpty()
            ->verifyNow();

        $this->bus->dispatch(new CreateCategoryCommand($name, $type, $icon));

        return $this->redirectToRoute('finances.category.showAll');
    }
}
