<?php
/**
 * Created by PhpStorm.
 * User: Dionisio Gabriel Rigo de Souza Machado - https://github.com/diomac
 * Date: 04/03/2019
 * Time: 13:40
 */

namespace Diomac\API\swagger;


use Diomac\API\Response;
use Exception;
use JsonSerializable;

class SwaggerInfo implements JsonSerializable
{
    /**
     * @var string $version
     */
    private $version;
    /**
     * @var string $title
     */
    private $title;
    /**
     * @var string $description
     */
    private $description;
    /**
     * @var string $termsOfService
     */
    private $termsOfService;
    /**
     * @var SwaggerInfoContact $contact
     */
    private $contact;
    /**
     * @var SwaggerInfoLicense $license
     */
    private $license;

    /**
     * SwaggerInfo constructor.
     */
    public function __construct()
    {
        $this->contact = new SwaggerInfoContact();
        $this->license = new SwaggerInfoLicense();
    }

    /**
     * @return string
     */
    public function getVersion(): string
    {
        return $this->version;
    }

    /**
     * @param string $version
     */
    public function setVersion(string $version): void
    {
        $this->version = $version;
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @param string $title
     */
    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @param string $description
     */
    public function setDescription(string $description): void
    {
        $this->description = $description;
    }

    /**
     * @return string
     */
    public function getTermsOfService(): string
    {
        return $this->termsOfService;
    }

    /**
     * @param string $termsOfService
     */
    public function setTermsOfService(string $termsOfService): void
    {
        $this->termsOfService = $termsOfService;
    }

    /**
     * @return SwaggerInfoContact
     */
    public function getContact(): SwaggerInfoContact
    {
        return $this->contact;
    }

    /**
     * @param SwaggerInfoContact $contact
     */
    public function setContact(SwaggerInfoContact $contact): void
    {
        $this->contact = $contact;
    }

    /**
     * @return SwaggerInfoLicense
     */
    public function getLicense(): SwaggerInfoLicense
    {
        return $this->license;
    }

    /**
     * @param SwaggerInfoLicense $license
     */
    public function setLicense(SwaggerInfoLicense $license): void
    {
        $this->license = $license;
    }

    /**
     * Specify data which should be serialized to JSON
     * @link https://php.net/manual/en/jsonserializable.jsonserialize.php
     * @return mixed data which can be serialized by <b>json_encode</b>,
     * which is a value of any type other than a resource.
     * @since 5.4.0
     * @throws Exception
     */
    public function jsonSerialize()
    {
        return Response::jsonSerialize($this, [
            'version' => 'getVersion',
            'title' => 'getTitle',
            'description' => 'getDescription',
            'termsOfService' => 'getTermsOfService',
            'contact' =>  'getContact',
            'license' =>  'getLicense'
        ]);
    }
}
