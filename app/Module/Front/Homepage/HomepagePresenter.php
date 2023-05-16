<?php declare(strict_types=1);

namespace App\Module\Front\Homepage;

use App\Model\Facade\Front\Auth\AuthorizationFacade;
use App\Model\Facade\Common\AutoIncrement\AutoIncrementFacade;
use App\Model\Facade\Common\PermanentLogin\PermanentLoginFacade;
use App\Model\Service\Article\ArticleService;
use App\Model\Service\Movie\MovieService;
use App\Model\Service\Serial\SerialService;
use App\Module\Front\components\Forgotten\ForgottenFactory;
use App\Module\Front\components\Login\LoginFactory;
use App\Module\Front\components\Register\RegisterFactory;
use App\Module\Front\FrontPresenter;

class HomepagePresenter extends FrontPresenter
{

	public function __construct(
		PermanentLoginFacade $permanentLoginFacade,
		AuthorizationFacade $authorizationFacade,
		RegisterFactory $registerFactory,
		LoginFactory $loginFactory,
		ForgottenFactory $forgottenFactory,
		private readonly MovieService  $movieService,
		private readonly SerialService $serialService,
		private readonly ArticleService $articleService
	) {
        parent::__construct(
			$permanentLoginFacade,
			$authorizationFacade,
			$registerFactory,
			$loginFactory,
			$forgottenFactory
		);
	}


	public function actionDefault(): void
	{
		$this->getTemplate()->slider = $this->movieService->getMoviesByLimit(4);
		$this->getTemplate()->movies = $this->movieService->getMoviesByLimit(8);
		$this->getTemplate()->serials = $this->serialService->getSerialsByLimit(8);
		$this->getTemplate()->nextArticles = $this->articleService->getArticlesByLimit(3);
	}

}
