<?php
declare(strict_types=1);

namespace App\Web\MVC;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class SPAController extends AbstractController
{
	public function index(): Response
	{
		return $this->render('index.html.twig');
	}
}
