<?php

namespace Mvc\Framework\Kernel;

use Mvc\Framework\App\Repository\UserRepository;

class Guard
{
    public static function check ():bool {
        try {
            $decodedToken = JwtManager::decodeToken(self::getToken());
        } catch (\Exception $exception) {
            return false;
        }
        //dd($decodedToken);
        //recuperer l'id de l'utilisateur contenu dans le token
        //on fera une requete vers la bdd (repo) pour savoir si l'utilisateur existe sinon on renvoie un boolean
        $userId = $decodedToken ["id"];
        //dd($userId);
        $repo = new UserRepository();
        $user= $repo->find($userId);
        //dd($user);
        if (count($user) > 0) {
            return true;
        }
        return false;
    }

    public static function getToken():string {
        //dd(getallheaders());
        $headers = getallheaders();
        $authorizationHeader = $headers ["Authorization"];
        //dd($authorizationHeader);
        $token = str_replace("Bearer ", '', $authorizationHeader);
        return trim($token);
        //dd($token);
    }
}