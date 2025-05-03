<?php
class Conexao {
    private static $instancia;

    public static function pegarConexao() {
        if (!self::$instancia) {
            // **Atenção:** Verifique se o host, dbname, user e password estão corretos para o seu ambiente.
            self::$instancia = new PDO(
                "mysql:host=localhost;dbname=cadastropessoa;charset=utf8",
                "root", // usuário padrão do XAMPP/WAMPP
                "root"      // senha padrão do XAMPP/WAMPP (geralmente vazia ou 'root')
            );
            self::$instancia->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            self::$instancia->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC); // Garante array associativo
        }
        return self::$instancia;
    }
}
?>