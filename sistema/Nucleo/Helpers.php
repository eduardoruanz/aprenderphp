<?php

namespace sistema\Nucleo;

use Exception;

class Helpers {

    public static function redirecionar(string $url = null): void {
        header('HTTP/1.1 302 Found ');

        $local = ($url ? self::url($url) : self::url());

        header("Location: {$local}");
        exit();
    }


    /**
     * Valida um numero de CPF
     * @param string $cpf
     * @return bool
     */
    public static function validarCpf(string $cpf): bool {
        // self para chmar por meio do self
        $cpf = self::LimparNumero($cpf);
        if(mb_strlen($cpf) != 11 or preg_match("/(\d) \1 (10)/", $cpf)) {
            throw new Exception('O CPF precisa ter 11 digitos');
        }
        for ($t = 9; $t < 11; $t++) {

            for ($d = 0, $c = 0; $c < $t; $c++) {
                $d += $cpf[$c] * (($t + 1) - $c);
            }
            $d = ((10 * $d) % 11) % 10;
            if ($cpf[$c] != $d) {
                throw new Exception('CPF invalido por favor informe um CPF valido');
            }
        }
        return throw new Exception('CPF aprovado');
    }

    public static function LimparNumero(string $number): string {
        return preg_replace("/[^0-9]/", "", $number);
    }


    public static function IntTime(): string {
        $horAtual = date('H');

        // opcoes criadas 
        switch ($horAtual) {
            // caso a hor for maior ou igual a zero, e a hor for menor ou igual a 5
            case $horAtual >= 0 and $horAtual <= 5:
                $dateSauda = 'Boa madrugada';
                // fecha essa ocasiao 
            break;
            
            // caso a hora atual for maior que cinco e menor ou igual a meio dia, retone bom dia
            case $horAtual > 5 and $horAtual < 12:
                $dateSauda = 'Bom dia';
            break;

            case $horAtual >= 12 and $horAtual < 18:
                $dateSauda = 'Boa tarde';
            break;

            case $horAtual >= 18 and $horAtual <= 23:
                $dateSauda = 'Boa noite';
            break;
            
            // se nenhuma opcao ou ocasiao ocorrer vai voltar um erro, como se fosse um else
            default:
                $dateSauda = 'Ocorreu algum erro com o horario do servidor';
        }    

        return $dateSauda;
    }        


    public static function FechadoComercio(): string {
        $HoraFechamento = date('H');

        switch ($HoraFechamento) {
            case $HoraFechamento >= 18 && $HoraFechamento < 23:
                $FechadoAberto = 'Estamos abertos';
            break;

            default:
                $FechadoAberto = 'Estamos fechados';
        }

        return $FechadoAberto;
    }


    public static function SlugUrl(string $string): string {
        $mapaA = ['Ʌ', 'Ɇ', 'ɇ', 'Ɉ', 'ɉ', 'Ɋ', 'ɋ', 'Ɍ', 'ɍ', 'Ɏ', 'ɏ', 'ɐ', 'ɒ', 'ɓ', 'ɔ', 'ɕ', 'ɖ', 'ɗ', 'ɘ', 'ə', 'ɛ', 'ɜ', 'ɝ', 'ɞ', 'ɟ', 'ɠ', 'ɢ', 'ɤ', 'ɥ', 'ɦ', 'ɧ', 'ɨ', 'ɫ', 'ɬ', 'ɭ', 'ɮ', 'ɰ', 'ɱ', 'ɲ', 'ɳ', 'ɵ', 'ɶ', 'ɷ', 'ɸ', 'ɹ', 'ɺ', 'ɻ', 'ɼ', 'ɽ', 'ɾ', 'ɿ', 'ʁ', 'ʃ', 'ʄ', 'ʅ', 'ʆ', 'ʇ', 'ʈ', 'ʉ', 'ʊ', 'ʌ', 'ʍ', 'ʎ', 'ʑ', 'ʒ', 'ʓ', 'ʕ', 'ʖ', 'ʗ', 'ʘ', 'ʚ', 'ʝ', 'ʞ', 'ʠ', 'ʡ', 'ʢ', 'ʦ', 'ʧ', 'ʨ', 'ʩ', 'ʪ', 'ʬ', 'ʭ', 'ʮ', 'ʯ', 'ʰ', 'ʱ', 'ʲ', 'ʳ', 'ʴ', 'ʵ', 'ʶ', 'ʷ', 'ʸ', 'ʹ', 'ʺ', 'ʻ', 'ʼ', 'ʽ', 'ʾ', 'ʿ', 'ˀ', 'ˁ'];

        $mapaB = ['a', 'e', 'e', 'e', 'j', 'j', 'j', 'r', 'r', 'y', 'y', 'a', 'a', 'b', 'c', 'c', 'd', 'd', 'e', 'e', 'e', 'e', 'e', 'e', 'g', 'g', 'g', 'h', 'h', 'h', 'h', 'i', 'l', 'l', 'l', 'l', 'l', 'm', 'n', 'n', 'n', 'o', 'o', 'o', 'o', 'o', 'o', 'p', 'r', 'r', 'r', 'r', 'r', 'r', 'r', 'r', 'r', 'r', 'r', 's', 's', 't', 't', 't', 'u', 'u', 'u', 'v', 'v', 'w', 'x', 'y', 'z', 'z', 'z', 'z', 'z', 'z', 'z', 'z', 'z', 'z', 'z', 'z', 'z', 'z', 'z', 'z', 'z', 'z', 'z', 'z', 'z', 'z', 'z', 'z', 'z'];

        $slug = str_replace($mapaA, $mapaB, $string);
        $slug = strip_tags(trim($slug));
        $slug = str_replace(' ', '?', $slug);
        $slug = str_replace(['?????', '????', '???', '??'], '?', $slug);

        return strtolower($slug);
    }



