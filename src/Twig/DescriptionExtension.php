<?php

namespace App\Twig;

use App\Repository\ArticleRepository;
use App\Repository\CategoryRepository;
use Twig\Environment;
use Twig\TwigFunction;
use Twig\Extension\AbstractExtension;
use Symfony\Contracts\Cache\ItemInterface;
use Symfony\Contracts\Cache\CacheInterface;

class DescriptionExtension extends AbstractExtension
{

    private $cache;
    private $twig;

    public function __construct(CacheInterface $cache, Environment $twig)
    {

        $this->cache = $cache;
        $this->twig = $twig;
    }



    public function getFunctions()
    {
        return [
            //methode appelé par twig
            new TwigFunction('Description', [$this, 'getDescription'], ['is_safe' => ['html']])
        ];
    }

    //  $data = $this->cache->get('homepage', function (ItemInterface $item) {
    //    $item->expiresAfter(24 * 3600);


    public function getDescription()
    {

        return $this->cache->get('Description', function (ItemInterface $item) {
            $item->expiresAfter(24 * 3600);

            return $this->getRenderDescription();
        });
    }




    private function  getRenderDescription()
    {


        return $this->twig->render('shared/_description.html.twig');
    }
}
