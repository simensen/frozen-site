<?php

namespace Dflydev\FrozenSite;

use Sculpin\Core\Source\DataSourceInterface;
use Sculpin\Core\Source\SourceSet;
use Symfony\Component\HttpKernel\HttpKernelInterface;
use Symfony\Component\HttpKernel\Client;

class HttpKernelDataSource implements DataSourceInterface
{
    public function __construct(HttpKernelInterface $httpKernel)
    {
        $this->httpKernel = $httpKernel;
    }

    public function dataSourceId()
    {
        return 'HttpKernel';
    }

    public function refresh(SourceSet $sourceSet)
    {
        $client = new Client($this->httpKernel);

        $client->request('GET', '/');

        $source = new HttpSource($this, $client->getRequest(), $client->getResponse());
        $sourceSet->mergeSource($source);
    }
}
