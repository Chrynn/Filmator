<?php declare(strict_types = 1);

namespace App\Model\Database\Fixture;

use App\Model\Database\Entity\ArticleEntity;
use Doctrine\Persistence\ObjectManager;
use Nette\Neon\Neon;
use Nettrine\Fixtures\ContainerAwareInterface;

final class ArticleFixture extends AbstractFixture implements ContainerAwareInterface
{
	public function load(ObjectManager $manager): void
	{
		$articles = Neon::decodeFile(__DIR__ . "/content/article.neon");

		foreach ($articles as $article) {
			$newArticle = new ArticleEntity($article['title']);
			$newArticle->setDescription($article['description']);

			$manager->persist($newArticle);
		}
		$manager->flush();
	}

}
