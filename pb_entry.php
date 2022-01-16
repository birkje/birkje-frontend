<?php 
    namespace Module;

    use \Library\Controller;
    use \Library\ModuleConfig;
    use \Library\ModuleManager;
    
    require_once DYNAMIC_DIR . '/modules/birkje-frontend/workers/routes.php';

    class BirkjeFrontend {
        private static $version = null;
        private static $config = null;

        public function initialize() {
            if (!self::$config) self::$config = new ModuleConfig('birkje-frontend');
            if (!self::$version) {
                $modman = new ModuleManager;
                self::$version = $modman->moduleLocalInfo('birkje-frontend')->version;
            }

            self::$config->defaults(array(
                "content-public" => 0
            ));

            $this->updater();
        }

        public function requestHandler($params) {
            if (!isset($params[0])) {
                die("no page requested.");
            } else {
                $controller = new Controller;
                if (intval(self::$config->get('content-public')) == 1) {
                    switch($params[0]) {
                        case 'page-home':
                            $this->loadView('home');
                            $controller->__template('module:birkje-frontend:page');
                            break;
                        default:
                            die("unknown page requested.");
                    }
                } else {
                    $this->loadView('content-hidden');
                    $controller->__template('module:birkje-frontend:announcement', array(
                        "title" => "Binnenkort",
                        "description" => SITE_DESCRIPTION,
                        "body" => array(
                            array("style", "css/page-content-hidden.css", array("origin" => "module:birkje-frontend"))
                        )
                    ));
                }
            }
        }

        private function loadView($view) {
            require_once DYNAMIC_DIR . '/modules/birkje-frontend/views/' . $view . '.php';
        }

        private function updater() {
            $current = self::$config->get('version');
            if (!$current) $current = '0.0.0';
            if (version_compare(self::$version, $current) > 0) {
                ModBirkjeFrontend\Routes::apply($current);
                self::$config->set('version', self::$version);
            }
        }
    }