<?php declare(strict_types = 1);

namespace App\Model\Service\User;

use App\Model\Database\Entity\ActorEntity;
use App\Model\Database\Entity\UserEntity;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Mapping\Entity;
use Nette\Application\UI\Form;
use Nette\Security\Passwords;


final class UserService
{

	private const DEFAULT_ADMIN = 0;
	private const DEFAULT_EDITOR = 0;
	private const DEFAULT_USER = 1;

	private Passwords $passwords;
	private EntityManagerInterface $entityManager;


	public function __construct(Passwords $passwords, EntityManagerInterface $entityManager)
	{
		$this->passwords = $passwords;
		$this->entityManager = $entityManager;
	}


	public function add(Form $form): void
	{
		$values = $form->getValues();
		$nickname = $values->nickname;
		$email = $values->email;
		$password = $values->password;
		$passwordHash = $this->passwords->hash($password);
		$conditions = $values->conditions;
		$newsletter = $values->newsletter;

		$defaultAdmin = self::DEFAULT_ADMIN;
		$defaultEditor = self::DEFAULT_EDITOR;
		$defaultUser = self::DEFAULT_USER;

		$user = new UserEntity();
		$user->setNickname($nickname);
		$user->setEmail($email);
		$user->setPassword($passwordHash);
		$user->setConditions($conditions);
		$user->setNewsletter($newsletter);
		$user->setAdminRole($defaultAdmin);
		$user->setEditorRole($defaultEditor);
		$user->setUserRole($defaultUser);
		$this->entityManager->persist($user);
		$this->entityManager->flush();
	}


	public function edit(): void
	{
	}


	public function getUserByNickname(string $nickname): ?UserEntity
	{
		return $this->entityManager->getRepository(UserEntity::class)->findOneBy([
			"nickname" => $nickname,
		]);
	}


	public function getUserByEmail(string $email): ?UserEntity
	{
		return $this->entityManager->getRepository(UserEntity::class)->findOneBy([
			"email" => $email,
		]);
	}

}
