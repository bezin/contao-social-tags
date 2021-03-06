<?php

declare(strict_types=1);

namespace Hofff\Contao\SocialTags\Action;

use Contao\CoreBundle\Framework\ContaoFrameworkInterface;
use Contao\PageModel;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use function urlencode;

final class FacebookLintAction
{
    private const FACEBOOK_LINT_URL = 'https://developers.facebook.com/tools/debug/?q=';

    /** @var ContaoFrameworkInterface */
    private $framework;

    public function __construct(ContaoFrameworkInterface $framework)
    {
        $this->framework = $framework;
    }

    public function __invoke(int $pageId, Request $request) : Response
    {
        $this->framework->initialize();

        /** @var PageModel|null $pageModel */
        $pageModel = $this->framework->getAdapter(PageModel::class)->findWithDetails($pageId);
        $target    = self::FACEBOOK_LINT_URL;

        if ($pageModel) {
            $target .= urlencode($pageModel->getAbsoluteUrl());
        }

        return new RedirectResponse($target);
    }
}
