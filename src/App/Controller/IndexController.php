<?php

namespace Mvc\Framework\App\Controller;

use Mvc\Framework\App\Entity\TechnicalSheet;
use Mvc\Framework\App\Repository\TechnicalSheetRepository;
use Mvc\Framework\Kernel\AbstractController;
use Mvc\Framework\Kernel\Attributes\Endpoint;
use Mvc\Framework\Kernel\Services\Request;

class IndexController extends AbstractController
{
    #[Endpoint('/', name: 'index', requestMethod: 'GET')]
    public final function index(Request $request, TechnicalSheetRepository $ficheTechniqueRepository): void
    {
        $product = new TechnicalSheet();
        $product->setName('Velo1');
        $product->setWeight(12.99);
        $product->setDescription('Mon super velo');
        $ficheTechniqueRepository->save($product);
        $this->send(["message" => $ficheTechniqueRepository->findAll()]);
    }

}
