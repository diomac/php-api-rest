<?php
/**
 * Created by PhpStorm.
 * User: Dionisio Gabriel Rigo de Souza Machado (https://github.com/diomac)
 * Date: 08/07/2018
 * Time: 10:09
 */

namespace Diomac\API;

use Diomac\API\swagger\Swagger;
use Error;
use JsonSerializable;
use Exception;

/**
 * Class Response
 * @package Diomac\API
 */
class Response
{
    /**
     * This interim response indicates that everything so far is OK and that the client should continue
     * with the request or ignore it if it is already finished.
     * @see https://developer.mozilla.org/en-US/docs/Web/HTTP/Status
     */
    const CONTINUE = 100;
    /**
     * This code is sent in response to an Upgrade request header by the client,
     * and indicates the protocol the server is switching to.
     * @see https://developer.mozilla.org/en-US/docs/Web/HTTP/Status
     */
    const SWITCHING_PROTOCOL = 101;
    /**
     * This code indicates that the server has received and is processing the request,
     * but no response is available yet.
     * @see https://developer.mozilla.org/en-US/docs/Web/HTTP/Status
     */
    const PROCESSING = 102;
    /**
     * The request has succeeded. The meaning of a success varies depending on the HTTP method:
     * GET: The resource has been fetched and is transmitted in the message body.
     * HEAD: The entity headers are in the message body.
     * PUT or POST: The resource describing the result of the action is transmitted in the message body.
     * TRACE: The message body contains the request message as received by the server
     * @see https://developer.mozilla.org/en-US/docs/Web/HTTP/Status
     */
    const OK = 200;
    /**
     * The request has succeeded and a new resource has been created as a result of it.
     * This is typically the response sent after a POST request, or after some PUT requests.
     * @see https://developer.mozilla.org/en-US/docs/Web/HTTP/Status
     */
    const CREATED = 201;
    /**
     * The request has been received but not yet acted upon. It is non-committal,
     * meaning that there is no way in HTTP to later send an
     * asynchronous response indicating the outcome of processing the request. It is intended
     * for cases where another process or server handles the request, or for batch processing.
     * @see https://developer.mozilla.org/en-US/docs/Web/HTTP/Status
     */
    const ACCEPTED = 202;
    /**
     * This response code means returned meta-information set is not exact set as available
     * from the origin server, but collected from a local or a third party copy.
     * Except this condition, 200 OK response should be preferred instead of this response.
     * @see https://developer.mozilla.org/en-US/docs/Web/HTTP/Status
     */
    const NON_AUTHORITATIVE_INFORMATION = 203;
    /**
     * There is no content to send for this request, but the headers may be useful.
     * The user-agent may update its cached headers for this resource with the new ones.
     * @see https://developer.mozilla.org/en-US/docs/Web/HTTP/Status
     */
    const NO_CONTENT = 204;
    /**
     * This response code is sent after accomplishing request to tell user agent
     * reset document view which sent this request.
     * @see https://developer.mozilla.org/en-US/docs/Web/HTTP/Status
     */
    const RESET_CONTENT = 205;
    /**
     * This response code is used because of range header sent by the client
     * to separate download into multiple streams.
     * @see https://developer.mozilla.org/en-US/docs/Web/HTTP/Status
     */
    const PARTIAL_CONTENT = 206;
    /**
     * A Multi-Status response conveys information about multiple
     * resources in situations where multiple status codes might be appropriate.
     * @see https://developer.mozilla.org/en-US/docs/Web/HTTP/Status
     */
    const MULTI_STATUS = 207;
    /**
     * The server has fulfilled a GET request for the resource, and the response
     * is a representation of the result of one or more instance-manipulations applied to the current instance.
     * @see https://developer.mozilla.org/en-US/docs/Web/HTTP/Status
     */
    const IM_USED = 226;
    /**
     * The request has more than one possible responses. User-agent or user
     * should choose one of them. There is no standardized way to choose one of the responses.
     * @see https://developer.mozilla.org/en-US/docs/Web/HTTP/Status
     */
    const MULTIPLE_CHOICE = 300;
    /**
     * This response code means that URI of requested resource has been changed.
     * Probably, new URI would be given in the response.
     * @see https://developer.mozilla.org/en-US/docs/Web/HTTP/Status
     */
    const MOVED_PERMANENTLY = 301;
    /**
     * This response code means that URI of requested resource has been changed
     * temporarily. New changes in the URI might be made in the future.
     * Therefore, this same URI should be used by the client in future requests.
     * @see https://developer.mozilla.org/en-US/docs/Web/HTTP/Status
     */
    const FOUND = 302;
    /**
     * Server sent this response to directing client to get requested
     * resource to another URI with an GET request.
     * @see https://developer.mozilla.org/en-US/docs/Web/HTTP/Status
     */
    const SEE_OTHER = 303;
    /**
     * This is used for caching purposes. It is telling to client that
     * response has not been modified. So, client can continue to use same cached version of response.
     * @see https://developer.mozilla.org/en-US/docs/Web/HTTP/Status
     */
    const NOT_MODIFIED = 304;
    /**
     * Was defined in a previous version of the HTTP specification to
     * indicate that a requested response must be accessed by a proxy.
     * It has been deprecated due to security concerns regarding in-band configuration of a proxy.
     * @see https://developer.mozilla.org/en-US/docs/Web/HTTP/Status
     */
    const USE_PROXY = 305;
    /**
     * This response code is no longer used, it is just reserved currently.
     * It was used in a previous version of the HTTP 1.1 specification.
     * @see https://developer.mozilla.org/en-US/docs/Web/HTTP/Status
     */
    const UNUSED = 306;
    /**
     * Server sent this response to directing client to get requested
     * resource to another URI with same method that used prior request.
     * This has the same semantic than the 302 Found HTTP response code,
     * with the exception that the user agent must not change the HTTP method used:
     * if a POST was used in the first request, a POST must be used in the second request.
     * @see https://developer.mozilla.org/en-US/docs/Web/HTTP/Status
     */
    const TEMPORARY_REDIRECT = 307;
    /**
     * This means that the resource is now permanently located at another URI,
     * specified by the Location: HTTP Response header. This has the same semantics as
     * the 301 Moved Permanently HTTP response code, with the exception that the user
     * agent must not change the HTTP method used: if a POST was used in the first request,
     * a POST must be used in the second request.
     * @see https://developer.mozilla.org/en-US/docs/Web/HTTP/Status
     */
    const PERMANENT_REDIRECT = 308;
    /**
     * This response means that server could not understand the request due to invalid syntax.
     * @see https://developer.mozilla.org/en-US/docs/Web/HTTP/Status
     */
    const BAD_REQUEST = 400;
    /**
     * Authentication is needed to get requested response. This is similar to 403,
     * but in this case, authentication is possible.
     * @see https://developer.mozilla.org/en-US/docs/Web/HTTP/Status
     */
    const UNAUTHORIZED = 401;
    /**
     * This response code is reserved for future use. Initial aim for creating
     * this code was using it for digital payment systems however this is not used currently.
     * @see https://developer.mozilla.org/en-US/docs/Web/HTTP/Status
     */
    const PAYMENT_REQUIRED = 402;
    /**
     * Client does not have access rights to the content so server is rejecting to give proper response.
     * @see https://developer.mozilla.org/en-US/docs/Web/HTTP/Status
     */
    const FORBIDDEN = 403;
    /**
     * Server can not find requested resource. This response code probably is
     * most famous one due to its frequency to occur in web.
     * @see https://developer.mozilla.org/en-US/docs/Web/HTTP/Status
     */
    const NOT_FOUND = 404;
    /**
     * The request method is known by the server but has been disabled and cannot be used.
     * The two mandatory methods, GET and HEAD, must never be disabled and should not return this error code.
     * @see https://developer.mozilla.org/en-US/docs/Web/HTTP/Status
     */
    const METHOD_NOT_ALLOWED = 405;
    /**
     * This response is sent when the web server, after performing server-driven content negotiation,
     * doesn't find any content following the criteria given by the user agent.
     * @see https://developer.mozilla.org/en-US/docs/Web/HTTP/Status
     */
    const NOT_ACCEPTABLE = 406;
    /**
     * This is similar to 401 but authentication is needed to be done by a proxy.
     * @see https://developer.mozilla.org/en-US/docs/Web/HTTP/Status
     */
    const PROXY_AUTHENTICATION_REQUIRED = 407;
    /**
     * This response is sent on an idle connection by some servers, even without any previous request by the client.
     * It means that the server would like to shut down this unused connection.
     * This response is used much more since some browsers, like Chrome,
     * Firefox 27+, or IE9, use HTTP pre-connection mechanisms to speed up surfing.
     * Also note that some servers merely shut down the connection without sending this message.
     * @see https://developer.mozilla.org/en-US/docs/Web/HTTP/Status
     */
    const REQUEST_TIMEOUT = 408;
    /**
     * This response would be sent when a request conflict with current state of server.
     * @see https://developer.mozilla.org/en-US/docs/Web/HTTP/Status
     */
    const CONFLICT = 409;
    /**
     * This response would be sent when requested content has been deleted from server.
     * @see https://developer.mozilla.org/en-US/docs/Web/HTTP/Status
     */
    const GONE = 410;
    /**
     * Server rejected the request because the Content-Length header field is not defined and the server requires it.
     * @see https://developer.mozilla.org/en-US/docs/Web/HTTP/Status
     */
    const LENGTH_REQUIRED = 411;
    /**
     * The client has indicated preconditions in its headers which the server does not meet.
     * @see https://developer.mozilla.org/en-US/docs/Web/HTTP/Status
     */
    const PRECONDITION_FAILED = 412;
    /**
     * Request entity is larger than limits defined by server; the server might close
     * the connection or return an Retry-After header field.
     * @see https://developer.mozilla.org/en-US/docs/Web/HTTP/Status
     */
    const PAYLOAD_TOO_LARGE = 413;
    /**
     * The URI requested by the client is longer than the server is willing to interpret.
     * @see https://developer.mozilla.org/en-US/docs/Web/HTTP/Status
     */
    const URI_TOO_LONG = 414;
    /**
     * The media format of the requested data is not supported by the server, so the server is rejecting the request.
     * @see https://developer.mozilla.org/en-US/docs/Web/HTTP/Status
     */
    const UNSUPPORTED_MEDIA_TYPE = 415;
    /**
     * The range specified by the Range header field in the request can't be fulfilled;
     * it's possible that the range is outside the size of the target URI's data.
     * @see https://developer.mozilla.org/en-US/docs/Web/HTTP/Status
     */
    const REQUESTED_RANGE_NOT_SATISFIABLE = 416;
    /**
     * This response code means the expectation indicated by the Expect request header
     * field can't be met by the server.
     * @see https://developer.mozilla.org/en-US/docs/Web/HTTP/Status
     */
    const EXPECTATION_FAILED = 417;
    /**
     * The server refuses the attempt to brew coffee with a teapot.
     * @see https://developer.mozilla.org/en-US/docs/Web/HTTP/Status
     */
    const I_M_A_TEAPOT = 418;
    /**
     * The request was directed at a server that is not able to produce a response.
     * This can be sent by a server that is not configured to produce responses for the combination
     * of scheme and authority that are included in the request URI.
     * @see https://developer.mozilla.org/en-US/docs/Web/HTTP/Status
     */
    const MISDIRECTED_REQUEST = 421;
    /**
     * The request was well-formed but was unable to be followed due to semantic errors.
     * @see https://developer.mozilla.org/en-US/docs/Web/HTTP/Status
     */
    const UN_PROCESSABLE_ENTITY = 422;
    /**
     * The resource that is being accessed is locked.
     * @see https://developer.mozilla.org/en-US/docs/Web/HTTP/Status
     */
    const LOCKED = 423;
    /**
     * The request failed due to failure of a previous request.
     * @see https://developer.mozilla.org/en-US/docs/Web/HTTP/Status
     */
    const FAILED_DEPENDENCY = 424;
    /**
     * The server refuses to perform the request using the current protocol but might be
     * willing to do so after the client upgrades to a different protocol.
     * The server sends an Upgrade header in a 426 response to indicate the required protocol(s).
     * @see https://developer.mozilla.org/en-US/docs/Web/HTTP/Status
     */
    const UPGRADE_REQUIRED = 426;
    /**
     * The origin server requires the request to be conditional. Intended to prevent the 'lost update' problem,
     * where a client GETs a resource's state, modifies it, and PUTs it back to the server, when meanwhile
     * a third party has modified the state on the server, leading to a conflict.
     * @see https://developer.mozilla.org/en-US/docs/Web/HTTP/Status
     */
    const PRECONDITION_REQUIRED = 428;
    /**
     * The user has sent too many requests in a given amount of time ("rate limiting").
     * @see https://developer.mozilla.org/en-US/docs/Web/HTTP/Status
     */
    const TOO_MANY_REQUESTS = 429;
    /**
     * The server is unwilling to process the request because its header fields are too large.
     * The request MAY be resubmitted after reducing the size of the request header fields.
     * @see https://developer.mozilla.org/en-US/docs/Web/HTTP/Status
     */
    const REQUEST_HEADER_FIELDS_TOO_LARGE = 431;
    /**
     * The user requests an illegal resource, such as a web page censored by a government.
     * @see https://developer.mozilla.org/en-US/docs/Web/HTTP/Status
     */
    const UNAVAILABLE_FOR_LEGAL_REASONS = 451;
    /**
     * The server has encountered a situation it doesn't know how to handle.
     * @see https://developer.mozilla.org/en-US/docs/Web/HTTP/Status
     */
    const INTERNAL_SERVER_ERROR = 500;
    /**
     * The request method is not supported by the server and cannot be handled.
     * The only methods that servers are required to support (and therefore that must not return this code)
     * are GET and HEAD.
     * @see https://developer.mozilla.org/en-US/docs/Web/HTTP/Status
     */
    const NOT_IMPLEMENTED = 501;
    /**
     * This error response means that the server, while working as a gateway to get a response needed
     * to handle the request, got an invalid response.
     * @see https://developer.mozilla.org/en-US/docs/Web/HTTP/Status
     */
    const BAD_GATEWAY = 502;
    /**
     * The server is not ready to handle the request. Common causes are a server that is down
     * for maintenance or that is overloaded. Note that together with this response,
     * a user-friendly page explaining the problem should be sent.
     * This responses should be used for temporary conditions and the Retry-After:
     * HTTP header should, if possible, contain the estimated time before the recovery of the service.
     * The webmaster must also take care about the caching-related headers that are sent along with this
     * response, as these temporary condition responses should usually not be cached.
     * @see https://developer.mozilla.org/en-US/docs/Web/HTTP/Status
     */
    const SERVICE_UNAVAILABLE = 503;
    /**
     * This error response is given when the server is acting as a gateway and cannot get a response in time.
     * @see https://developer.mozilla.org/en-US/docs/Web/HTTP/Status
     */
    const GATEWAY_TIMEOUT = 504;
    /**
     * The HTTP version used in the request is not supported by the server.
     * @see https://developer.mozilla.org/en-US/docs/Web/HTTP/Status
     */
    const HTTP_VERSION_NOT_SUPPORTED = 505;
    /**
     * The server has an internal configuration error: transparent content negotiation for
     * the request results in a circular reference.
     * @see https://developer.mozilla.org/en-US/docs/Web/HTTP/Status
     */
    const VARIANT_ALSO_NEGOTIATES = 506;
    /**
     * The server has an internal configuration error: the chosen variant resource is
     * configured to engage in transparent content negotiation itself, and is therefore not a
     * proper end point in the negotiation process.
     * @see https://developer.mozilla.org/en-US/docs/Web/HTTP/Status
     */
    const INSUFFICIENT_STORAGE = 507;
    /**
     * The server detected an infinite loop while processing the request.
     * @see https://developer.mozilla.org/en-US/docs/Web/HTTP/Status
     */
    const LOOP_DETECTED = 508;
    /**
     * Further extensions to the request are required for the server to fulfill it.
     * @see https://developer.mozilla.org/en-US/docs/Web/HTTP/Status
     */
    const NOT_EXTENDED = 510;
    /**
     * The 511 status code indicates that the client needs to authenticate to gain network access.
     * @see https://developer.mozilla.org/en-US/docs/Web/HTTP/Status
     */
    const NETWORK_AUTHENTICATION_REQUIRED = 511;

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
     * @var array $router
     */
    private $routes;
    /**
     * @var array $tags
     */
    private $tags;
    /**
     * @var AppConfiguration $appConfig
     */
    private $appConfig;

