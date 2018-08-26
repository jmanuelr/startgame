<?
if (!defined('_FANATIGOL_PASSPHRASE'))define('_FANATIGOL_PASSPHRASE', 'NIETZSCHEZARATUSTRA');
	
if (!defined('_SESSION_INC')) {
    define('_SESSION_INC', 1);

    class session {
        function start($nome_sessao = 'site') {
            session_set_cookie_params(0, "/");
            session_name($nome_sessao);
            session_start();
        }
        function save($nome,$valor){
			$_SESSION[$nome] = $valor;
		}
        function destroy($nome_sessao = 'site'){
            session_unset($nome_sessao);
            session_destroy();
        }
    }
} //endif
?>