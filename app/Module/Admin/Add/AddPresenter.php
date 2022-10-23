<?php declare(strict_types=1);

namespace App\Module\Admin\Add;

use App\Model\Database\Entity\ActorEntity;
use App\Model\Database\Entity\ArticleEntity;
use App\Model\Database\Entity\MovieEntity;
use App\Model\Database\Entity\SerialEntity;
use App\Model\Facade\Front\Auth\AuthorizationFacade;
use App\Module\Admin\AdminPresenter;
use Doctrine\ORM\EntityManagerInterface;
use Nette\Application\UI\Form;
use Nette\Utils\Strings;

class AddPresenter extends AdminPresenter
{

    private EntityManagerInterface $entityManager;

	public function __construct(
		EntityManagerInterface $entityManager,
		AuthorizationFacade $authorizationFacade
	)
    {
        parent::__construct($authorizationFacade);
        $this->entityManager = $entityManager;
	}

    public function createComponentMovie(): Form
    {
        $form = new Form();
        $form->addText("name", "Přidat název");
        $form->addTextArea("description", "Přidat popis");
        $form->addSubmit("sent", "Odeslat");
        $form->addHidden("from", "movie");
        $form->onSubmit[] = [$this, "onSuccess"];
        return $form;
    }

    public function createComponentSerial(): Form
    {
        $form = new Form();
        $form->addText("name", "Přidat název");
        $form->addTextArea("description", "Přidat popis");
        $form->addSubmit("sent", "Odeslat");
        $form->addHidden("from", "serial");
        $form->onSubmit[] = [$this, "onSuccess"];
        return $form;
    }

    public function createComponentBlog(): Form
    {
        $form = new Form();
        $form->addText("name", "Přidat název");
        $form->addTextArea("description", "Přidat popis");
        $form->addSubmit("sent", "Odeslat");
        $form->addHidden("from", "blog");
        $form->onSubmit[] = [$this, "onSuccess"];
        return $form;
    }

    public function createComponentActor(): Form
    {
        $form = new Form();
        $form->addText("name", "Přidat název");
        $form->addSubmit("sent", "Odeslat");
        $form->addHidden("from", "actors");
        $form->onSubmit[] = [$this, "onSuccess"];
        return $form;
    }

    public function onSuccess(Form $form): void
    {
        if($form->getValues()->from == "movie")
        {
            if($form->getValues()->name == "")
            {
                $this->flashMessage("Prosím vyplňte název", "warning");
            }
            else if($form->getValues()->description == "")
            {
                $this->flashMessage("Prosím vyplňte popis", "warning");
            }
            else
            {
                $user = new MovieEntity();
                $user->setName($form->getValues()->name);
                $user->setSlug(Strings::webalize($form->getName()));
                $user->setDescription($form->getValues()->description);
                $this->entityManager->persist($user);
                $this->entityManager->flush();

                $this->flashMessage("Úspěšně přidáno", "success");
                $this->redirect(":Admin:Homepage:");
            }
        }
        if($form->getValues()->from == "serials")
        {
            if($form->getValues()->name == "")
            {
                $this->flashMessage("Prosím vyplňte název", "warning");
            }
            else if($form->getValues()->description == "")
            {
                $this->flashMessage("Prosím vyplňte popis", "warning");
            }
            else
            {
                $user = new SerialEntity();
                $user->setName($form->getValues()->name);
                $user->setSlug(Strings::webalize($form->getName()));
                $user->setDescription($form->getValues()->description);
                $this->entityManager->persist($user);
                $this->entityManager->flush();

                $this->flashMessage("Úspěšně přidáno", "success");
                $this->redirect(":Admin:Homepage:");
            }
        }
        if($form->getValues()->from == "blog")
        {
            if($form->getValues()->name == "")
            {
                $this->flashMessage("Prosím vyplňte název", "warning");
            }
            else if($form->getValues()->description == "")
            {
                $this->flashMessage("Prosím vyplňte popis", "warning");
            }
            else
            {
                $user = new ArticleEntity();
                $user->setName($form->getValues()->name);
                $user->setSlug(Strings::webalize($form->getName()));
                $user->setDescription($form->getValues()->description);
                $this->entityManager->persist($user);
                $this->entityManager->flush();

                $this->flashMessage("Úspěšně přidáno", "success");
                $this->redirect(":Admin:Homepage:");
            }
        }
        if($form->getValues()->from == "actors")
        {
            if($form->getValues()->name == "")
            {
                $this->flashMessage("Prosím vyplňte název", "warning");
            }
            else if($form->getValues()->description == "")
            {
                $this->flashMessage("Prosím vyplňte popis", "warning");
            }
            else
            {
                $user = new ActorEntity();
                $user->setName($form->getValues()->name);
                $user->setSlug(Strings::webalize($form->getName()));
                $this->entityManager->persist($user);
                $this->entityManager->flush();

                $this->flashMessage("Úspěšně přidáno", "success");
                $this->redirect(":Admin:Homepage:");
            }
        }
    }
}