    public static function dataAtual(): string {
        $diaMes = date('d'); // dia do mes por ex: 12
        $diaSemana = date('w'); // dia da semana ex: segunda feira
        $mes = date('n') - 1; // mes que a gente se econtra menos para poder utilizar o array
        $ano = date('Y'); // ano em atual que a gente se encontra

        $nomesDiaDaSemana = [ // lista do dias da semana 
            'domingo',
            'segunda-feira',
            'terça-feira',
            'quarta-feira',
            'quinta-feira',
            'sexta-feira',
            'sabado'
        ];

        $nomeDosMeses = [ // lista do meses do ano
            'janeiro',
            'fevereiro',
            'março',
            'abril',
            'maio',
            'junho',
            'julho',
            'agosto',
            'setembro',
            'outubro',
            'novembro',
            'dezembro'
        ];

        $dataFormatada = $nomesDiaDaSemana[$diaSemana]; // recebe os nomes do dia da semana, e se ordena pela data atual pegado pelo date
        $dataMes = $nomeDosMeses[$mes]; // recebe os nomes do mes, é o mes se ordena sozinho pelo mes

        return $dataFormatada . ', ' . $diaMes . ' de ' . $dataMes . ' de ' . $ano; // retorna o resultado
    }

    public static function DiaAberto(): string {
        $SemanaDia = date('w');

        $DiasDaSemana = [ 
            'domingo',
            'segunda-feira',
            'terça-feira',
            'quarta-feira',
            'quinta-feira',
            'sexta-feira',
            'sabado'
        ];

        $DiaAtual = $DiasDaSemana[$SemanaDia];

        switch ($DiaAtual) {
            // caso o dia da semana for domingo retorne estamos fechados
            case $DiaAtual == 'domingo':
                return 'Estamos fechados!';
            break;

            default:
                return 'Estamos abertos teste';
        }
    }

    /**
     * Monta uma url automaticamente, de acordo ambiente
     * @param string $url parte da url ex: admin
     * @return string $url comleta
     */
    public static function url(string $url = null): string {
        
        $servidor = filter_input(INPUT_SERVER, 'SERVER_NAME');
        // se não for servidor igual a localhost
        $ambiente = ($servidor == 'localhost' ? URL_DESENVOLVIMENTI 
        
        // se nao
        : URL_DEPPRODUCAO);


        // se iniciar com a url / . retorne o ambiente e a url
        if(str_starts_with($url, '/')) {
            return $ambiente . $url;
        }

        return $ambiente . '/' . $url;

    }

    public static function localhost(): bool {

        $servidor = filter_input(INPUT_SERVER, 'SERVER_NAME');

        if($servidor == 'localhost') {
            return true;
        }

        return false;
    }


    // funcão validar email, $url vai ser uma string, e vai retornar um valor boleano.
    public static function validarUrlFeito(string $urldireta): bool {

        if (mb_strlen($urldireta) <= 10) {
            return false;
        } 
        // O operador "!" é como uma forma de dizer "não é verdade que" em linguagem humana. Ele é usado para questionar ou negar uma afirmação.
        // $$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$
        // se a url não tiver um ponto, retorne um falso o perador logico "!" significa não.
        if (!str_contains($urldireta, '.')) {
            return false;
        }
        // se a url nao tiver um http ou um https, retorne um falso
        if (str_contains($urldireta, 'https://') or str_contains($urldireta, 'http://')) {
            return true;
        }

        return false;
    }


    public static function validarUrl(string $url): bool {
        return filter_var($url, FILTER_VALIDATE_URL);
    }


