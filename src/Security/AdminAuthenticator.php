<?php

namespace App\Security;

use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Http\Authenticator\AbstractLoginFormAuthenticator;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\CsrfTokenBadge;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\UserBadge;
use Symfony\Component\Security\Http\Authenticator\Passport\Credentials\PasswordCredentials;
use Symfony\Component\Security\Http\Authenticator\Passport\Passport;
use Symfony\Component\Security\Http\Util\TargetPathTrait;

class AdminAuthenticator extends AbstractLoginFormAuthenticator
{
    use TargetPathTrait;

    public const LOGIN_ROUTE = 'app_login';

    // Constructeur pour injecter le générateur d'URL
    public function __construct(private UrlGeneratorInterface $urlGenerator)
    {
    }

    // Méthode pour authentifier l'utilisateur
    public function authenticate(Request $request): Passport
    {
        // Récupère le nom d'utilisateur depuis la requête
        $username = $request->request->get('username', '');

        // Stocke le dernier nom d'utilisateur utilisé dans la session
        $request->getSession()->set(Security::LAST_USERNAME, $username);

        // Retourne un passeport avec les badges de sécurité nécessaires
        return new Passport(
            new UserBadge($username),
            new PasswordCredentials($request->request->get('password', '')),
            [
                new CsrfTokenBadge('authenticate', $request->request->get('_csrf_token')),
            ]
        );
    }

    // Méthode appelée après une authentification réussie
    public function onAuthenticationSuccess(Request $request, TokenInterface $token, string $firewallName): ?Response
    {
        // Vérifie s'il y a une URL de destination prévue après l'authentification
        if ($targetPath = $this->getTargetPath($request->getSession(), $firewallName)) {
            return new RedirectResponse($targetPath);
        }

        // Redirige l'utilisateur vers la page d'accueil après l'authentification réussie
        return new RedirectResponse($this->urlGenerator->generate('app_home'));
    }

    // Méthode pour obtenir l'URL de connexion
    protected function getLoginUrl(Request $request): string
    {
        return $this->urlGenerator->generate(self::LOGIN_ROUTE);
    }
}
