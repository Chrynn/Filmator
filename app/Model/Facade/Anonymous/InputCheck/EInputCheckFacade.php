<?php declare(strict_types = 1);

namespace App\Model\Facade\Anonymous\InputCheck;

enum EInputCheckFacade: string
{

	case nicknameRequired = "Zvolte přezdívku";
	case nicknameTaken = "Přezdívka je zabraná";

	case emailRequired = "Vyplňte E-mail";
	case emailFormat = "Špatný E-mail formát";

	case passwordRequired = "Vyplňte Heslo";
	case passwordSame = "Hesla se neshodují";
	case passwordLength = "Heslo musí mít nad 6 znaků";
	case passwordNumber = "Heslo musí musí mít číslici";
	case passwordCapital = "Heslo musí musí mít velké písmeno";
	case passwordSmall = "Heslo musí musí mít malé písmeno";
	case passwordAgain = "Potvrďte heslo";

	case conditionsRequired = "Musíte souhlasit s podmínkami";

}
