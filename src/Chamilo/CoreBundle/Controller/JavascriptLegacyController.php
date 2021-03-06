<?php
/* For licensing terms, see /license.txt */

namespace Chamilo\CoreBundle\Controller;

use Chamilo\CoreBundle\Framework\PageController;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Chamilo\CoreBundle\Controller\BaseController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\HttpKernelInterface;
use Symfony\Component\Finder\Finder;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

/**
 * Class JavascriptLegacyController
 * author Julio Montoya <gugli100@gmail.com>
 * @package Chamilo\CoreBundle\Controller
 */
class JavascriptLegacyController extends BaseController
{
    /**
     * @Route("/config_editor", name="config_editor")
     * @Method({"GET"})
     *
     * @return Response
     */
    public function configEditorAction()
    {
        $moreButtonsInMaximizedMode = false;

        if (api_get_setting('editor.more_buttons_maximized_mode') == 'true') {
            $moreButtonsInMaximizedMode = true;
        }

        return $this->render(
            'ChamiloCoreBundle:default/javascript/editor/ckeditor:config_js.html.twig',
            array(
                'more_buttons_in_max_mode' => $moreButtonsInMaximizedMode,
                'course_id' => '1',
                'session_id' => '1'
            )
        );
    }
}
