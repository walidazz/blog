<?php

namespace App\Twig;


use App\Repository\CategoryRepository;
use Twig\Environment;
use Twig\TwigFunction;
use Twig\Extension\AbstractExtension;
use Symfony\Contracts\Cache\ItemInterface;
use Symfony\Contracts\Cache\CacheInterface;

class NavbarExtension extends AbstractExtension
{

    private $cache;
    private $repo;
    private $twig;

    public function __construct(CacheInterface $cache, CategoryRepository $repo, Environment $twig)
    {

        $this->cache = $cache;
        $this->repo = $repo;
        $this->twig = $twig;
    }



    public function getFunctions()
    {
        return [
            //methode appelé par twig
            new TwigFunction('navbar', [$this, 'getNavbar'], ['is_safe' => ['html']])
        ];
    }

    //  $data = $this->cache->get('homepage', function (ItemInterface $item) {
    //    $item->expiresAfter(24 * 3600);


    public function getNavbar()
    {

        return $this->cache->get('navbar', function (ItemInterface $item) {
            $item->expiresAfter(24 * 3600);

            return $this->getRenderNavbar();
        });
    }




    private function  getRenderNavbar()
    {

        $cat = $this->repo->findAll();


        return $this->twig->render('shared/_navbar.html.twig', [
            'categories' => $cat,

        ]);
    }
}
