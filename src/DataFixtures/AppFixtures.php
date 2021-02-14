<?php

namespace App\DataFixtures;

use App\Entity\Product;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Faker\Factory;

/**
 * Class AppFixtures
 * @package App\DataFixtures
 */
class AppFixtures extends Fixture
{
    /**
     * @var UserPasswordEncoderInterface
     */
    private UserPasswordEncoderInterface $userPasswordEncoder;

    /**
     * AppFixtures constructor.
     * @param UserPasswordEncoderInterface $userPasswordEncoder
     */
    public function __construct(UserPasswordEncoderInterface $userPasswordEncoder)
    {
        $this->userPasswordEncoder = $userPasswordEncoder;
    }

    /**
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $users = [];
        $faker = Factory::create('de_DE');
        for ($i = 1; $i <= 10; $i++) {
            $user = User::create(
                sprintf("email+%d@email.com", $i),
                sprintf("name+%d", $i)
            );
            $user->setPassword($this->userPasswordEncoder->encodePassword($user, "password"));
            $manager->persist($user);

            $users[] = $user;
        }
        
        foreach ($users as $user) {
            for ($j = 1; $j <= 5; $j++) {
                $product = Product::create(
                    $faker->text(10),
                    $faker->text(50),
                    random_int(5, 50),
                    random_int(100, 250),
                    $user
                );
                shuffle($users);
                $manager->persist($product);
            }
        }

        $manager->flush();
    }
}
