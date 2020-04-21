<?php

namespace HttpClient\Plugin;

use Composer\Plugin\PluginInterface;
use Composer\Composer;
use Composer\EventDispatcher\EventSubscriberInterface;
use Composer\IO\IOInterface;

class Plugin implements PluginInterface, EventSubscriberInterface
{
    public function activate(Composer $composer, IOInterface $io)
    {
        //
    }

    public static function getSubscribedEvents()
    {
        return [
            'post-autoload-dump' => 'postAutoloadDump',
        ];
    }

    public function postAutoloadDump($event)
    {
        $manifest = new PackageManifest(
            rtrim($event->getComposer()->getConfig()->get('vendor-dir'), '/')
        );

        $manifest->unlink()->build();
    }
}
