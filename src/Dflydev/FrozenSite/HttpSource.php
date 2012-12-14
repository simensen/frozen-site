<?php

namespace Dflydev\FrozenSite;

use Dflydev\DotAccessConfiguration\Configuration as Data;
use Sculpin\Core\Source\AbstractSource;
use Sculpin\Core\Source\DataSourceInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class HttpSource extends AbstractSource
{
    public function __construct(DataSourceInterface $dataSource, Request $request, Response $response)
    {
        $this->sourceId = 'HttpResponseSource:'.$dataSource->dataSourceId().':'.$request->getRequestUri();
        $this->relativePathname = rtrim($request->getPathInfo(), '/');
        $this->filename = $request->getRequestUri();
        $this->isRaw = true; // we are always raw files
        $this->hasChanged = true; // based off of some other means
        $this->init();

        if (!$this->relativePathname) {
            $this->relativePathname = 'index.html';
        }

        $this->response = $response;
    }
    public function init($hasChanged = null)
    {
        parent::init($hasChanged);

        $this->data = new Data;
    }
    public function content()
    {
        return $this->response->getContent();
    }
}