    /**
     * @var array $fields
     */
    private static $fields;
    /**
     * @var array $defaultJsonFields
     */
    private static $defaultJsonFields;

    /**
     * Response constructor.
     * @param array|null $routes
     * @param array|null $tags
     * @param AppConfiguration|null $config
     */
    public function __construct(array $routes = null, array $tags = null, AppConfiguration $config = null)
    {
        $this->routes = $routes;
        $this->tags = $tags;
        $this->appConfig = $config;
    }

    /**
     * @param string $fields
     * @param string $className
     */
    public static function setFields(string $fields, string $className): void
    {
        self::$fields[$className] = $fields;
    }

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
        if ($this->responseCode() === self::NO_CONTENT) {
            $this->body = null;
        }
    }

    /**
     * @param JsonSerializable $body
     */
    public function setBodyJSON(JsonSerializable $body): void
    {
        $this->setContentType('application/json');
        $this->body = json_encode($body, JSON_PRETTY_PRINT);
        if ($this->responseCode() === self::NO_CONTENT) {
            $this->body = null;
        }
    }

    /**
     * @param Swagger $swagger
     * @throws Exception
     */
    public function setBodySwaggerJSON(Swagger $swagger): void
    {
        $swagger->setBasePath($this->appConfig->getBaseUrl());
        $swagger->setPaths($this->routes);
        $swagger->setTags($this->tags);
        $swagger->setConsumes();
        $swagger->setProduces();
        try {
            $this->setBodyJSON($swagger);
        } catch (Exception $ex) {
            throw $ex;
        }
    }

    /**
     * @param Swagger $swagger
     * @throws Exception
     */
    public function setBodySwaggerYAML(Swagger $swagger): void
    {
        $swagger->setBasePath($this->appConfig->getBaseUrl());
        $swagger->setPaths($this->routes);
        $swagger->setTags($this->tags);
        $swagger->setConsumes();
        $swagger->setProduces();
        try {
            $this->body = yaml_emit($swagger);
        } catch (Exception $ex) {
            throw $ex;
        } catch (Error $err) {
            if (strpos('Call to undefined function Diomac\API\yaml_emit()', $err->getMessage()) !== false) {
                throw new Exception('Yaml not configured. Check http://pecl.php.net/package/yaml.');
            }
            throw $err;
        }
    }

    /**
     * @param $type string
     */
    public function setContentType($type): void
    {
        $this->headers['content-type'] = $type . '; charset=UTF-8';
    }

    /**
     * Output response
     */
    public function output(): void
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
    protected function responseCode(): int
    {
        return $this->code;
    }

    /**
     * @param $name string
     * @param $value string
     *
     */
    public function setHeader($name, $value): void
    {
        $this->headers[$name] = $value;
    }

    /**
     * Use this method to implements JsonSerialize of your Definition Class.
     *
     * @param JsonSerializable $object
     * @param bool $showNullValues
     * @return array
     * @throws Exception
     */
    public static function jsonSerialize(
        JsonSerializable $object,
        bool $showNullValues = false
    ): array {

        $arrayKeys = [];
        $indexValues = [];

        foreach (self::$defaultJsonFields as $jf) {
            $arrayKeys[] = $jf->getName();
            $indexValues[$jf->getName()] = $jf->getValue();
        }

        if (isset(self::$fields[get_class($object)])) {
            $properties = explode(',', self::$fields[get_class($object)]);
        } else {
            $properties = $arrayKeys;
        }

        $json = [];

        foreach ($properties as $p) {
            $i = $p;
            if (strpos($p, ':') !== false) {
                list($i, $p) = explode(':', $p);
            }

            if ($indexValues[$i] || $showNullValues) {
                $json[$p] = $indexValues[$i];
            }
        }

        self::$defaultJsonFields = [];
        return $json;
    }

    /**
     * Use this method to filter fields in your end-point
     *
     * @param array $fields
     * @param array $restrict
     * @return array
     */
    public static function restrictFields(array $fields, array $restrict): array
    {
        return array_filter($fields, function ($v) use ($restrict) {
            return in_array(explode(':', $v)[0], $restrict);
        });
    }

    /**
     * Use this method to implements function jsonSerialize from JsonSerializable
     * Interface
     *
     * @param string $name
     * @param mixed $value
     */
    public static function jsonField(string $name, $value): void
    {
        self::$defaultJsonFields[] = new JsonField($name, $value);
    }
}
