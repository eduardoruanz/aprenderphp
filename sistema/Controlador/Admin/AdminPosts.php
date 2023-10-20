<?php 
namespace sistema\Controlador\Admin;

use sistema\Modelo\CategoriaModelo;
use sistema\Modelo\PostModelo;
use sistema\Nucleo\Helpers;

class AdminPosts extends AdminControlador {
    public function listar():void {
        echo $this->template->renderizar('posts/tables.html',[
            'posts' => (new PostModelo)->busca(),
        ]);
    }

    public function tituos(): void {
        echo $this->template->renderizar('topo.html', [
            'titulo' => 'Posts'
        ]);
    }

    public function cadastrar():void {

        $dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);
        if(isset($dados)) {
            (new CategoriaModelo())->Armazernar($dados);
            Helpers::redirecionar('admin/posts/listar');
        }
        echo $this->template->renderizar('posts/formulario.html',[
            
        ]);
    }
}