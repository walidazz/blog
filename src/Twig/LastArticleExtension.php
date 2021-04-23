<?php

namespace App\Twig;

use App\Repository\ArticleRepository;
use App\Repository\CategoryRepository;
use Twig\Environment;
use Twig\TwigFunction;
use Twig\Extension\AbstractExtension;
use Symfony\Contracts\Cache\ItemInterface;
use Symfony\Contracts\Cache\CacheInterface;

class LastArticleExtension extends AbstractExtension
{

    private $cache;
    private $repo;
    private $twig;

    public function __construct(CacheInterface $cache, ArticleRepository $repo, Environment $twig)
    {

        $this->cache = $cache;
        $this->repo = $repo;
        $this->twig = $twig;
    }



    public function getFunctions()
    {
        return [
            //methode appelé par twig
            new TwigFunction('LastArticle', [$this, 'getLastArticle'], ['is_safe' => ['html']])
        ];
    }

    //  $data = $this->cache->get('homepage', function (ItemInterface $item) {
    //    $item->expiresAfter(24 * 3600);


    public function getLastArticle()
    {

        return $this->cache->get('LastArticles', function (ItemInterface $item) {
            $item->expiresAfter(24 * 3600);

            return $this->getRenderLastArticle();
        });
    }




    private function  getRenderLastArticle()
    {

        $threeLastArticles = $this->repo->findThreeLastArticles();

        return $this->twig->render('shared/_lastArticles.html.twig', [
            'threeLastArticles' => $threeLastArticles

        ]);
    }
}
