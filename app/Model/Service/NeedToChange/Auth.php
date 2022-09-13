<?php declare(strict_types = 1);

namespace App\Model\Service\NeedToChange;

use App\Model\Database\Entity\UserEntity;
use Doctrine\ORM\EntityManagerInterface;
use Nette\Application\UI\Form;
use Nette\Security\Passwords;


final class Auth
{

	private Passwords $passwords;
	private EntityManagerInterface $entityManager;

	public function __construct(Passwords $passwords, EntityManagerInterface $entityManager)
	{
		$this->passwords = $passwords;
		$this->entityManager = $entityManager;
	}


	public function setNewUser(Form $form): void
	{
		$name = $form->getValues()->name;
		$email = $form->getValues()->email;
		$password = $form->getValues()->password;
		$passwordHash = $this->passwords->hash($password);

		$defaultAdmin = 0;
		$defaultEditor = 0;
		$defaultUser = 1;

		$user = new UserEntity();
		$user->setName($name);
		$user->setEmail($email);
		$user->setPassword($passwordHash);
		$user->setAdminRole($defaultAdmin);
		$user->setEditorRole($defaultEditor);
		$user->setUserRole($defaultUser);
		$this->entityManager->persist($user);
		$this->entityManager->flush();
	}

}