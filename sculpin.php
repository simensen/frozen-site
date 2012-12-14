<?php

require_once __DIR__.'/vendor/autoload.php';

// Get the Silex application (HttpKernelInterface)
$app = require_once('app.php');

// Helper
$filesystem = new Symfony\Component\Filesystem\Filesystem;

// Sculpin dependencies
$siteConfiguration = new Dflydev\DotAccessConfiguration\Configuration;
$eventDispatcher = new Symfony\Component\EventDispatcher\EventDispatcher;
$permalinkFactory = new Sculpin\Core\Permalink\SourcePermalinkFactory('stupid default required param');
$writer = new Sculpin\Core\Output\FilesystemWriter($filesystem, 'output');
$generatorManager = new Sculpin\Core\Generator\GeneratorManager($eventDispatcher, $siteConfiguration);
$formatterManager = new Sculpin\Core\Formatter\FormatterManager($eventDispatcher, $siteConfiguration);
$converterManager = new Sculpin\Core\Converter\ConverterManager($eventDispatcher, $formatterManager);

// Sculpin
$sculpin = new Sculpin\Core\Sculpin(
    $siteConfiguration,
    $eventDispatcher,
    $permalinkFactory,
    $writer,
    $generatorManager,
    $formatterManager,
    $converterManager
);

// Required for running
$dataSource = new Dflydev\FrozenSite\HttpKernelDataSource($app);
$sourceSet = new Sculpin\Core\Source\SourceSet;

// Run
$sculpin->run($dataSource, $sourceSet);

// Site will live as static HTML under 'output' directory
