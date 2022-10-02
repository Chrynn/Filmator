<?php declare(strict_types=1);

namespace App\Module\Anonymous\Homepage;

use App\Model\Facade\Anonymous\Auth\AuthorizationFacade;
use App\Model\Facade\Common\AutoIncrement\AutoIncrementFacade;
use App\Model\Facade\Common\PermanentLogin\PermanentLoginFacade;
use App\Model\Service\Article\ArticleService;
use App\Model\Service\Movie\MovieService;
use App\Model\Service\Serial\SerialService;
use App\Module\Anonymous\AnonymousPresenter;
use App\Module\Anonymous\components\Forgotten\ForgottenFactory;
use App\Module\Anonymous\components\Login\LoginFactory;
use App\Module\Anonymous\components\Register\RegisterFactory;

final class HomepagePresenter extends AnonymousPresenter
{

	private MovieService $movieService;
	private SerialService $serialService;
	private ArticleService $articleService;

	public function __construct(
		AutoIncrementFacade $autoIncrementFacade,
		PermanentLoginFacade $permanentLoginFacade,
		AuthorizationFacade $authorizationFacade,
		RegisterFactory $registerFactory,
		LoginFactory $loginFactory,
		ForgottenFactory $forgottenFactory,
		MovieService $movieService,
		SerialService $serialService,
		ArticleService $articleService
	)
    {
        parent::__construct(
			$autoIncrementFacade,
			$permanentLoginFacade,
			$authorizationFacade,
			$registerFactory,
			$loginFactory,
			$forgottenFactory
		);
		$this->movieService = $movieService;
		$this->serialService = $serialService;
		$this->articleService = $articleService;
	}


	public function actionDefault(): void
	{
		$this->getTemplate()->movies = $this->movieService->getMoviesByLimit(4);
		$this->getTemplate()->serials = $this->serialService->getSerialsByLimit(4);
		$this->getTemplate()->articles = $this->articleService->getArticlesByLimit(3);
	}


	public function actionSlider(): void
	{
		$this->getTemplate()->movies = $this->movieService->getMoviesByLimit(4);
	}

}
