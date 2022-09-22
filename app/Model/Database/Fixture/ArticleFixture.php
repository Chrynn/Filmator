<?php declare(strict_types = 1);

namespace App\Model\Database\Fixture;

use App\Model\Database\Entity\ArticleEntity;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Nette\Neon\Neon;
use Nette\Utils\Strings;


final class ArticleFixture implements FixtureInterface
{

	public function load(ObjectManager $manager): void
	{
		$articles = Neon::decodeFile(__DIR__ . "/content/article.neon");

		foreach ($articles as $article) {
			$newArticle = new ArticleEntity();
			$newArticle->setName($article['title']);
			$newArticle->setSlug(Strings::webalize($article['title']));
			$newArticle->setDescription($article['description']);
			$newArticle->setImage($article['image']);
			$newArticle->setCreatedAt(new \DateTime('now'));
			$manager->persist($newArticle);
		}
		$manager->flush();
	}

}
