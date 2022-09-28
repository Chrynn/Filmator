<?php declare(strict_types=1);

namespace App\Model\Facade\PermanentLogin;

use App\Model\Facade\Auth\AuthorizationFacade;
use App\Model\Service\PermanentLogin\PermanentLoginService;
use App\Model\Service\User\UserService;
use Nette\Http\Request;
use Nette\Http\Response;

final class PermanentLoginFacade
{

	public const COOKIE_PERMANENT_LOGIN = "Filmator-PL";

	private PermanentLoginService $permanentLoginService;
	private Response $response;
	private UserService $userService;
	private AuthorizationFacade $authorizationFacade;
	private Request $request;


	public function __construct(
		PermanentLoginService $permanentLoginService,
		Response $response,
		UserService $userService,
		AuthorizationFacade $authorizationFacade,
		Request $request
	)
	{
		$this->permanentLoginService = $permanentLoginService;
		$this->response = $response;
		$this->userService = $userService;
		$this->authorizationFacade = $authorizationFacade;
		$this->request = $request;
	}


	public function setPermanentLogin(): void
	{
		$permanentLoginCookie = $this->getPermanentLoginCookie();
		$loginStatus = $this->authorizationFacade->isLoggedIn();

		if (!$loginStatus && $permanentLoginCookie) {
			$this->verifyPermanentLogin($permanentLoginCookie);
		}
	}


	public function removePermanentLogin(): void
	{
		$permanentLoginCookie = $this->getPermanentLoginCookie();

		if ($permanentLoginCookie) {
			$this->removePermanentLoginCookie();
			$tokenId = $this->verifyPermanentLogin($permanentLoginCookie);
			if ($tokenId) {
				$this->permanentLoginService->delete($tokenId);
			}
		}
	}


	/**
	 * $selector = tokenId
	 * $validator = hashed tokenValue
	 */
	public function setPermanentLoginCookie(string $email): void
	{
		$token = $this->permanentLoginService->add($email);
		$validator = $token["hash"];
		$selector = $token["id"];
		$cookieTitle = self::COOKIE_PERMANENT_LOGIN;
		// put selector last so is not seen in browser Cookie preview
		$cookieValue = $validator . "-" . $selector;

		$this->response->setCookie($cookieTitle, $cookieValue, "30 days");
	}


	public function getPermanentLoginCookie(): ?string
	{
		return $this->request->getCookie(self::COOKIE_PERMANENT_LOGIN);
	}


	public function removePermanentLoginCookie(): void
	{
		$this->response->deleteCookie(self::COOKIE_PERMANENT_LOGIN);
	}


	public function verifyPermanentLogin(?string $tokenCookie): ?int
	{
		if ($tokenCookie) {
			$mixedCookie = explode("-", $tokenCookie);
			$selectorCookie = $mixedCookie[1];
			$validatorCookie = $mixedCookie[0];

			$tokenDatabase = $this->permanentLoginService->getTokenById($selectorCookie);
			if ($tokenDatabase) {
				$validatorDatabase = $tokenDatabase->getValidator();

				$user = $this->userService->getUserById($tokenDatabase->getUserId());
				if (hash_equals($validatorCookie, $validatorDatabase) && $user) {
					$userId = $user->getId();
					$this->authorizationFacade->loginById($userId);
				}
				return (int) $selectorCookie;
			}
			return NULL;
		}
		return NULL;
	}

}