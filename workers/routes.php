<?php   
    namespace Module\ModBirkjeFrontend;

    use Library\VirtualPath;

    class Routes {
        private static $vPath = null;

        public static function apply($current) {
            if (!self::$vPath) self::$vPath = new VirtualPath();
            switch($current) {
                case '0.0.0':
                    self::create('/', 'pb-loader/module/birkje-frontend/page-home', 'nl');
                    self::create('/signin', 'pb-auth/plugin/oidc_discord', 'nl');
                    self::create('/signin/local', 'pb-auth/signin', 'nl');
            }
        }

        private static function create($origin, $target, $lang) {
            if (!self::$vPath->find($origin, $target, $lang)) self::$vPath->create($origin, $target, $lang);
        }

        private static function delete($origin, $target, $lang) {
            self::$vPath->delete($origin, $target, $lang);
        }
    }