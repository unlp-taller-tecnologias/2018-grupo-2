<?php

use Symfony\Component\Routing\Exception\MethodNotAllowedException;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;
use Symfony\Component\Routing\RequestContext;

/**
 * This class has been auto-generated
 * by the Symfony Routing Component.
 */
class appDevDebugProjectContainerUrlMatcher extends Symfony\Bundle\FrameworkBundle\Routing\RedirectableUrlMatcher
{
    public function __construct(RequestContext $context)
    {
        $this->context = $context;
    }

    public function match($rawPathinfo)
    {
        $allow = array();
        $pathinfo = rawurldecode($rawPathinfo);
        $trimmedPathinfo = rtrim($pathinfo, '/');
        $context = $this->context;
        $request = $this->request ?: $this->createRequest($pathinfo);
        $requestMethod = $canonicalMethod = $context->getMethod();

        if ('HEAD' === $requestMethod) {
            $canonicalMethod = 'GET';
        }

        if (0 === strpos($pathinfo, '/_')) {
            // _wdt
            if (0 === strpos($pathinfo, '/_wdt') && preg_match('#^/_wdt/(?P<token>[^/]++)$#sD', $pathinfo, $matches)) {
                return $this->mergeDefaults(array_replace($matches, array('_route' => '_wdt')), array (  '_controller' => 'web_profiler.controller.profiler:toolbarAction',));
            }

            if (0 === strpos($pathinfo, '/_profiler')) {
                // _profiler_home
                if ('/_profiler' === $trimmedPathinfo) {
                    $ret = array (  '_controller' => 'web_profiler.controller.profiler:homeAction',  '_route' => '_profiler_home',);
                    if ('/' === substr($pathinfo, -1)) {
                        // no-op
                    } elseif ('GET' !== $canonicalMethod) {
                        goto not__profiler_home;
                    } else {
                        return array_replace($ret, $this->redirect($rawPathinfo.'/', '_profiler_home'));
                    }

                    return $ret;
                }
                not__profiler_home:

                if (0 === strpos($pathinfo, '/_profiler/search')) {
                    // _profiler_search
                    if ('/_profiler/search' === $pathinfo) {
                        return array (  '_controller' => 'web_profiler.controller.profiler:searchAction',  '_route' => '_profiler_search',);
                    }

                    // _profiler_search_bar
                    if ('/_profiler/search_bar' === $pathinfo) {
                        return array (  '_controller' => 'web_profiler.controller.profiler:searchBarAction',  '_route' => '_profiler_search_bar',);
                    }

                }

                // _profiler_phpinfo
                if ('/_profiler/phpinfo' === $pathinfo) {
                    return array (  '_controller' => 'web_profiler.controller.profiler:phpinfoAction',  '_route' => '_profiler_phpinfo',);
                }

                // _profiler_search_results
                if (preg_match('#^/_profiler/(?P<token>[^/]++)/search/results$#sD', $pathinfo, $matches)) {
                    return $this->mergeDefaults(array_replace($matches, array('_route' => '_profiler_search_results')), array (  '_controller' => 'web_profiler.controller.profiler:searchResultsAction',));
                }

                // _profiler_open_file
                if ('/_profiler/open' === $pathinfo) {
                    return array (  '_controller' => 'web_profiler.controller.profiler:openAction',  '_route' => '_profiler_open_file',);
                }

                // _profiler
                if (preg_match('#^/_profiler/(?P<token>[^/]++)$#sD', $pathinfo, $matches)) {
                    return $this->mergeDefaults(array_replace($matches, array('_route' => '_profiler')), array (  '_controller' => 'web_profiler.controller.profiler:panelAction',));
                }

                // _profiler_router
                if (preg_match('#^/_profiler/(?P<token>[^/]++)/router$#sD', $pathinfo, $matches)) {
                    return $this->mergeDefaults(array_replace($matches, array('_route' => '_profiler_router')), array (  '_controller' => 'web_profiler.controller.router:panelAction',));
                }

                // _profiler_exception
                if (preg_match('#^/_profiler/(?P<token>[^/]++)/exception$#sD', $pathinfo, $matches)) {
                    return $this->mergeDefaults(array_replace($matches, array('_route' => '_profiler_exception')), array (  '_controller' => 'web_profiler.controller.exception:showAction',));
                }

                // _profiler_exception_css
                if (preg_match('#^/_profiler/(?P<token>[^/]++)/exception\\.css$#sD', $pathinfo, $matches)) {
                    return $this->mergeDefaults(array_replace($matches, array('_route' => '_profiler_exception_css')), array (  '_controller' => 'web_profiler.controller.exception:cssAction',));
                }

            }

            // _twig_error_test
            if (0 === strpos($pathinfo, '/_error') && preg_match('#^/_error/(?P<code>\\d+)(?:\\.(?P<_format>[^/]++))?$#sD', $pathinfo, $matches)) {
                return $this->mergeDefaults(array_replace($matches, array('_route' => '_twig_error_test')), array (  '_controller' => 'twig.controller.preview_error:previewErrorPageAction',  '_format' => 'html',));
            }

        }

        elseif (0 === strpos($pathinfo, '/a')) {
            if (0 === strpos($pathinfo, '/area')) {
                // area_index
                if ('/area' === $trimmedPathinfo) {
                    $ret = array (  '_controller' => 'AppBundle\\Controller\\AreaController::indexAction',  '_route' => 'area_index',);
                    if ('/' === substr($pathinfo, -1)) {
                        // no-op
                    } elseif ('GET' !== $canonicalMethod) {
                        goto not_area_index;
                    } else {
                        return array_replace($ret, $this->redirect($rawPathinfo.'/', 'area_index'));
                    }

                    return $ret;
                }
                not_area_index:

                // area_new
                if ('/area/new' === $pathinfo) {
                    return array (  '_controller' => 'AppBundle\\Controller\\AreaController::newAction',  '_route' => 'area_new',);
                }

                // area_show
                if (preg_match('#^/area/(?P<id>[^/]++)$#sD', $pathinfo, $matches)) {
                    return $this->mergeDefaults(array_replace($matches, array('_route' => 'area_show')), array (  '_controller' => 'AppBundle\\Controller\\AreaController::showAction',));
                }

                // area_edit
                if (preg_match('#^/area/(?P<id>[^/]++)/edit$#sD', $pathinfo, $matches)) {
                    return $this->mergeDefaults(array_replace($matches, array('_route' => 'area_edit')), array (  '_controller' => 'AppBundle\\Controller\\AreaController::editAction',));
                }

                // area_delete
                if (preg_match('#^/area/(?P<id>[^/]++)$#sD', $pathinfo, $matches)) {
                    return $this->mergeDefaults(array_replace($matches, array('_route' => 'area_delete')), array (  '_controller' => 'AppBundle\\Controller\\AreaController::deleteAction',));
                }

            }

            elseif (0 === strpos($pathinfo, '/attendant')) {
                // attendant_index
                if ('/attendant' === $trimmedPathinfo) {
                    $ret = array (  '_controller' => 'AppBundle\\Controller\\AttendantController::indexAction',  '_route' => 'attendant_index',);
                    if ('/' === substr($pathinfo, -1)) {
                        // no-op
                    } elseif ('GET' !== $canonicalMethod) {
                        goto not_attendant_index;
                    } else {
                        return array_replace($ret, $this->redirect($rawPathinfo.'/', 'attendant_index'));
                    }

                    return $ret;
                }
                not_attendant_index:

                // attendant_new
                if ('/attendant/new' === $pathinfo) {
                    return array (  '_controller' => 'AppBundle\\Controller\\AttendantController::newAction',  '_route' => 'attendant_new',);
                }

                // attendant_show
                if (preg_match('#^/attendant/(?P<id>[^/]++)$#sD', $pathinfo, $matches)) {
                    return $this->mergeDefaults(array_replace($matches, array('_route' => 'attendant_show')), array (  '_controller' => 'AppBundle\\Controller\\AttendantController::showAction',));
                }

                // attendant_edit
                if (preg_match('#^/attendant/(?P<id>[^/]++)/edit$#sD', $pathinfo, $matches)) {
                    return $this->mergeDefaults(array_replace($matches, array('_route' => 'attendant_edit')), array (  '_controller' => 'AppBundle\\Controller\\AttendantController::editAction',));
                }

                // attendant_delete
                if (preg_match('#^/attendant/(?P<id>[^/]++)$#sD', $pathinfo, $matches)) {
                    return $this->mergeDefaults(array_replace($matches, array('_route' => 'attendant_delete')), array (  '_controller' => 'AppBundle\\Controller\\AttendantController::deleteAction',));
                }

            }

            elseif (0 === strpos($pathinfo, '/admin')) {
                // easyadmin
                if ('/admin' === $trimmedPathinfo) {
                    $ret = array (  '_controller' => 'EasyCorp\\Bundle\\EasyAdminBundle\\Controller\\AdminController::indexAction',  '_route' => 'easyadmin',);
                    if ('/' === substr($pathinfo, -1)) {
                        // no-op
                    } elseif ('GET' !== $canonicalMethod) {
                        goto not_easyadmin;
                    } else {
                        return array_replace($ret, $this->redirect($rawPathinfo.'/', 'easyadmin'));
                    }

                    return $ret;
                }
                not_easyadmin:

                // admin
                if ('/admin' === $trimmedPathinfo) {
                    $ret = array (  '_controller' => 'EasyCorp\\Bundle\\EasyAdminBundle\\Controller\\AdminController::indexAction',  '_route' => 'admin',);
                    if ('/' === substr($pathinfo, -1)) {
                        // no-op
                    } elseif ('GET' !== $canonicalMethod) {
                        goto not_admin;
                    } else {
                        return array_replace($ret, $this->redirect($rawPathinfo.'/', 'admin'));
                    }

                    return $ret;
                }
                not_admin:

            }

        }

        elseif (0 === strpos($pathinfo, '/category')) {
            // category_index
            if ('/category' === $trimmedPathinfo) {
                $ret = array (  '_controller' => 'AppBundle\\Controller\\CategoryController::indexAction',  '_route' => 'category_index',);
                if ('/' === substr($pathinfo, -1)) {
                    // no-op
                } elseif ('GET' !== $canonicalMethod) {
                    goto not_category_index;
                } else {
                    return array_replace($ret, $this->redirect($rawPathinfo.'/', 'category_index'));
                }

                return $ret;
            }
            not_category_index:

            // category_new
            if ('/category/new' === $pathinfo) {
                return array (  '_controller' => 'AppBundle\\Controller\\CategoryController::newAction',  '_route' => 'category_new',);
            }

            // category_show
            if (preg_match('#^/category/(?P<id>[^/]++)$#sD', $pathinfo, $matches)) {
                return $this->mergeDefaults(array_replace($matches, array('_route' => 'category_show')), array (  '_controller' => 'AppBundle\\Controller\\CategoryController::showAction',));
            }

            // category_edit
            if (preg_match('#^/category/(?P<id>[^/]++)/edit$#sD', $pathinfo, $matches)) {
                return $this->mergeDefaults(array_replace($matches, array('_route' => 'category_edit')), array (  '_controller' => 'AppBundle\\Controller\\CategoryController::editAction',));
            }

            // category_delete
            if (preg_match('#^/category/(?P<id>[^/]++)$#sD', $pathinfo, $matches)) {
                return $this->mergeDefaults(array_replace($matches, array('_route' => 'category_delete')), array (  '_controller' => 'AppBundle\\Controller\\CategoryController::deleteAction',));
            }

        }

        // homepage
        if ('' === $trimmedPathinfo) {
            $ret = array (  '_controller' => 'AppBundle\\Controller\\DefaultController::indexAction',  '_route' => 'homepage',);
            if ('/' === substr($pathinfo, -1)) {
                // no-op
            } elseif ('GET' !== $canonicalMethod) {
                goto not_homepage;
            } else {
                return array_replace($ret, $this->redirect($rawPathinfo.'/', 'homepage'));
            }

            return $ret;
        }
        not_homepage:

        if (0 === strpos($pathinfo, '/fa')) {
            if (0 === strpos($pathinfo, '/faspecie')) {
                // faspecie_index
                if ('/faspecie' === $trimmedPathinfo) {
                    $ret = array (  '_controller' => 'AppBundle\\Controller\\FASpecieController::indexAction',  '_route' => 'faspecie_index',);
                    if ('/' === substr($pathinfo, -1)) {
                        // no-op
                    } elseif ('GET' !== $canonicalMethod) {
                        goto not_faspecie_index;
                    } else {
                        return array_replace($ret, $this->redirect($rawPathinfo.'/', 'faspecie_index'));
                    }

                    return $ret;
                }
                not_faspecie_index:

                // faspecie_new
                if ('/faspecie/new' === $pathinfo) {
                    return array (  '_controller' => 'AppBundle\\Controller\\FASpecieController::newAction',  '_route' => 'faspecie_new',);
                }

                // faspecie_show
                if (preg_match('#^/faspecie/(?P<id>[^/]++)$#sD', $pathinfo, $matches)) {
                    return $this->mergeDefaults(array_replace($matches, array('_route' => 'faspecie_show')), array (  '_controller' => 'AppBundle\\Controller\\FASpecieController::showAction',));
                }

                // faspecie_edit
                if (preg_match('#^/faspecie/(?P<id>[^/]++)/edit$#sD', $pathinfo, $matches)) {
                    return $this->mergeDefaults(array_replace($matches, array('_route' => 'faspecie_edit')), array (  '_controller' => 'AppBundle\\Controller\\FASpecieController::editAction',));
                }

                // faspecie_delete
                if (preg_match('#^/faspecie/(?P<id>[^/]++)$#sD', $pathinfo, $matches)) {
                    return $this->mergeDefaults(array_replace($matches, array('_route' => 'faspecie_delete')), array (  '_controller' => 'AppBundle\\Controller\\FASpecieController::deleteAction',));
                }

            }

            elseif (0 === strpos($pathinfo, '/fasubspecie')) {
                // fasubspecie_index
                if ('/fasubspecie' === $trimmedPathinfo) {
                    $ret = array (  '_controller' => 'AppBundle\\Controller\\FASubspecieController::indexAction',  '_route' => 'fasubspecie_index',);
                    if ('/' === substr($pathinfo, -1)) {
                        // no-op
                    } elseif ('GET' !== $canonicalMethod) {
                        goto not_fasubspecie_index;
                    } else {
                        return array_replace($ret, $this->redirect($rawPathinfo.'/', 'fasubspecie_index'));
                    }

                    return $ret;
                }
                not_fasubspecie_index:

                // fasubspecie_new
                if ('/fasubspecie/new' === $pathinfo) {
                    return array (  '_controller' => 'AppBundle\\Controller\\FASubspecieController::newAction',  '_route' => 'fasubspecie_new',);
                }

                // fasubspecie_show
                if (preg_match('#^/fasubspecie/(?P<id>[^/]++)$#sD', $pathinfo, $matches)) {
                    return $this->mergeDefaults(array_replace($matches, array('_route' => 'fasubspecie_show')), array (  '_controller' => 'AppBundle\\Controller\\FASubspecieController::showAction',));
                }

                // fasubspecie_edit
                if (preg_match('#^/fasubspecie/(?P<id>[^/]++)/edit$#sD', $pathinfo, $matches)) {
                    return $this->mergeDefaults(array_replace($matches, array('_route' => 'fasubspecie_edit')), array (  '_controller' => 'AppBundle\\Controller\\FASubspecieController::editAction',));
                }

                // fasubspecie_delete
                if (preg_match('#^/fasubspecie/(?P<id>[^/]++)$#sD', $pathinfo, $matches)) {
                    return $this->mergeDefaults(array_replace($matches, array('_route' => 'fasubspecie_delete')), array (  '_controller' => 'AppBundle\\Controller\\FASubspecieController::deleteAction',));
                }

            }

            elseif (0 === strpos($pathinfo, '/fauna')) {
                // fauna_index
                if ('/fauna' === $trimmedPathinfo) {
                    $ret = array (  '_controller' => 'AppBundle\\Controller\\FaunaController::indexAction',  '_route' => 'fauna_index',);
                    if ('/' === substr($pathinfo, -1)) {
                        // no-op
                    } elseif ('GET' !== $canonicalMethod) {
                        goto not_fauna_index;
                    } else {
                        return array_replace($ret, $this->redirect($rawPathinfo.'/', 'fauna_index'));
                    }

                    return $ret;
                }
                not_fauna_index:

                // fauna_new
                if ('/fauna/new' === $pathinfo) {
                    return array (  '_controller' => 'AppBundle\\Controller\\FaunaController::newAction',  '_route' => 'fauna_new',);
                }

                // fauna_show
                if (preg_match('#^/fauna/(?P<id>[^/]++)$#sD', $pathinfo, $matches)) {
                    return $this->mergeDefaults(array_replace($matches, array('_route' => 'fauna_show')), array (  '_controller' => 'AppBundle\\Controller\\FaunaController::showAction',));
                }

                // fauna_edit
                if (preg_match('#^/fauna/(?P<id>[^/]++)/edit$#sD', $pathinfo, $matches)) {
                    return $this->mergeDefaults(array_replace($matches, array('_route' => 'fauna_edit')), array (  '_controller' => 'AppBundle\\Controller\\FaunaController::editAction',));
                }

                // fauna_delete
                if (preg_match('#^/fauna/(?P<id>[^/]++)$#sD', $pathinfo, $matches)) {
                    return $this->mergeDefaults(array_replace($matches, array('_route' => 'fauna_delete')), array (  '_controller' => 'AppBundle\\Controller\\FaunaController::deleteAction',));
                }

            }

        }

        elseif (0 === strpos($pathinfo, '/fl')) {
            if (0 === strpos($pathinfo, '/flspecie')) {
                // flspecie_index
                if ('/flspecie' === $trimmedPathinfo) {
                    $ret = array (  '_controller' => 'AppBundle\\Controller\\FLSpecieController::indexAction',  '_route' => 'flspecie_index',);
                    if ('/' === substr($pathinfo, -1)) {
                        // no-op
                    } elseif ('GET' !== $canonicalMethod) {
                        goto not_flspecie_index;
                    } else {
                        return array_replace($ret, $this->redirect($rawPathinfo.'/', 'flspecie_index'));
                    }

                    return $ret;
                }
                not_flspecie_index:

                // flspecie_new
                if ('/flspecie/new' === $pathinfo) {
                    return array (  '_controller' => 'AppBundle\\Controller\\FLSpecieController::newAction',  '_route' => 'flspecie_new',);
                }

                // flspecie_show
                if (preg_match('#^/flspecie/(?P<id>[^/]++)$#sD', $pathinfo, $matches)) {
                    return $this->mergeDefaults(array_replace($matches, array('_route' => 'flspecie_show')), array (  '_controller' => 'AppBundle\\Controller\\FLSpecieController::showAction',));
                }

                // flspecie_edit
                if (preg_match('#^/flspecie/(?P<id>[^/]++)/edit$#sD', $pathinfo, $matches)) {
                    return $this->mergeDefaults(array_replace($matches, array('_route' => 'flspecie_edit')), array (  '_controller' => 'AppBundle\\Controller\\FLSpecieController::editAction',));
                }

                // flspecie_delete
                if (preg_match('#^/flspecie/(?P<id>[^/]++)$#sD', $pathinfo, $matches)) {
                    return $this->mergeDefaults(array_replace($matches, array('_route' => 'flspecie_delete')), array (  '_controller' => 'AppBundle\\Controller\\FLSpecieController::deleteAction',));
                }

            }

            elseif (0 === strpos($pathinfo, '/flsubspecie')) {
                // flsubspecie_index
                if ('/flsubspecie' === $trimmedPathinfo) {
                    $ret = array (  '_controller' => 'AppBundle\\Controller\\FLSubspecieController::indexAction',  '_route' => 'flsubspecie_index',);
                    if ('/' === substr($pathinfo, -1)) {
                        // no-op
                    } elseif ('GET' !== $canonicalMethod) {
                        goto not_flsubspecie_index;
                    } else {
                        return array_replace($ret, $this->redirect($rawPathinfo.'/', 'flsubspecie_index'));
                    }

                    return $ret;
                }
                not_flsubspecie_index:

                // flsubspecie_new
                if ('/flsubspecie/new' === $pathinfo) {
                    return array (  '_controller' => 'AppBundle\\Controller\\FLSubspecieController::newAction',  '_route' => 'flsubspecie_new',);
                }

                // flsubspecie_show
                if (preg_match('#^/flsubspecie/(?P<id>[^/]++)$#sD', $pathinfo, $matches)) {
                    return $this->mergeDefaults(array_replace($matches, array('_route' => 'flsubspecie_show')), array (  '_controller' => 'AppBundle\\Controller\\FLSubspecieController::showAction',));
                }

                // flsubspecie_edit
                if (preg_match('#^/flsubspecie/(?P<id>[^/]++)/edit$#sD', $pathinfo, $matches)) {
                    return $this->mergeDefaults(array_replace($matches, array('_route' => 'flsubspecie_edit')), array (  '_controller' => 'AppBundle\\Controller\\FLSubspecieController::editAction',));
                }

                // flsubspecie_delete
                if (preg_match('#^/flsubspecie/(?P<id>[^/]++)$#sD', $pathinfo, $matches)) {
                    return $this->mergeDefaults(array_replace($matches, array('_route' => 'flsubspecie_delete')), array (  '_controller' => 'AppBundle\\Controller\\FLSubspecieController::deleteAction',));
                }

            }

            elseif (0 === strpos($pathinfo, '/flora')) {
                // flora_index
                if ('/flora' === $trimmedPathinfo) {
                    $ret = array (  '_controller' => 'AppBundle\\Controller\\FloraController::indexAction',  '_route' => 'flora_index',);
                    if ('/' === substr($pathinfo, -1)) {
                        // no-op
                    } elseif ('GET' !== $canonicalMethod) {
                        goto not_flora_index;
                    } else {
                        return array_replace($ret, $this->redirect($rawPathinfo.'/', 'flora_index'));
                    }

                    return $ret;
                }
                not_flora_index:

                // flora_new
                if ('/flora/new' === $pathinfo) {
                    return array (  '_controller' => 'AppBundle\\Controller\\FloraController::newAction',  '_route' => 'flora_new',);
                }

                // flora_show
                if (preg_match('#^/flora/(?P<id>[^/]++)$#sD', $pathinfo, $matches)) {
                    return $this->mergeDefaults(array_replace($matches, array('_route' => 'flora_show')), array (  '_controller' => 'AppBundle\\Controller\\FloraController::showAction',));
                }

                // flora_edit
                if (preg_match('#^/flora/(?P<id>[^/]++)/edit$#sD', $pathinfo, $matches)) {
                    return $this->mergeDefaults(array_replace($matches, array('_route' => 'flora_edit')), array (  '_controller' => 'AppBundle\\Controller\\FloraController::editAction',));
                }

                // flora_delete
                if (preg_match('#^/flora/(?P<id>[^/]++)$#sD', $pathinfo, $matches)) {
                    return $this->mergeDefaults(array_replace($matches, array('_route' => 'flora_delete')), array (  '_controller' => 'AppBundle\\Controller\\FloraController::deleteAction',));
                }

            }

        }

        elseif (0 === strpos($pathinfo, '/login')) {
            // fos_user_security_login
            if ('/login' === $pathinfo) {
                $ret = array (  '_controller' => 'fos_user.security.controller:loginAction',  '_route' => 'fos_user_security_login',);
                if (!in_array($canonicalMethod, array('GET', 'POST'))) {
                    $allow = array_merge($allow, array('GET', 'POST'));
                    goto not_fos_user_security_login;
                }

                return $ret;
            }
            not_fos_user_security_login:

            // fos_user_security_check
            if ('/login_check' === $pathinfo) {
                $ret = array (  '_controller' => 'fos_user.security.controller:checkAction',  '_route' => 'fos_user_security_check',);
                if (!in_array($requestMethod, array('POST'))) {
                    $allow = array_merge($allow, array('POST'));
                    goto not_fos_user_security_check;
                }

                return $ret;
            }
            not_fos_user_security_check:

        }

        // fos_user_security_logout
        if ('/logout' === $pathinfo) {
            $ret = array (  '_controller' => 'fos_user.security.controller:logoutAction',  '_route' => 'fos_user_security_logout',);
            if (!in_array($canonicalMethod, array('GET', 'POST'))) {
                $allow = array_merge($allow, array('GET', 'POST'));
                goto not_fos_user_security_logout;
            }

            return $ret;
        }
        not_fos_user_security_logout:

        if (0 === strpos($pathinfo, '/profile')) {
            // fos_user_profile_show
            if ('/profile' === $trimmedPathinfo) {
                $ret = array (  '_controller' => 'fos_user.profile.controller:showAction',  '_route' => 'fos_user_profile_show',);
                if ('/' === substr($pathinfo, -1)) {
                    // no-op
                } elseif ('GET' !== $canonicalMethod) {
                    goto not_fos_user_profile_show;
                } else {
                    return array_replace($ret, $this->redirect($rawPathinfo.'/', 'fos_user_profile_show'));
                }

                if (!in_array($canonicalMethod, array('GET'))) {
                    $allow = array_merge($allow, array('GET'));
                    goto not_fos_user_profile_show;
                }

                return $ret;
            }
            not_fos_user_profile_show:

            // fos_user_profile_edit
            if ('/profile/edit' === $pathinfo) {
                $ret = array (  '_controller' => 'fos_user.profile.controller:editAction',  '_route' => 'fos_user_profile_edit',);
                if (!in_array($canonicalMethod, array('GET', 'POST'))) {
                    $allow = array_merge($allow, array('GET', 'POST'));
                    goto not_fos_user_profile_edit;
                }

                return $ret;
            }
            not_fos_user_profile_edit:

            // fos_user_change_password
            if ('/profile/change-password' === $pathinfo) {
                $ret = array (  '_controller' => 'fos_user.change_password.controller:changePasswordAction',  '_route' => 'fos_user_change_password',);
                if (!in_array($canonicalMethod, array('GET', 'POST'))) {
                    $allow = array_merge($allow, array('GET', 'POST'));
                    goto not_fos_user_change_password;
                }

                return $ret;
            }
            not_fos_user_change_password:

        }

        elseif (0 === strpos($pathinfo, '/register')) {
            // fos_user_registration_register
            if ('/register' === $trimmedPathinfo) {
                $ret = array (  '_controller' => 'fos_user.registration.controller:registerAction',  '_route' => 'fos_user_registration_register',);
                if ('/' === substr($pathinfo, -1)) {
                    // no-op
                } elseif ('GET' !== $canonicalMethod) {
                    goto not_fos_user_registration_register;
                } else {
                    return array_replace($ret, $this->redirect($rawPathinfo.'/', 'fos_user_registration_register'));
                }

                if (!in_array($canonicalMethod, array('GET', 'POST'))) {
                    $allow = array_merge($allow, array('GET', 'POST'));
                    goto not_fos_user_registration_register;
                }

                return $ret;
            }
            not_fos_user_registration_register:

            // fos_user_registration_check_email
            if ('/register/check-email' === $pathinfo) {
                $ret = array (  '_controller' => 'fos_user.registration.controller:checkEmailAction',  '_route' => 'fos_user_registration_check_email',);
                if (!in_array($canonicalMethod, array('GET'))) {
                    $allow = array_merge($allow, array('GET'));
                    goto not_fos_user_registration_check_email;
                }

                return $ret;
            }
            not_fos_user_registration_check_email:

            if (0 === strpos($pathinfo, '/register/confirm')) {
                // fos_user_registration_confirm
                if (preg_match('#^/register/confirm/(?P<token>[^/]++)$#sD', $pathinfo, $matches)) {
                    $ret = $this->mergeDefaults(array_replace($matches, array('_route' => 'fos_user_registration_confirm')), array (  '_controller' => 'fos_user.registration.controller:confirmAction',));
                    if (!in_array($canonicalMethod, array('GET'))) {
                        $allow = array_merge($allow, array('GET'));
                        goto not_fos_user_registration_confirm;
                    }

                    return $ret;
                }
                not_fos_user_registration_confirm:

                // fos_user_registration_confirmed
                if ('/register/confirmed' === $pathinfo) {
                    $ret = array (  '_controller' => 'fos_user.registration.controller:confirmedAction',  '_route' => 'fos_user_registration_confirmed',);
                    if (!in_array($canonicalMethod, array('GET'))) {
                        $allow = array_merge($allow, array('GET'));
                        goto not_fos_user_registration_confirmed;
                    }

                    return $ret;
                }
                not_fos_user_registration_confirmed:

            }

        }

        elseif (0 === strpos($pathinfo, '/resetting')) {
            // fos_user_resetting_request
            if ('/resetting/request' === $pathinfo) {
                $ret = array (  '_controller' => 'fos_user.resetting.controller:requestAction',  '_route' => 'fos_user_resetting_request',);
                if (!in_array($canonicalMethod, array('GET'))) {
                    $allow = array_merge($allow, array('GET'));
                    goto not_fos_user_resetting_request;
                }

                return $ret;
            }
            not_fos_user_resetting_request:

            // fos_user_resetting_reset
            if (0 === strpos($pathinfo, '/resetting/reset') && preg_match('#^/resetting/reset/(?P<token>[^/]++)$#sD', $pathinfo, $matches)) {
                $ret = $this->mergeDefaults(array_replace($matches, array('_route' => 'fos_user_resetting_reset')), array (  '_controller' => 'fos_user.resetting.controller:resetAction',));
                if (!in_array($canonicalMethod, array('GET', 'POST'))) {
                    $allow = array_merge($allow, array('GET', 'POST'));
                    goto not_fos_user_resetting_reset;
                }

                return $ret;
            }
            not_fos_user_resetting_reset:

            // fos_user_resetting_send_email
            if ('/resetting/send-email' === $pathinfo) {
                $ret = array (  '_controller' => 'fos_user.resetting.controller:sendEmailAction',  '_route' => 'fos_user_resetting_send_email',);
                if (!in_array($requestMethod, array('POST'))) {
                    $allow = array_merge($allow, array('POST'));
                    goto not_fos_user_resetting_send_email;
                }

                return $ret;
            }
            not_fos_user_resetting_send_email:

            // fos_user_resetting_check_email
            if ('/resetting/check-email' === $pathinfo) {
                $ret = array (  '_controller' => 'fos_user.resetting.controller:checkEmailAction',  '_route' => 'fos_user_resetting_check_email',);
                if (!in_array($canonicalMethod, array('GET'))) {
                    $allow = array_merge($allow, array('GET'));
                    goto not_fos_user_resetting_check_email;
                }

                return $ret;
            }
            not_fos_user_resetting_check_email:

        }

        if ('/' === $pathinfo && !$allow) {
            throw new Symfony\Component\Routing\Exception\NoConfigurationException();
        }

        throw 0 < count($allow) ? new MethodNotAllowedException(array_unique($allow)) : new ResourceNotFoundException();
    }
}
