<?php
declare(strict_types=1);

namespace App\Web\MVC\Action\Finances\Category;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\MessageBusInterface;

final class ShowAllCategoriesAction extends AbstractController
{
    private MessageBusInterface $bus;

    public function __construct(MessageBusInterface $bus)
    {
        $this->bus = $bus;
    }

    public function __invoke(): Response
    {
        return $this->render('finances/category/index.html.twig');
    }
}
