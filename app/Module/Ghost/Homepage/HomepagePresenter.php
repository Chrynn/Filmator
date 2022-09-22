<?php declare(strict_types=1);

namespace App\Module\Ghost\Homepage;

use App\Model\Facade\Auth\AuthorizationFacade;
use App\Model\Facade\Path\PathFacade;
use App\Model\Service\Query\ArticleEntityQuery;
use App\Model\Service\Query\MovieEntityQuery;
use App\Model\Service\Query\SerialEntityQuery;
use App\Module\Ghost\_component\Forgotten\ForgottenFactory;
use App\Module\Ghost\_component\Login\LoginFactory;
use App\Module\Ghost\_component\Register\RegisterFactory;
use App\Module\Ghost\GhostPresenter;


final class HomepagePresenter extends GhostPresenter
{

	private MovieEntityQuery $movieEntityQuery;
	private SerialEntityQuery $serialEntityQuery;
	private ArticleEntityQuery $articleEntityQuery;

	public function __construct(
		AuthorizationFacade $authorizationFacade,
		MovieEntityQuery $movieEntityQuery,
		LoginFactory $loginFactory,
		RegisterFactory $registerFactory,
		ForgottenFactory $forgottenFactory,
		SerialEntityQuery $serialEntityQuery,
		ArticleEntityQuery $articleEntityQuery,
		PathFacade $pathFacade
	)
    {
        parent::__construct($authorizationFacade, $loginFactory, $registerFactory, $forgottenFactory, $pathFacade);
		$this->movieEntityQuery = $movieEntityQuery;
		$this->serialEntityQuery = $serialEntityQuery;
		$this->articleEntityQuery = $articleEntityQuery;
	}
    
	public function actionDefault(): void
	{
		$this->getTemplate()->movies = $this->movieEntityQuery->getMoviesByLimit(4);
		$this->getTemplate()->serials = $this->serialEntityQuery->getSerialsByLimit(4);
		$this->getTemplate()->articles = $this->articleEntityQuery->getArticlesByLimit(3);
	}

	public function actionBanner(): void
	{
		$this->getTemplate()->movies = $this->movieEntityQuery->getMoviesByLimit(4);
	}

}