    public static function validarEmail(string $email): bool {

        return filter_var($email, FILTER_VALIDATE_EMAIL);
    }
    /**
     * Conta o tempo decorrido de uma data
     * @param $data digete sua data atual.
     * @return retuna a quanto tempo aqulo foi iniciado.
     * 
     */
        public static function contarTempo(string $data): string {
            // primeiro pega o horario do usuario tarnformada em segundos
            $dotay = strtotime(date('Y-m-d H:i:s'));
            // time recebe o tempo do banco de dados. transforma em segundos
            $time = strtotime($data);
            // pega a difença entre o tempo do banco de dados, e a o tempo do servidor
            $diferença = $dotay - $time;    

            // segundos vai ser a propria difernça 
            $segundos = $diferença;
            // minutos aredonda ele para um numero mais preciso, e divide por 60 segundos
            $minutos = round($diferença / 60);
            // a hora eu arendendo para um numero mais preciso, e divido ele por 3600 segundos
            $hora = round($diferença / 3600);
            // dia eu aredondo ele para um nmumero mais preciso, e divido por 86400
            $dia = round($diferença / 86400);
            // calcular as semanas 
            $semama = round($diferença / 604800);
            // mes
            $mes = round($diferença / 2419200);
            // ano eu arredondo para um numero inteiro, e divido por 31.536.000
            $ano = round($diferença / 31536000);

            // se os meus segundos for menor, ou igual 60 escrever "agora":
            if($segundos >= 0 && $segundos <= 60){
                return "A poucos segundos";
        }
        // se minutos for menor ou igual a 60, retorne minutos igual a 1 sim há 1 minuto se nao retorne há x minutos  
        elseif ($minutos <= 60) {
            return $minutos == 1 ? ' há 1 minutos ' : ' há ' . $minutos .  ' minutos' ;
        } elseif ($hora <= 24) {
            return $hora == 1 ? ' Há 1 hora ' : ' há ' . $hora . ' horas '; 
        } elseif ($dia <= 7) {
            return $hora == 1 ? ' Há 1 dia ' : ' há ' . $dia . ' dias';
        } elseif ($semama <= 4) {
            return $semama == 1 ? ' Há 1 semana ' : ' há '. $semama . ' semanas';
        } // se $mes for menor ou igual a 12
        elseif ($mes <= 12) {
            return $mes == 1 ? ' Há 1 mes ' : 'Há '. $mes . ' mes ';
        } elseif ($ano >= 1 ) {
            return $ano == 1 ? ' Há um ano ' : 'Há '. $ano . ' anos';
        }
        
        //debugar o codigo
        var_dump($segundos, $minutos, $hora, $dia, $semama, $mes, $ano);
    }
    /**
     * @param float $numeroFormat informar o numero para deixar inteiro
     * @param string $formatar numero é retornado formatato por meio de um return
     */
    // função para formatar um valor
    // primeiro vamos passar os parametros
    // numeroFloat recebe um valor nulo, ou um valor indefinido
    public static function formatarValor(float $numeroFormat = null): string {
        // agora vamos formatar o numero
        // se o meu valor existir eu recebo esse valor se nao recebo 0
        return number_format(($numeroFormat ? $numeroFormat : 0) ,2 , ',', '.');
    }


    public static function formatarNumero(int $numero = null): string {
        // retorne o numero formatdo, se tiver o numero, numero vai receber o numero. Se não retorna o valor 10
        return number_format($numero ?: 10, 2, '.', '.');
    }



    public static function horario(): string {
        // pegando o horario da america latina, e colocando no servidor
        $horarioSaoPaulo = date("H");
        
        //
        
        if ($horarioSaoPaulo > 5 && $horarioSaoPaulo <= 12) {
            $saudacao = 'Bom dia';
        }

        if ($horarioSaoPaulo > 12 && $horarioSaoPaulo <= 18) {
            $saudacao = 'Boa Tarte';
        }
        
        if ($horarioSaoPaulo > 18 && $horarioSaoPaulo <= 23) {
            $saudacao = 'Bom Noite';
        }
        if ($horarioSaoPaulo >= 0 && $horarioSaoPaulo <= 5) {
            $saudacao = 'Boa madrugada';
        } 

        return $saudacao;

    }


    //funcao resumir texto recebe os parametros e variaveis e retorna para o arquivo index
    //sempre bom declarar o tipo de uma variavel, para a função ficar mais segura e definida 
    public static function contarSting() {
        $nome = 'eduardo';
        // conta quantas caracteres tem no texto sem os espaços
        $contarString = mb_strlen(trim($nome));
        $erro = '';    
        
        // se contarString for maior ou igual a 20 caracteres
        if ($contarString >= 20) {
            $erro = 'Por favor digete um nome menor';

        } 
        // senaose contarSring for menor ou igual a 19
        elseif ($contarString <= 19) {
            $erro = 'Nome aprovado!';
        }

        // retorna o resultado
        return $erro;

    }
    /**
     * Resume um texto
     * 
     * @param string $texto texto para resumir
     * @param int $limite quantidade de caracteres
     * @param string $continue ele vai ser opcional - o que deve ser exibido ao final do resumo
     * @return string texto resumido
     */

    // parametros e variaveis passados
    public static function resumirTexto(string $texto , int $limete, string $continue = '...'): string {

        // a string vai ser sem espaços
        $textoLimpo = trim(strip_tags($texto));

        // verifiacar quantas caracteres tem na string, entao
        // se o texto for menor ou igual ao limete de caracteres, vai retornar a string  
        if(mb_strlen($textoLimpo) <= $limete) {
            return $textoLimpo;
        } 

        // limpar a string
        $resumirTexto = mb_substr($textoLimpo, 0, mb_strrpos(mb_substr($textoLimpo, 0, $limete), ''));
        
        // retornar o texto resumido, e deixar continuar
        return $resumirTexto . $continue;
    }
}