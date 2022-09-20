<?php declare(strict_types = 1);

namespace App\Model\Database\Fixture;

use App\Model\Database\Entity\UserEntity;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Nette\Neon\Neon;
use Nette\Security\Passwords;


final class UserFixture implements FixtureInterface
{

	public function load(ObjectManager $manager): void
	{
		$users = Neon::decodeFile(__DIR__ . "/content/user.neon");

		foreach ($users as $user) {
			$newUser = new UserEntity();
			$newUser->setName($user['name']);
			$newUser->setEmail($user['email']);

			$passwords = new Passwords();
			$passwordHash = $passwords->hash($user['password']);

			$newUser->setPassword($passwordHash);
			foreach ($user['right'] as $role => $value) {
				if ($role === 'admin') {
					$newUser->setAdminRole($value);
				}
				if ($role === 'editor') {
					$newUser->setEditorRole($value);
				}
				if ($role === 'user') {
					$newUser->setUserRole($value);
				}
			}
			$manager->persist($newUser);
		}
		$manager->flush();
	}

}

