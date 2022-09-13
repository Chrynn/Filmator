<?php declare(strict_types = 1);

namespace App\Model\Database\Fixture;

use App\Model\Database\Entity\UserEntity;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Nette\Security\Passwords;


final class UserFixture implements FixtureInterface
{

	public function load(ObjectManager $manager)
	{
		$users = [
			[
				'name' => 'Pepa',
				'email' => '123@gmail.com',
				'password' => 'bengoro',
				'admin' => 1,
				'editor' => 1,
				'user' => 1,
			],
			[
				'name' => 'Mike',
				'email' => 'hello@gmail.com',
				'password' => '123',
				'admin' => 0,
				'editor' => 0,
				'user' => 1,
			],
		];
		foreach ($users as $user) {
			$newUser = new UserEntity();
			$newUser->setName($user['name']);
			$newUser->setEmail($user['email']);

			$passwords = new Passwords();
			$passwordHash = $passwords->hash($user['password']);

			$newUser->setPassword($passwordHash);
			$newUser->setAdminRole($user['admin']);
			$newUser->setEditorRole($user['editor']);
			$newUser->setUserRole($user['user']);
			$manager->persist($newUser);
		}
		$manager->flush();
	}

}

