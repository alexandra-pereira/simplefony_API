<?php

namespace Mvc\Framework\App\Controller;

use Mvc\Framework\Kernel\AbstractController;
use Mvc\Framework\Kernel\Attributes\Endpoint;
use Mvc\Framework\Kernel\Services\Request;

class ProductController extends AbstractController
{
    #[Endpoint('/products/create', 'create_product', 'POST')]
    public final function create (Request $request) {
        dd($request);
        $this->send([
            "message" => "endpoint pour la création"
        ]);
    }

    #[Endpoint('/products/show', 'show_product', 'GET')]
    public final function read (Request $request) {
        $this->send([
            "message" => "endpoint pour afficher"
        ]);
    }

    #[Endpoint('/products/update', 'update_product', 'POST')]
    public final function update (Request $request) {
        dd($request);
        $this->send([
            "message" => "endpoint update"
        ]);
    }

    #[Endpoint('/products/delete', 'delete_product', 'GET')]
    public final function delete (Request $request) {
        $this->send([
            "message" => "enpoint delete"
        ]);
    }
}