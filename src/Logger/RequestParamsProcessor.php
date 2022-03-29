<?php

namespace App\Logger;

use Monolog\Processor\ProcessorInterface;
use Symfony\Component\HttpFoundation\RequestStack;

/**
 * Add request parameters into log
 * Class RequestProcessor
 * @package App\Logger
 */
class RequestParamsProcessor implements ProcessorInterface
{
    private $requestStack;

    public function __construct(
        RequestStack $requestStack
    )
    {
        $this->requestStack = $requestStack;
    }

    public function __invoke(array $record): array
    {
        $request = $this->requestStack->getMainRequest();
        if (! $request) {
            return $record;
        }

        $contentType = $request->getContentType();

        $requestParameters = null;
        if ('form' === $contentType) {
            $requestParameters = $request->request->all();
        } elseif ('json' === $contentType) {
            $requestParameters = json_decode($request->getContent(), true);
        } else {
            $requestParameters = $request->getContent();
        }

        $record['context']['request_parameters'] = $requestParameters;

        return $record;
    }
}
