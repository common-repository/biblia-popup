<?php

function bpp_tblTestamentos() {
    global $wpdb;
    $tblTestamentos = $wpdb->prefix . 'testamento';

    $sqlTestamentos = "
	-- Copiando estrutura para tabela testamento
	CREATE TABLE IF NOT EXISTS {$tblTestamentos} (
	  `id` int(11) NOT NULL AUTO_INCREMENT,
	  `name` varchar(45) DEFAULT NULL,
	  PRIMARY KEY (`id`)
	) ENGINE=InnoDB;";
    $wpdb->query($sqlTestamentos);

    $sqlInsertTestamentos = "
	INSERT INTO {$tblTestamentos} (`id`, `name`) VALUES
		(1, 'Velho Testamento'),
		(2, 'Novo Testamento');";

    $wpdb->query($sqlInsertTestamentos);
}

add_action('tblTestamentos', 'bpp_tblTestamentos');
?>