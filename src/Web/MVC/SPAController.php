<?php

declare(strict_types=1);

namespace App\Web\MVC;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class SPAController extends AbstractController
{
    public function __construct(private SessionInterface $session){}

	public function index(): Response
	{
	    return $this->render('index.html.twig', [
		    'applicationData' => [
		        'isAuthenticated' => $this->session->has('user.token'),
            ],
        ]);
	}
}
