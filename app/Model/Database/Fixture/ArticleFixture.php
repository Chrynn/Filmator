<?php declare(strict_types = 1);

namespace App\Model\Database\Fixture;

use App\Model\Database\Entity\ArticleEntity;
use App\Model\Facade\Month\MonthFacade;
use Doctrine\Persistence\ObjectManager;
use Nette\Neon\Neon;
use Nette\Utils\Strings;
use Nettrine\Fixtures\ContainerAwareInterface;


final class ArticleFixture extends AbstractFixture implements ContainerAwareInterface
{

	public function getMonthFacade(): MonthFacade
	{
		return $this->getContainer()->getByType(MonthFacade::class);
	}


	public function load(ObjectManager $manager): void
	{
		$articles = Neon::decodeFile(__DIR__ . "/content/article.neon");
		$timeNow = new \DateTime('now');

		foreach ($articles as $article) {
			$newArticle = new ArticleEntity();
			$newArticle->setName($article['title']);
			$newArticle->setSlug(Strings::webalize($article['title']));
			$newArticle->setDescription($article['description']);
			$newArticle->setImage($article['image']);
			$newArticle->setCreatedAt($timeNow);
			$newArticle->setCreatedAtMonth($this->getMonthFacade()->getMonth($timeNow));
			$manager->persist($newArticle);
		}
		$manager->flush();
	}

}
