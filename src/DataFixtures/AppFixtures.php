<?php

namespace App\DataFixtures;

use App\Entity\User;
use App\Entity\Article;
use App\Entity\Category;
use App\Entity\Comments;
use Cocur\Slugify\Slugify;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoder;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AppFixtures extends Fixture
{

    private $encoder;

    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }
    public function load(ObjectManager $manager)
    {

        $slugify = new Slugify();
        // $product = new Product();
        // $manager->persist($product);
        $admin = new User();
        $admin->setEmail('walidazzimani@gmail.com')
            ->setPassword($this->encoder->encodePassword($admin, 'sharingan.'))
            ->setRoles(['ROLE_ADMIN']);
        $manager->persist($admin);



        $tabCategory = ['Actualité', 'Developpement', 'Jeux-Vidéos'];

        for ($i = 0; $i < count($tabCategory); $i++) {
            $category = new Category();
            $category->setLibelle($tabCategory[0 + $i]);
            $manager->persist($category);
        }

        for ($j = 1; $j < 11; $j++) {
            # code...
            $article = new Article();
            $article->setTitre('article numéro ' . $j)
                ->setContent('Lorem ipsum, dolor sit amet consectetur adipisicing elit. Veritatis explicabo, nesciunt distinctio ratione facilis,         Lorem ipsum dolor, sit amet consectetur adipisicing elit. Asperiores ratione, velit ducimus sunt praesentium voluptatum animi! Aut explicabo atque, corporis, molestias officiis numquam quam reprehenderit rerum voluptas illo suscipit itaque?
                doloribus eius nisi nostrum voluptas earum quasi         Lorem ipsum dolor, sit amet consectetur adipisicing elit. Asperiores ratione, velit ducimus sunt praesentium voluptatum animi! Aut explicabo atque, corporis, molestias officiis numquam quam reprehenderit rerum voluptas illo suscipit itaque?
                Lorem ipsum dolor, sit amet consectetur adipisicing elit. Asperiores ratione, velit ducimus sunt praesentium voluptatum animi! Aut explicabo atque, corporis, molestias officiis numquam quam reprehenderit rerum voluptas illo suscipit itaque?
                Lorem ipsum dolor, sit amet consectetur adipisicing elit. Asperiores ratione, velit ducimus sunt praesentium voluptatum animi! Aut explicabo atque, corporis, molestias officiis numquam quam reprehenderit rerum voluptas illo suscipit itaque?
                eaque quam! Omnis officiis quae id beatae voluptatem voluptas.
            ')
                ->setCoverImage('symfony.png')
                ->setReadTime(mt_rand(1, 10))
                ->setCreatedAt(new \DateTime('now'))
                ->setSlug($slugify->slugify($article->getTitre()))
                ->setCategory($category);
            $manager->persist($article);
        }

        $comment = new Comments();
        $comment->setEmail('test@gmail.com')
            ->setPseudo('test@gmail.com')
            ->setActive(true)
            ->setContent('Lorem ipsum dolor, sit amet consectetur         Lorem ipsum dolor, sit amet consectetur adipisicing elit. Asperiores ratione, velit ducimus sunt praesentium voluptatum animi! Aut explicabo atque, corporis, molestias officiis numquam quam reprehenderit rerum voluptas illo suscipit itaque?
            Lorem ipsum dolor, sit amet consectetur adipisicing elit. Asperiores ratione, velit ducimus sunt praesentium voluptatum animi! Aut explicabo atque, corporis, molestias officiis numquam quam reprehenderit rerum voluptas illo suscipit itaque?
            adipisicing elit. Asperiores ratione, velit ducimus sunt praesentium voluptatum animi! Aut explicabo atque, corporis, molestias officiis numquam quam reprehenderit rerum voluptas illo suscipit itaque?
        ')
            ->setArticle($article)
            ->setCreatedAt(new \DateTime('now'));
        $manager->persist($article);

        $manager->flush();
    }
}
