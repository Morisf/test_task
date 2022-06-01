<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Finder\Finder;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $finder = new Finder();
        $finder->in(__DIR__.'/sql');
        $finder->name('data.sql');

        foreach( $finder as $file ){
            $content = $file->getContents();

            $stmt = $manager->getConnection()->prepare($content);
            $stmt->execute();
        }
    }
}
