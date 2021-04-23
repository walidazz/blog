<?php

namespace App\Twig;


use App\Repository\CategoryRepository;
use Twig\Environment;
use Twig\TwigFunction;
use Twig\Extension\AbstractExtension;
use Symfony\Contracts\Cache\ItemInterface;
use Symfony\Contracts\Cache\CacheInterface;

class SidebarExtension extends AbstractExtension
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
            new TwigFunction('sidebar', [$this, 'getSidebar'], ['is_safe' => ['html']])
        ];
    }

    //  $data = $this->cache->get('homepage', function (ItemInterface $item) {
    //    $item->expiresAfter(24 * 3600);


    public function getSidebar()
    {

        return $this->cache->get('sidebar', function (ItemInterface $item) {
            $item->expiresAfter(24 * 3600);

            return $this->getRenderSidebar();
        });
    }




    private function  getRenderSidebar()
    {

        $cat = $this->repo->findAll();


        return $this->twig->render('shared/_sidebar.html.twig', [
            'categories' => $cat,
        
        ]);
    }
}
