<?php

namespace Mvc\Framework\App\Controller;

use Mvc\Framework\App\Entity\User;
use Mvc\Framework\App\Repository\UserRepository;
use Mvc\Framework\Kernel\AbstractController;
use Mvc\Framework\Kernel\Attributes\Endpoint;
use Mvc\Framework\Kernel\JwtManager;
use Mvc\Framework\Kernel\Services\Serializer;
use Mvc\Framework\Kernel\Services\Request;

class AuthenticationController extends AbstractController
{
    #[Endpoint(
        path:'/authentication/create/account',
        name:'create_account',
        requestMethod:'POST',
        protected: true
    )]
    public final function create (Request $request, Serializer $serializer, UserRepository $userRepository)
    {
        //dd(getallheaders()[Authorization]);
        //retrievedToken = explode("Bearer ", );
        //j'instancie une nouvelle entité type x
        $user = new User();
        //j'utilise les setters de mon entité pour lui associer les valeurs que je reçois dans la requête POST
        $user->setSurname($request->retrievePostValue("surname"));
        $user->setName($request->retrievePostValue("name"));
        $user->setEmail($request->retrievePostValue("email"));
        $user->setPwd(password_hash(($request->retrievePostValue("pwd")), PASSWORD_BCRYPT));
        $user->setRoles($request->retrievePostValue("roles"));
        //je sauvegarde en base de données mon entité (attention à avoir les données necessaires pour la creation)
        $userRepository->save($user);
        //je transforme ma classe PHP (mon entité dans mon code) en tableau asscoiatif pour ensuite le transformer en JSON
        $serializedUser = $serializer->serialize($user);
        //j'utilise le JWT manager pour créer un token à partir de mon tableau associatif
        //ce token contiendra les informations du tableau associatif chiffré en une grande chaine de caracteres
        $token = JwtManager::generateToken($serializedUser);
        //je renvoie ma reponse au client
        $decodedToken = JwtManager::decodeToken($token);
        $this->send(
            ["user" => $serializedUser]
        );
    }

    #[Endpoint(
        path: '/authentication/show/accountlist',
        name: 'show_accountlist',
        requestMethod: 'GET'
    )]
    public final function readAll (UserRepository $userRepository) {
        $users = $userRepository->findAll();
        $this->send([
            "users" => $users
        ]);
    }

    #[Endpoint(
        path:'/authentication/show/myaccount',
        name: 'show_myaccount',
        requestMethod: 'GET'
    )]
    public final function read (Request $request, UserRepository $userRepository) {
        $user = $userRepository->find($request->retrieveGetValue("id"));
        $this->send([
                "user" => $user
        ]);
    }

    #[Endpoint(
        path:'/authentication/update/myaccount',
        name:'update_account',
        requestMethod: 'PATCH'
    )]
    public final function update (Request $request, UserRepository $userRepository) {
        $update = $request->retrieveAllPostValues();
        //$pwd = $request->retrievePostValue("pwd");
        //$pwd = password_hash($mdp, PASSWORD_BCRYPT);
        //$update["pwd"] = $pwd;
        $update["pwd"] = password_hash(($request->retrievePostValue("pwd")), PASSWORD_BCRYPT);
        $userRepository->update($request->retrievePostValue("id"), $update);
    }

    #[Endpoint(
        path:'/authentication/delete/myaccount',
        name:'delete_account',
        requestMethod:'DELETE')]
    public final function delete (Request $request, UserRepository $userRepository) {
        //dd($request->retrievePostValue("id"));
        $userRepository->delete($request->retrievePostValue("id"));
    }

    #[Endpoint(
        path:'/authentication/login',
        name:'login_account',
        requestMethod: 'POST'
    )]
    public final function login (Request $request, UserRepository $userRepository) {
        //dd($request->retrieveAllPostValues());
        //je stock le user recuperé en base de données
        $user = $userRepository->findBy([
           "email" => $request->retrievePostValue("email")
        ]);
        //on cible l'index 0 pour recuperer l'utilisateur car il est dans un tableau indexé
        $userFound = $user[0];
        //on cherche l'indice 0 car on a une contrainte d'unicité dans l'email - l'email est unique
        //dd($userFound);
        //on recupere le mot de passe reçu du CLIENT
        $clientPassword = $request->retrievePostValue("pwd");
        //dd($clientPassword);
        //on recupere le mot de pass hashé de l'utilisateur recuperé precedenment
        $hashedPassword = $userFound["pwd"];
        if(password_verify($clientPassword, $hashedPassword)){
            //ici on doit generer le token
            //le token doit contenir les infos utils pours retrouver quel utilisateur se "connecte" à notre API
            $data = [
                "id" => $userFound["id"],
                "email" => $userFound["email"],
                "roles" => $userFound["roles"]
            ];
            $token= JwtManager::generateToken($data);
            $this->send([
                "message" => "vous êtes bien connecté",
                "token" => $token
            ]);
        }else {
            //sinon on envoie une erreur
            $this->send([
                "message" => "le mot de pass ou votre email n'est pas correct"
            ]);
        }
    }
}