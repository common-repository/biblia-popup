<?php

function bpp_tblLivros() {
    global $wpdb;
    $tbl = $wpdb->prefix . 'livros';

    $sqlLivros = "
    CREATE TABLE IF NOT EXISTS {$tbl} (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `name` varchar(45) DEFAULT NULL,
    `abbrev` varchar(5) DEFAULT NULL,
    `link` varchar(45) DEFAULT NULL,
    `testament` varchar(5) DEFAULT NULL,
    PRIMARY KEY (`id`)
    ) ENGINE = InnoDB;";

    $wpdb->query($sqlLivros);

    $sqlInsertLivros = "
    INSERT INTO {$tbl} (`id`, `name`, `abbrev`, `link`, `testament`) VALUES
    (1, 'Gênesis', 'gn', 'genesis', '1'),
	(2, 'Êxodo', 'ex', 'exodo', '1'),
	(3, 'Levítico', 'lv', 'levitico', '1'),
	(4, 'Números', 'nm', 'numeros', '1'),
	(5, 'Deuteronômio', 'dt', 'deuteronomio', '1'),
	(6, 'Josué', 'js', 'josue', '1'),
	(7, 'Juízes', 'jz', 'juizes', '1'),
	(8, 'Rute', 'rt', 'rute', '1'),
	(9, '1º Samuel', '1sm', '1samuel', '1'),
	(10, '2º Samuel', '2sm', '2samuel', '1'),
	(11, '1º Reis', '1rs', '1reis', '1'),
	(12, '2º Reis', '2rs', '2reis', '1'),
	(13, '1º Crônicas', '1cr', '1cronicas', '1'),
	(14, '2º Crônicas', '2cr', '2cronicas', '1'),
	(15, 'Esdras', 'ed', 'esdras', '1'),
	(16, 'Neemias', 'ne', 'neemias', '1'),
	(17, 'Ester', 'et', 'ester', '1'),
	(18, 'Jó', 'job', 'jo', '1'),
	(19, 'Salmos', 'sl', 'salmos', '1'),
	(20, 'Provérbios', 'pv', 'proverbios', '1'),
	(21, 'Eclesiastes', 'ec', 'eclesiastes', '1'),
	(22, 'Cânticos', 'ct', 'canticos', '1'),
	(23, 'Isaías', 'is', 'isaias', '1'),
	(24, 'Jeremias', 'jr', 'jeremias', '1'),
	(25, 'Lamentações', 'lm', 'lamentacoes', '1'),
	(26, 'Ezequiel', 'ez', 'ezequiel', '1'),
	(27, 'Daniel', 'dn', 'daniel', '1'),
	(28, 'Oséias', 'os', 'oseias', '1'),
	(29, 'Joel', 'jl', 'joel', '1'),
	(30, 'Amós', 'am', 'amos', '1'),
	(31, 'Obadias', 'ob', 'obadias', '1'),
	(32, 'Jonas', 'jn', 'jonas', '1'),
	(33, 'Miquéias', 'mq', 'miqueias', '1'),
	(34, 'Naum', 'na', 'naum', '1'),
	(35, 'Habacuque', 'hc', 'habacuque', '1'),
	(36, 'Sofonias', 'sf', 'sofonias', '1'),
	(37, 'Ageu', 'ag', 'ageu', '1'),
	(38, 'Zacarias', 'zc', 'zacarias', '1'),
	(39, 'Malaquias', 'ml', 'malaquias', '1'),
	(40, 'Mateus', 'mt', 'mateus', '2'),
	(41, 'Marcos', 'mc', 'marcos', '2'),
	(42, 'Lucas', 'lc', 'lucas', '2'),
	(43, 'João', 'jo', 'joao', '2'),
	(44, 'Atos', 'at', 'atos', '2'),
	(45, 'Romanos', 'rm', 'romanos', '2'),
	(46, '1ª Coríntios', '1co', '1corintios', '2'),
	(47, '2ª Coríntios', '2co', '2corintios', '2'),
	(48, 'Gálatas', 'gl', 'galatas', '2'),
	(49, 'Efésios', 'ef', 'efesios', '2'),
	(50, 'Filipenses', 'fp', 'filipenses', '2'),
	(51, 'Colossenses', 'cl', 'colossenses', '2'),
	(52, '1ª Tessalonicenses', '1ts', '1tessalonicenses', '2'),
	(53, '2ª Tessalonicenses', '2ts', '2tessalonicenses', '2'),
	(54, '1ª Timóteo', '1tm', '1timoteo', '2'),
	(55, '2ª Timóteo', '2tm', '2timoteo', '2'),
	(56, 'Tito', 'tt', 'tito', '2'),
	(57, 'Filemom', 'fm', 'filemom', '2'),
	(58, 'Hebreus', 'hb', 'hebreus', '2'),
	(59, 'Tiago', 'tg', 'tiago', '2'),
	(60, '1ª Pedro', '1pe', '1pedro', '2'),
	(61, '2ª Pedro', '2pe', '2pedro', '2'),
	(62, '1ª João', '1jo', '1joao', '2'),
	(63, '2ª João', '2jo', '2joao', '2'),
	(64, '3ª João', '3jo', '3joao', '2'),
	(65, 'Judas', 'jd', 'judas', '2'),
	(66, 'Apocalipse', 'ap', 'apocalipse', '2');";

    $wpdb->query($sqlInsertLivros);
}

add_action('tblLivros', 'bpp_tblLivros');
?>