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
     * @return string|null
     */
    public function simpleAnnotationToString(string $annotation, string $tag): ?string
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
     * @param callable $func
     * @return string[]|null
     */
    public function simpleAnnotationToArray(string $annotation, string $tag, callable $func = null): ?array
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
     * @param callable $func
     * @return \stdClass[]
     * @throws \Exception
     */
    public function complexAnnotationToArrayJSON(string $annotation, string $tag, callable $func = null): array
    {
        $array = [];
        $loop = $this->enumeratePregResult($annotation, $tag);

        for ($i = 0; $i < count($loop); $i++) {
            $array[] = $this->complexAnnotationToJSON($annotation, $tag);
            $annotation = preg_replace('/@' . $tag . '/', '', $annotation, 1);
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
     * @throws \Exception
     */
    public function complexAnnotationToJSON(string $annotation, string $tag): \stdClass
    {

        $pregResult = null;
        $strSearch = ['(', ')', '=', ',', '*', '\\'];
        $strReplace = ['":{"', '}', '":', ',"', '', '\\\\'];

        $pregResult = $this->pregMatchComplexAnnotation($annotation, $tag);

        if (!$pregResult) {
            return null;
        }

        $json = preg_replace('/":/', '', str_replace($strSearch, $strReplace, $pregResult[1]), 1);

        $std = json_decode(preg_replace('/@|\s/', '', $json));

        if (!$std) {
            throw new \Exception('Bad documentation. Check PHPDoc in tag ' . $tag . '.');
        }

        return $std;
    }

    /**
     * @param string $annotation
     * @param string $tag
     * @param string|null $closePar
     * @return array|null
     */
    private function pregMatchComplexAnnotation(string $annotation, string $tag, string $closePar = null): array
    {
        $pattern = '/@' . $tag . '(\([^)]*\)' . $closePar . ')/';

        preg_match($pattern, $annotation, $pregResult);

        if (!$pregResult) {
            return null;
        }

        $open = substr_count($pregResult[0], '(');
        $close = substr_count($pregResult[0], ')');

        if ($open > $close) {
            $closePar = str_repeat('[^)]*\)', $open - $close);
            $pregResult = $this->pregMatchComplexAnnotation($annotation, $tag, $closePar);
        }

        return $pregResult;
    }

    /**
     * @param string $code
     * @param string $annotationStr
     * @param Swagger $swagger
     * @return \stdClass
     * @throws \ReflectionException
     * @throws \Exception
     */
    public function responses(string $code, string $annotationStr, Swagger $swagger): \stdClass
    {
        $responses = new \stdClass();
        $pregResult = null;
        $responsesDoc = $this->complexAnnotationToArrayJSON($annotationStr, 'response');

        if (!$responsesDoc) {
            $responsesDoc = [];
        }

        foreach ($responsesDoc as $res) {
            $obj = new \stdClass();
            $obj->description = $res->description;
            $responses->{$res->code} = $obj;
        }

        preg_match_all('/Response::([A-Z\_]+)/', $code, $pregResult);

        $reflection = new Annotation(Response::class);

        if ($pregResult) {
            foreach ($pregResult[1] as $res) {
                $obj = new \stdClass();
                $code = $reflection->getConstant($res);

                if (isset($responses->{$code})) {
                    continue;
                }

                $constant = $reflection->getReflectionConstant($res);

                $swaggerDesc = $swagger->defaultResponsesDescription();

                if (isset($swaggerDesc[$code])) {
                    $obj->description = $swaggerDesc[$code];
                } else {
                    $obj->description = trim(preg_replace(['/\s\s+/', '/\/\*+/'], '', $constant->getDocComment()));
                }
                $responses->{$code} = $obj;
            }
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

    /**
     * @param string $annotation
     * @param string $tag
     * @return array
     */
    private function enumeratePregResult(string $annotation, string $tag): array
    {
        $pregResult = null;
        preg_match_all('/@' . $tag . '(\([^)]*\))/', $annotation, $pregResult);

        if (!$pregResult) {
            return [];
        }
        return $pregResult[0];
    }
}
