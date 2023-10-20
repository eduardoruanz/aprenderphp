<?php 

namespace sistema\Suporte;
use Twig\Lexer;
use sistema\Nucleo\Helpers;

class Template {

    private \Twig\Environment $twig;

    public function __construct(string $diretorio) {
        $loader = new \Twig\Loader\FilesystemLoader($diretorio);
        $this->twig = new \Twig\Environment($loader);

        $lexer = new Lexer($this->twig, array(
            $this->helpers()
        ));

        $this->twig->setLexer($lexer);
    }

    public function renderizar(string $view, array $dados) {
        return $this->twig->render($view, $dados);
    }

    private function helpers(): void {

        array(
            // criar funcoes com tamplete
            $this->twig->addFunction(
                new \Twig\TwigFunction('url', function(string $url = null) {
                    // chamar a funcao pronta do helpers
                    return Helpers::url();
                })
            ),

            $this->twig->addFunction(
                new \Twig\TwigFunction('hora', function(): string {

                    return Helpers::horario();

                })
            ),

            $this->twig->addFunction(
                new \Twig\TwigFunction('resumiretexto', function(string $texto, int $limite): string {
                    return Helpers::resumirTexto($texto, $limite);
                })
            ), 
        );
    }
}