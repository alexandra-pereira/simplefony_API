<?php

namespace Mvc\Framework\App\Controller;

use Mvc\Framework\App\Entity\Reseller;
use Mvc\Framework\App\Repository\ResellerRepository;
use Mvc\Framework\App\Repository\UserRepository;
use Mvc\Framework\Kernel\AbstractController;
use Mvc\Framework\Kernel\Attributes\Endpoint;
use Mvc\Framework\Kernel\JwtManager;
use Mvc\Framework\Kernel\Services\Request;
use Mvc\Framework\Kernel\Services\Serializer;

class ResellerController extends AbstractController
{
    #[Endpoint('/reseller/create', 'create_reseller', 'POST')]
    public final function create (Request $request, ResellerRepository $resellerRepository, Serializer $serializer) {
        $reseller = new Reseller();
        $reseller->setCompany($request->retrievePostValue("company"));
        $reseller->setPhone($request->retrievePostValue("phone"));
        $reseller->setEmail($request->retrievePostValue("email"));
        $reseller->setWebsite($request->retrievePostValue("website"));
        $resellerRepository->save($reseller);
        $serializedReseller = $serializer->serialize($reseller);
        $token = JwtManager::generateToken($serializedReseller);
        $decodedToken = JwtManager::decodeToken($token);
        $this->send(
            ["reseller" => $serializedReseller]
        );
    }

    #[Endpoint('/reseller/show', 'show_reseller', 'GET')]
    public final function read () {
        $this->send([
            "message" => "endpoint pour afficher revendeur"
        ]);
    }

    #[Endpoint('/reseller/update', 'update_reseller', 'POST')]
    public final function update () {
        $this->send([
            "message" => "endpoint pour update reseller"
        ]);
    }

    #[Endpoint('/reseller/delete', 'delete_reseller', 'GET')]
    public final function delete () {
        $this->send([
            "message" => "endpoint pour delete reseller"
        ]);
    }
}