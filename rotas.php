<?php 
use Pecee\SimpleRouter\SimpleRouter;
use sistema\Nucleo\Helpers;

try {
    SimpleRouter::setDefaultNamespace('sistema\Controlador');
    SimpleRouter::get(URL_SITE, "SiteControlador@index");
    SimpleRouter::get(URL_SITE . "sobre", "SiteControlador@sobre");
    SimpleRouter::get(URL_SITE . "404",  "SiteControlador@erro404");
    SimpleRouter::get(URL_SITE . "post/{id}",  "SiteControlador@post");
    SimpleRouter::get(URL_SITE . "categoria/{id}",  "SiteControlador@categoria");
    SimpleRouter::post(URL_SITE  ."buscar", "SiteControlador@buscar");

    SimpleRouter::group(["namespace" => "Admin"], function () {
        SimpleRouter::get(URL_ADMIN . "dashboard", "AdminDashboard@dashboard");
        SimpleRouter::get(URL_ADMIN . "posts/listar", "AdminPosts@listar");
        SimpleRouter::match(['get', 'post'], URL_ADMIN . 'posts/cadastrar', 'AdminPosts@cadastrar');
    });

    SimpleRouter::start();
} catch (Pecee\SimpleRouter\Exceptions\NotFoundHttpException $ex) {
    Helpers::redirecionar('404');
}