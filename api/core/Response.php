<?php
/**
 * Created by PhpStorm.
 * User: Dionisio Gabriel Rigo de Souza Machado (https://github.com/diomac)
 * Date: 08/07/2018
 * Time: 10:09
 */

namespace api\core;


class Response
{
    /**
     *Essa resposta provisória indica que tudo ocorreu bem até agora e que o cliente deve continuar com a requisição ou ignorar se já concluiu o que gostaria.
     */
    const CONTINUE = 100;
    /**
     * Esse código é enviado em resposta a um cabeçalho de solicitação Upgrade pelo cliente, e indica o protocolo que o servidor está alternando.
     */
    const SWITCHING_PROTOCOL = 101;
    /**
     * Esse código indica que o servidor recebeu e está processando a solicitação, mas nenhuma resposta está disponível ainda.
     */
    const PROCESSING = 102;
    /**
     * Estas requisição foi bem sucessida. O significado do sucesso varia de acordo com o método HTTP:
     * GET: O recurso foi buscado e transmitido no corpo da mensagem.
     * HEAD: As headers da entidade estão no corpo da mensagem.
     * POST: O recurso descrevendo o resultado da ação foi trasmitido no corpo da mensagem.
     * TRACE: O corpo da mensagem contem a mensagem de requisição recebida pelo servidor
     */
    const OK = 200;
    /**
     * A requisição foi bem sucessida e um novo recurso foi criado como resultado. Esta é uma tipica resposta enviada após uma requisição PUT.
     */
    const CREATED = 201;
    /**
     * A requisição foi recebida mas nenhuma ação foi tomada sobre ela. Isto é uma requisição não-comprometedora, o que significa que não há nenhuma maneira no HTTP para enviar uma resposta assíncrona indicando o resultado do processamento da solicitação. Isto é indicado para casos onde outro processo ou servidor lida com a requisição, ou para processamento em lote.
     */
    const ACCEPTED = 202;
    /**
     * Esse código de resposta significa que o conjunto de meta-informações retornadas não é o conjunto exato disponível no servidor de origem, mas coletado de uma cópia local ou de terceiros. Exceto essa condição, a resposta de 200 OK deve ser preferida em vez dessa resposta.
     */
    const NON_AUTHORITATIVE_INFORMATION = 203;
    /**
     * Não há conteúdo para enviar para esta solicitação, mas os cabeçalhos podem ser úteis. O user-agent pode atualizar seus cabeçalhos em cache para este recurso com os novos.
     */
    const NO_CONTENT = 204;
    /**
     * Esta requisição é enviada após realizada a solicitação para informar ao user agent redefinir a visualização do documento que enviou essa solicitação.
     */
    const RESET_CONTENT = 205;
    /**
     * Esta resposta é usada por causa do cabeçalho de intervalo enviado pelo cliente para separar o download em vários fluxos.
     */
    const PARTIAL_CONTENT = 206;
    /**
     * Uma resposta de vários estados transmite informações sobre vários recursos em situações em que vários códigos de status podem ser apropriados.
     */
    const MULTI_STATUS = 207;
    /**
     * O servidor cumpriu uma solicitação GET para o recurso e a resposta é uma representação do resultado de uma ou mais manipulações de instância aplicadas à instância atual.
     */
    const IM_USED = 226;
    /**
     * @var $code int
     */
    private $code = self::NO_CONTENT;
    /**
     * @var $body string
     */
    private $body = null;
    /**
     * @var $headers array
     */
    private $headers = ['content-type' => 'text/html; charset=UTF-8'];

    /**
     * @param int $code
     */
    public function setCode(int $code)
    {
        $this->code = $code;
    }

    /**
     * @param string $body
     */
    public function setBody(string $body)
    {
        $this->body = $body;
        if($this->responseCode() === self::NO_CONTENT){
            $this->body = null;
        }
    }

    /**
     * @param object $body
     */
    public function setBodyJSON(object $body)
    {
        $this->setContentType('application/json');
        $this->body = json_encode($body, JSON_PRETTY_PRINT);
        if($this->responseCode() === self::NO_CONTENT){
            $this->body = null;
        }
    }

    /**
     * @param $type string
     */
    public function setContentType($type){
        $this->headers['content-type'] = $type . '; charset=UTF-8';
    }

    /**
     * Output response
     */
    public function output()
    {
        foreach ($this->headers as $name => $value) {
            header($name . ': ' . $value, true, $this->responseCode());
        }
        header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
        echo $this->body;
    }

    /**
     * HTTP response code
     * @return int
     */
    protected function responseCode()
    {
        return $this->code;
    }

    /**
     * @param $name string
     * @param $value string
     *
     */
    public function setHeader($name, $value){
        $this->headers[$name] = $value;
    }

}