<?php
declare(strict_types=1);

namespace App\UI\Web\Controller;

use App\ReadModel\Wallet\Query\FetchAllQuery;
use App\ReadModel\Wallet\WalletReadModel;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

final class WalletController extends AbstractController
{
    private $walletReadModel;

    public function __construct(WalletReadModel $walletReadModel)
    {
        $this->walletReadModel = $walletReadModel;
    }

    public function fetchAll(Request $request): Response
    {
        return $this->json(
            $this->walletReadModel->fetchAll(
                new FetchAllQuery($request->get('user_id'))
            )->toArray()
        );
    }
}
