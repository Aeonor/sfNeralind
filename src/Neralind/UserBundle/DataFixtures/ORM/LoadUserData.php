<?php
// src/Regenere/UserBundle/DataFixtures/ORM/LoadUserData.php

namespace Regenere\BlogBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;


class LoadUserData extends AbstractFixture implements ContainerAwareInterface, OrderedFixtureInterface
{
    private $container;
    
    /**
     * {@inheritDoc}
     */
    public function getOrder()
    {
        return 1; 
    }
    
    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }
    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {

        $userManager = $this->container->get('fos_user.user_manager');

        $userAdmin = $userManager->createUser();
        $userAdmin->setUsername('aeonor');
        $userAdmin->setEmail('aeonor@neralind.com');
        $userAdmin->setPlainPassword('test');
        $userAdmin->setRoles(array('ROLE_ADMIN'));
        $userAdmin->setEnabled(true);

        $dede = $userManager->createUser();
        $dede->setUsername('dede');
        $dede->setEmail('dede@neralind.com');
        $dede->setPlainPassword('test');
        $dede->setRoles(array('ROLE_ADMIN'));
        $dede->setEnabled(true);

        $userManager->updateUser($userAdmin, true);
        $userManager->updateUser($dede, true);

    }
}