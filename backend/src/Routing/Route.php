<?php

namespace Bm\Store\Routing;

class Route
{
    public function __construct(
        public string $uri,
        public string $httpMethod,
        public string $controller,
        public array $params = []
    ) {
    }

    private function getUri()
    {
        if (str_contains($this->uri, '(:id)')) {
            $this->uri = str_replace('(:id)', '[0-9]+', $this->uri);
        }

        return $this->uri;
    }

    private function getPattern()
    {
        return str_replace('/', '\/', ltrim($this->getUri(), '/'));
    }

    private function currentUri()
    {
        return $_SERVER['REQUEST_URI'] !== '/'
            ? rtrim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/')
            : '/';
    }

    private function currentHttpMethod()
    {
        return strtolower($_SERVER['REQUEST_METHOD']);
    }

    public function match()
    {
        $pattern = $this->getPattern();
        if (
            preg_match("/^$pattern$/", ltrim($this->currentUri(), '/')) &&
            strtolower($this->httpMethod) === $this->currentHttpMethod()
        ) {
            $explodeUri = explode('/', ltrim($this->currentUri(), '/'));
            $explodePattern = explode('/', ltrim($this->uri, '/'));
            $diff = array_diff($explodeUri, $explodePattern);

            foreach ($diff as $key => $value) {
                $this->params[$explodeUri[$key - 1]] = is_numeric($value) ? (int) $value : $value;
            }
            
            return $this;
        }
    }
}
