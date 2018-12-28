<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TickerController extends AbstractController
{
    /**
     * @Route("/ticker/")
     */
    public function ticker()
    {
        return $this->render('ticker.html.twig', [
        ]);
    }
}
