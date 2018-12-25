<?php
/**
 * Created by PhpStorm.
 * User: Dionisio Gabriel Rigo de Souza Machado (https://github.com/diomac)
 * Date: 19/10/2018
 * Time: 10:37
 */

namespace Diomac\API;

/**
 * Class Annotation
 * @package Diomac\API
 */
class Annotation extends \ReflectionClass
{
    /**
     * Annotation constructor.
     * @param null $class
     * @throws \ReflectionException
     */
    public function __construct($class = null)
    {
        if ($class) {
            parent::__construct($class);
        } else {
            parent::__construct(self::class);
        }
    }

    /**
     * @param string $annotation
     * @param string $tag
     * @return null|string
     */
    public function simpleAnnotationToString(string $annotation, string $tag)
    {
        $pregResult = null;

        preg_match('/@' . $tag . ' (.*)/', $annotation, $pregResult);

        if (!$pregResult) {
            return null;
        }

        return trim($pregResult[1]);
    }

    /**
     * @param string $annotation
     * @param string $tag
     * @param null $func
     * @return array|null
     */
    public function simpleAnnotationToArray(string $annotation, string $tag, $func = null)
    {
        $pregResult = null;

        preg_match_all('/@' . $tag . ' (.*)/', $annotation, $pregResult);

        if (!$pregResult) {
            return null;
        }

        if ($func) {
            return array_map($func, $pregResult[1]);
        }

        return $pregResult[1];
    }

    /**
     * @param string $annotation
     * @param string $tag
     * @param null $func
     * @return array|null
     */
    public function complexAnnotationToArrayJSON(string $annotation, string $tag, $func = null)
    {
        $pregResult = null;
        $array = [];

        preg_match_all('/(@' . $tag . '\([\S\s]*?\*[ ]*\))/', $annotation, $pregResult);

        if (!$pregResult) {
            return null;
        }

        foreach ($pregResult[0] as $a) {
            $array[] = $this->complexAnnotationToJSON($a, $tag);
        }

        if ($func) {
            return array_map($func, $array);
        }

        return $array;
    }

    /**
     * @param string $annotation
     * @param string $tag
     * @return mixed|null|\stdClass
     */
    public function complexAnnotationToJSON(string $annotation, string $tag)
    {

        $pregResult = null;
        $strSearch = ['(', ')', '=', ',', '*'];
        $strReplace = ['{"', '"}', '":', ',"', ''];

        preg_match('/@' . $tag . '\(([\S\s]*)\)/', $annotation, $pregResult);

        if (!$pregResult) {
            return null;
        }

        $outersTag = explode(',', $pregResult[1]);
        $outersJson = [];
        $remountAnnotation = [];

        foreach ($outersTag as $k => $a) {
            $tagName = null;
            preg_match('/@([\S\s]*?)\(/', $a, $tagName);

            if ($tagName) {
                $outersJson[] = [
                    'tag' => $tagName[1],
                    'annotation' => $a
                ];
            } else {
                $remountAnnotation[] = $a;
            }
        }

        $str = implode(',', $remountAnnotation);

        if ($str) {
            $replaced = str_replace($strSearch, $strReplace, $str);
            $replacedLines = trim(preg_replace('/\s\s+/', ' ', $replaced));
            $json = json_decode('{"' . str_replace('," ', ',"', $replacedLines) . '}');
        } else {
            $json = new \stdClass();
        }

        foreach ($outersJson as $j) {
            $json->{trim($j['tag'])} = $this->complexAnnotationToJSON($j['annotation'], $j['tag']);
        }

        return $json;
    }

    /**
     * @param string $code
     * @param string $annotationStr
     * @param Swagger $swagger
     * @return \stdClass
     * @throws \ReflectionException
     */
    public function responses(string $code, string $annotationStr, Swagger $swagger)
    {
        $responses = new \stdClass();
        $pregResult = null;
        $responsesDoc = $this->complexAnnotationToArrayJSON($annotationStr, 'response');

        if (!$responsesDoc) {
            $responsesDoc = [];
        }

        preg_match_all('/Response::([A-Z\_]+)/', $code, $pregResult);

        $reflection = new Annotation('Diomac\\API\\Response');

        if ($pregResult) {
            foreach ($pregResult[1] as $res) {
                $obj = new \stdClass();
                $obj->code = $reflection->getConstant($res);
                $constant = $reflection->getReflectionConstant($res);

                $swaggerDesc = $swagger->defaultResponsesDescription();

                if (isset($swaggerDesc[$obj->code])) {
                    $obj->description = $swaggerDesc[$obj->code];
                } else {
                    $obj->description = trim(preg_replace(['/\s\s+/', '/\/\*+/'], '', $constant->getDocComment()));
                }
                $responsesDoc[] = $obj;
            }
        }

        foreach ($responsesDoc as $res) {
            $obj = new \stdClass();
            $obj->description = $res->description;
            $responses->{$res->code} = $obj;
        }

        return $responses;
    }

    /**
     * @param \ReflectionMethod $func
     * @return string
     */
    public function getCodeFunctionString(\ReflectionMethod $func): string
    {
        $filename = $func->getFileName();
        $start_line = $func->getStartLine() - 1;
        $end_line = $func->getEndLine();
        $length = $end_line - $start_line;

        $source = file($filename);

        return implode("", array_slice($source, $start_line, $length));
    }
}