<?php

/*!
 * ifsoft.co.uk
 *
 * http://ifsoft.com.ua, https://ifsoft.co.uk, https://raccoonsquare.com
 * raccoonsquare@gmail.com
 *
 * Copyright 2012-2020 Demyanchuk Dmitry (raccoonsquare@gmail.com)
 */

error_reporting(E_ALL); // E_ALL - only for development and testing. Must be 0 for release version

define("APP_SIGNATURE", "raccoonsquare"); // Add signature constant to protect include modules

include_once("sys/core/init.inc.php"); // include classes and constants

if (!isset($_SESSION)) {

        // Start session and set cookie

        // @session_regenerate_id(true);
        // session_start();

        // ini_set('session.cookie_domain', '.'.APP_HOST);
        // session_set_cookie_params(0, '/', '.'.APP_HOST);
}

session_start();

$helper = new helper($dbo); // Global variable for helper class
$auth = new auth($dbo); // Global variable for auth class

// Auto authorize if installed cookie and allow authorization

if (WEB_ALLOW_AUTHORIZATION && !WEB_UNDER_CONSTRUCTION) {

    if (!auth::isSession() && isset($_COOKIE['user_name']) && isset($_COOKIE['user_password'])) {

        $account = new account($dbo, $helper->getUserId($_COOKIE['user_name']));

        $accountInfo = $account->get();

        if (!$accountInfo['error'] && $accountInfo['state'] == ACCOUNT_STATE_ENABLED) {

            $auth = new auth($dbo);

            if ($auth->authorize($accountInfo['id'], $_COOKIE['user_password'])) {

                auth::setSession($accountInfo['id'], $accountInfo['username'], $accountInfo['fullname'], $accountInfo['lowPhotoUrl'], $accountInfo['verify'], 0, $_COOKIE['user_password']);

                // Last notifications view | for new notifications counter
                auth::setCurrentLastNotifyView($accountInfo['lastNotifyView']);

                $account->setLastActive();

            } else {

                auth::clearCookie();
            }

        } else {

            auth::clearCookie();
        }
    }
}

// Global variables

$page_id = '';

$request = array();
$cnt = 0; // count of requests array

if (!empty($_GET)) {

    if (isset($_GET['q'])) {

        $request = htmlentities($_GET['q'], ENT_QUOTES);
        $request = helper::escapeText($request);
        $request = explode('/', trim($request, '/'));

        $cnt = count($request);
    }

    if (WEB_UNDER_CONSTRUCTION) {

        if ($cnt != 4 && $request[0] != "api") {

            include_once("html/page.ucon.inc.php");
            exit;
        }
    }

	switch ($cnt) {

		case 0: {

			include_once("html/page.main.inc.php");
			exit;
		}

		case 1: {

			if (file_exists("html/page.".$request[0].".inc.php")) {

				include_once("html/page.".$request[0].".inc.php");
				exit;

			}  else if ($helper->isLoginExists($request[0])) {

				include_once("html/page.profile.inc.php");
				exit;

			} else {

				include_once("html/page.error.inc.php");
				exit;
			}
		}

		case 2: {

			if (file_exists( "html/".$request[0]."/page.".$request[1].".inc.php")) {

                // Basic pages

				include_once("html/" . $request[0] . "/page." . $request[1] . ".inc.php");
				exit;

			} else if ($request[0] === APP_ADMIN_PANEL && file_exists("apanel/page.".$request[1].".inc.php")) {

                // Admin panel pages

                include_once("apanel/page." . $request[1] . ".inc.php");
                exit;

            } else if ($request[0] === "item") {

                // Show item

                include_once("html/item/page.view.inc.php");
                exit;

            } else if ($request[0] === "classified") {

                // Show item

                include_once("html/item/page.view.inc.php");
                exit;

            } else if ($request[0] === "chat") {

                // Show chat

                include_once("html/chat/page.editor.inc.php");
                exit;

            } else if ($helper->isLoginExists($request[0])) {

                if (file_exists("html/profile/page." . $request[1] . ".inc.php")) {

                    include_once("html/profile/page." . $request[1] . ".inc.php");
                    exit;

                } else {

                    include_once("html/page.error.inc.php");
                    exit;
                }

			} else {

				include_once("html/page.error.inc.php");
				exit;
			}
		}

		case 3: {

            if (file_exists("html/".$request[0]."/".$request[1]."/page.".$request[2].".inc.php")) {

                include_once("html/".$request[0]."/".$request[1]."/page.".$request[2].".inc.php");
                exit;

            } else if ($request[0] === "item" && $request[2] === "edit") {

                // Edit item

                include_once("html/item/page.new.inc.php");
                exit;

            } else if ($helper->isLoginExists($request[0])) {

                // For profile posts/photos and others

                switch ($request[1]) {

                    case 'post': {

                        include_once("html/item/page.view.inc.php");
                        exit;

                        break;
                    }

                    default: {

                        include_once("html/page.error.inc.php");
                        exit;

                        break;
                    }
                }

            } else {

                include_once("html/page.error.inc.php");
                exit;
            }
		}

		case 4: {

            switch ($request[0]) {

                case 'api': {

                    if (file_exists("apis/".$request[1]."/method/".$request[3].".inc.php") && APP_ALLOW_API_REQUESTS) {

                        include_once("sys/config/api.inc.php");

                        include_once("apis/".$request[1]."/method/".$request[3].".inc.php");
                        exit;

                    } else if (file_exists("html/".$request[0]."/".$request[1]."/".$request[2]."/page.".$request[3].".inc.php")) {

                        include_once("html/".$request[0]."/".$request[1]."/".$request[2]."/page.".$request[3].".inc.php");
                        exit;

                    } else {

                        include_once("html/page.error.inc.php");
                        exit;
                    }

                    break;
                }

                default: {

                    if ($helper->isLoginExists($request[0])) {

                        switch ($request[1]) {

                            case 'item' : {

                                if (file_exists("html/item/page.".$request[3].".inc.php")) {

                                    include_once("html/item/page.".$request[3].".inc.php");
                                    exit;

                                } else {

                                    include_once("html/page.error.inc.php");
                                    exit;
                                }

                                break;
                            }

                            case 'image' : {

                                if (file_exists("html/images/page.".$request[3].".inc.php")) {

                                    include_once("html/images/page.".$request[3].".inc.php");
                                    exit;

                                } else {

                                    include_once("html/page.error.inc.php");
                                    exit;
                                }

                                break;
                            }

                            default: {

                                include_once("html/page.error.inc.php");
                                exit;
                            }
                        }

                    } else {

                        if (file_exists("html/".$request[0]."/".$request[1]."/".$request[2]."/page.".$request[3].".inc.php") ) {

                            include_once("html/".$request[0]."/".$request[1]."/".$request[2]."/page.".$request[3].".inc.php");
                            exit;

                        } else {

                            include_once("html/page.error.inc.php");
                            exit;
                        }
                    }

                    break;
                }
            }
		}

		default: {

			include_once("html/page.error.inc.php");
			exit;
		}
	}

} else {

    if (WEB_UNDER_CONSTRUCTION) {

        include_once("html/page.ucon.inc.php");
        exit;

    } else {

        include_once("html/page.main.inc.php");
        exit;
    }


}
