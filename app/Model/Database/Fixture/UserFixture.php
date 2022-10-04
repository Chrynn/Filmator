<?php declare(strict_types = 1);

namespace App\Model\Database\Fixture;

use App\Model\Database\Entity\UserEntity;
use Doctrine\Persistence\ObjectManager;
use Nette\Neon\Neon;
use Nette\Security\Passwords;
use Nettrine\Fixtures\ContainerAwareInterface;

final class UserFixture extends AbstractFixture implements ContainerAwareInterface
{

	public function load(ObjectManager $manager): void
	{
		$users = Neon::decodeFile(__DIR__ . '/content/user.neon');

		foreach ($users as $user) {
			$newUser = new UserEntity();
			$newUser->setNickname($user['nickname']);
			$newUser->setEmail($user['email']);

			$passwords = new Passwords();
			$passwordHash = $passwords->hash($user['password']);

			$newUser->setConditions($user['conditions']);
			$newUser->setNewsletter($user['newsletter']);

			$newUser->setPassword($passwordHash);
			$newUser->setRole($user['role']);
			$manager->persist($newUser);
		}
		$manager->flush();
	}

}
