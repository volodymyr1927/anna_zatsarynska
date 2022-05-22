<?php

namespace App\DataFixtures;

use App\Entity\MenuItems;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class MenuItemsFixture extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $instagramItem = new MenuItems();
        $instagramItem->setItemName('Instagram');
        $instagramItem->setItemLink('https://instagram.com/ann_zatsarinskaya?igshid=YmMyMTA2M2Y=');
        $instagramItem->setActive(1);
        $instagramItem->setItemOrder(3);
        $instagramItem->setCreatedAt(new \DateTime());
        $instagramItem->setUpdatedAt(new \DateTime());
        $manager->persist($instagramItem);
        $manager->flush();

        $price = new MenuItems();
        $price->setItemName('For Clients');
        $price->setItemLink('for-clients');
        $price->setActive(1);
        $price->setItemOrder(2);
        $price->setCreatedAt(new \DateTime());
        $price->setUpdatedAt(new \DateTime());
        $manager->persist($price);
        $manager->flush();

        $aboutMe = new MenuItems();
        $aboutMe->setItemName('About Me');
        $aboutMe->setItemLink('about-me');
        $aboutMe->setActive(1);
        $aboutMe->setItemOrder(1);
        $aboutMe->setCreatedAt(new \DateTime());
        $aboutMe->setUpdatedAt(new \DateTime());
        $manager->persist($aboutMe);
        $manager->flush();
    }
}