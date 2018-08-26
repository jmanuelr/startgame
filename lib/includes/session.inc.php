<?
if (!defined('_SESSION_INC')) {
    define('_SESSION_INC', 1);

    class session {
        public static function start() {
            session_set_cookie_params(0, "/");
            session_name("noobets");
            session_start();
        }
        public static function save($nome,$valor){
			$_SESSION[$nome] = $valor;
		}
        public static function destroy(){
            session_unset("noobets");
            session_destroy();
        }
    }
} //endif
?>