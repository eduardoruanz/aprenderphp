<?php 
namespace sistema\Controlador;
use sistema\Nucleo\Controlador;
use sistema\Nucleo\Helpers;
use sistema\Modelo\PostModelo;
use sistema\Modelo\CategoriaModelo;

class SiteControlador extends Controlador {
    
    public function __construct()
    {
        parent::__construct('templates/site/views');
    }

    public function index(): void {

        $pots = (new PostModelo())->busca();

        echo $this->template->renderizar('index.html', [
            'Titulo' => 'Betel Corp / Início',
            'subtitulo' => 'teste de subtitlo',
            'horario' => Helpers::dataAtual(),
            'HoraAtual' => Helpers::IntTime(),
            'HoraFechamento' => Helpers::FechadoComercio(),
            'DiaFechamento' =>  Helpers::DiaAberto(),
            'posts' => $pots,
            'categorias' => $this->categorias()    
        ]);
    }

    public function buscar(): void {

        $busca = filter_input(INPUT_POST, 'busca', FILTER_DEFAULT);

        if(isset($busca)) {
            $posts = (new PostModelo())->pesquisa($busca);

            foreach ($posts as $post) {
                echo 
                "<li class='list-group-item fw-bold'>
                    <a href=".Helpers::url('post/').$post->id."
                        class='text-dark nav-link'>$post->titulo
                    </a>
                </li>";
            }
        }
    }

    public function post(int $id): void {
        $post = (new PostModelo())->buscarId($id);

        if(!$post) {
            Helpers::redirecionar('404');
        }

        echo $this->template->renderizar('post.html', [
            'post' => $post,
            'categorias' => $this->categorias()
        ]);
    }

    public function categorias() {
        return  (new CategoriaModelo())->busca();
    }

    public function categoria(int $id): void {
        
        $posts = (new CategoriaModelo())->posts($id);

        echo $this->template->renderizar('categoria.html', [
            'posts' => $posts,
            'categorias' => $this->categorias()
        ]);
    } 

    public function sobre(): void {
        echo $this->template->renderizar('sobre.html', [
            'Titulo' => 'Betel Corp / Sobre'
        ]);
    }

    public function erro404(): void {
        echo $this->template->renderizar('404.html', [
            'Titulo' => 'Página não encontrada'
        ]);
    }
}

