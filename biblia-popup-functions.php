<?php
require_once 'sql/activation.php';
require_once 'sql/deactivation.php';
require_once 'shortcodes/popup.php';
require_once 'mcebuttons/popbutton.php';

/* Cria menu e submenus */

function bibliapopup_init() {
    global $_wp_last_object_menu;

    add_menu_page(
            'B&iacute;blia Popup'
            , 'B&iacute;blia Popup'
            , 'manage_options'
            , 'bibliapopup'
            , 'bibliapopup_start'
            , plugin_dir_url(__FILE__) . 'icon/bibliapopup.png'
            , $_wp_last_object_menu++
    );
}

function bibliapopup_settings() {
    echo "Settings";
}

// Cria link de Configura&ccedil;&otilde;s na listagem de plugins
//Inicio
add_filter('plugin_action_links', 'bibliapopup_action_links', 10, 2);

function bibliapopup_action_links($links, $file) {
    if ($file != 'biblia-popup/biblia-popup.php') {
        return $links;
    }

    $settings_link = '<a href="' . menu_page_url('bibliapopup', false) . '&action=settings">'
            . esc_html('Configura&ccedil;&otilde;es') . '</a>'
    ;
    array_unshift($links, $settings_link);
    return $links;
}

add_action('admin_menu', 'bibliapopup_init');

if (!is_admin()) {
    wp_enqueue_style('bibliapopup', plugin_dir_url(__FILE__) . 'css/bibliapopup.css?v=' . time(), array());
    wp_enqueue_script('tippy', plugin_dir_url(__FILE__) . 'js/tippy.all.min.js', array(), time());
}

if (is_admin()) {
    wp_enqueue_style('bibliapopup', plugin_dir_url(__FILE__) . 'css/bibliapopup-admin.css?v=' . time(), array());

    add_action('admin_enqueue_scripts', 'bibliapopup_color_picker');

    function bibliapopup_color_picker() {
        wp_enqueue_style('wp-color-picker');
        wp_enqueue_script('my-script-handle', plugins_url('js/popup-plugin.js', __FILE__), array('wp-color-picker'), false, true);
    }

}

function bibliapopup_register_options_page() {
    add_options_page('B&iacute;blia Popup', 'B&iacute;blia Popup', 'manage_options', 'myplugin', 'bibliapopup_start');
}

add_action('admin_menu', 'bibliapopup_register_options_page');

function bibliapopup_start() {
    ?>
    <div>
        <?php screen_icon(); ?>
        <h1>B&iacute;blia Popup <?php echo (get_option("bibliapopup_creditos")) ? 'Pro' : 'Free'; ?> - Configura&ccedil;&otilde;es</h1>
        <hr>
        <form method="post" action="options.php">
            <?php settings_fields('bibliapopup_options_group'); ?>
            <h3>O plugin "B&iacute;blia Popup" exibe um link para o site do desenvolvedor (OEvangelho.com), caso queira oculta-lo basta desmarcar a caixa de seleção abaixo.</h3>
            <table>
                <tr valign="top">
                    <td>
                        <input type="checkbox" name="bibliapopup_creditos" value="1" <?php echo (get_option("bibliapopup_creditos")) ? 'checked="checked"' : ''; ?> />&nbsp;
                        <label for="bibliapopup_creditos"><strong>Exibir créditos de <a href="//oevangelho.com" target="_blank">OEvangelho.com</a></strong></label>
                    </td>
                </tr>
            </table>
            <?php
            if (get_option("bibliapopup_avisoLido") == 1 || $_GET['action'] == "avisoLido") {
                if (get_option("bibliapopup_avisoLido") == 1) {
                    
                } elseif (get_option("bibliapopup_avisoLido") != 1 || $_GET['action'] == "avisoLido") {
                    
                } else {
                    update_option("bibliapopup_avisoLido", 1);
                }
            } else {
                echo'
                <hr style="margin-top: 25px;">
                <table style="width: 100%;" cellpadding="0" cellspacing="0">
                    <tr valign="top">
                        <td style="background-color: #698FA6; padding: 5px 10px; color: #FFF;">
                            <p>O B&iacute;blia Popup est&aacute; sendo &uacute;til para voc&ecirc; e seus leitores? Oramos que eles possam ser incentivados a lerem mais a Escritura e, como os bereianos, possam averiguar todo ensino na B&iacute;blia.</p>
                            <p>Queremos pedir sua ajuda para servir mais pessoas com esta ferramenta. Se voc&ecirc;tem sido abe&ccedil;oado pela B&iacute;blia Popup, voc&ecirc; consideraria escrever uma postagem sobre n&oacute;s?</p>
                            <p>N&oacute;s temos um texto dizendo todas as suas fun&ccedil;&otilde;es aqui: <a href="https://oevangelho.com/post-modelo-biblia-popup/"  style="color: #FFF;">https://oevangelho.com/post-modelo-biblia-popup</a></p>
                        </td>
                        <td style="min-width: 120px; background-color: #698FA6; padding: 10px; color: #FFF; text-align: center; vertical-align: middle">
                            <a href="' . menu_page_url('bibliapopup', false) . '&action=avisoLido" style="padding: 5px 10px; background-color: #ffffff; color: #698FA6; border: 1px solid #ffffff; text-decoration: none;">Ok, Entendi!</a>
                        </td>
                    </tr>
                </table>';
            }
            ?>
            <hr <?php echo (get_option("bibliapopup_creditos")) ? '' : 'style="display:none;"'; ?>>
            <table <?php echo (get_option("bibliapopup_creditos")) ? '' : 'style="display:none;"'; ?>>
                <tr valign="top">
                    <td colspan="2">
                        <h3>
                            Op&ccedil;&otilde;es Avan&ccedil;adas
                        </h3>
                    </td>
                </tr>
                <tr>    
                    <td>
                        <label>Vers&atilde;o da B&iacute;blia</label>
                    </td>
                    <td>
                        <select name="bibliapopup_versao">
                            <option value="NVI" <?php echo (get_option("bibliapopup_versao") == 'NVI' || !get_option("bibliapopup_versao")) ? 'selected="selected"' : ''; ?>>NVI</option>
                            <option value="AA" <?php echo (get_option("bibliapopup_versao") == 'AA') ? 'selected="selected"' : ''; ?>>AA</option>
                        </select>
                    </td>
                </tr>
                <tr>    
                    <td>
                        <label>Cor do Cabe&ccedil;alho e Rodap&eacute;</label>
                    </td>
                    <td>
                        <input type="text" name="bibliapopup_header_color" id="bibliapopup_header_color" value="<?php echo get_option('bibliapopup_header_color'); ?>" class="color-field" />
                    </td>
                </tr>
                <tr>    
                    <td>
                        <label>Texto do Cabe&ccedil;alho</label>
                    </td>
                    <td>
                        <input type="text" name="bibliapopup_header_txt_color" id="bibliapopup_header_txt_color" value="<?php echo get_option('bibliapopup_header_txt_color'); ?>" class="color-field" />
                    </td>
                    <td>
                        <label>Tamanho</label>
                    </td>
                    <td>
                        <select name="bibliapopup_header_txt_size" id="bibliapopup_header_txt_size">
                            <?php
                            $tc = 0;
                            while ($tc < 26) {
                                ?>
                                <option value="<?php echo ++$tc; ?>" <?php echo ($tc == get_option('bibliapopup_header_txt_size')) ? 'selected="selected"' : ''; ?>><?php echo $tc; ?>px</option>
    <?php } ?>
                        </select>
                    </td>
                </tr>
                <tr>    
                    <td>
                        <label>Cor do "Leia o cap&iacute;tulo inteiro"</label>
                    </td>
                    <td>
                        <input type="text" name="bibliapopup_subheader_color" id="bibliapopup_subheader_color" value="<?php echo get_option('bibliapopup_subheader_color'); ?>" class="color-field" />
                    </td>
                </tr>
                <tr>    
                    <td>
                        <label>Texto do "Leia o cap&iacute;tulo inteiro"</label>
                    </td>
                    <td>
                        <input type="text" name="bibliapopup_subheader_txt_color" id="bibliapopup_subheader_txt_color" value="<?php echo get_option('bibliapopup_subheader_txt_color'); ?>" class="color-field" />
                    </td>
                    <td>
                        <label>Tamanho</label>
                    </td>
                    <td>
                        <select name="bibliapopup_subheader_txt_size" id="bibliapopup_subheader_txt_size">
                            <?php
                            $tsc = 0;
                            while ($tsc < 26) {
                                ?>
                                <option value="<?php echo ++$tsc; ?>" <?php echo ($tsc == get_option('bibliapopup_subheader_txt_size')) ? 'selected="selected"' : ''; ?>><?php echo $tsc; ?>px</option>
    <?php } ?>
                        </select>
                    </td>
                </tr>
                <tr>    
                    <td>
                        <label>Texto do Rodap&eacute;</label>
                    </td>
                    <td>
                        <input type="text" name="bibliapopup_footer_txt_color" id="bibliapopup_footer_txt_color" value="<?php echo get_option('bibliapopup_footer_txt_color'); ?>" class="color-field" />
                    </td>
                    <td>
                        <label>Tamanho</label>
                    </td>
                    <td>
                        <select name="bibliapopup_footer_txt_size" id="bibliapopup_footer_txt_size">
                            <?php
                            $tr = 0;
                            while ($tr < 26) {
                                ?>
                                <option value="<?php echo ++$tr; ?>" <?php echo ($tr == get_option('bibliapopup_footer_txt_size')) ? 'selected="selected"' : ''; ?>><?php echo $tr; ?>px</option>
    <?php } ?>
                        </select>
                    </td>
                </tr>
                <tr>    
                    <td>
                        <label>Cor de Fundo</label>
                    </td>
                    <td>
                        <input type="text" name="bibliapopup_body_color" id="bibliapopup_body_color" value="<?php echo get_option('bibliapopup_body_color'); ?>" class="color-field" />
                    </td>
                </tr>
                <tr>    
                    <td>
                        <label>Texto dos Vers&iacute;culos</label>
                    </td>
                    <td>
                        <input type="text" name="bibliapopup_body_txt_color" id="bibliapopup_body_txt_color" value="<?php echo get_option('bibliapopup_body_txt_color'); ?>" class="color-field" />
                    </td>
                    <td>
                        <label>Tamanho</label>
                    </td>
                    <td>
                        <select name="bibliapopup_body_txt_size" id="bibliapopup_body_txt_size">
                            <?php
                            $tv = 0;
                            while ($tv < 26) {
                                ?>
                                <option value="<?php echo ++$tv; ?>" <?php echo ($tv == get_option('bibliapopup_body_txt_size')) ? 'selected="selected"' : ''; ?>><?php echo $tv; ?>px</option>
    <?php } ?>
                        </select>
                    </td>
                </tr>
            </table>
    <?php submit_button(); ?>
            <table style="border-right: 1px solid #333; width: 49%; float: left;">
                <tr>
                    <td colspan="2">
                        <h1>
                            Conhe&ccedil;a as varia&ccedil;&otilde;es
                        </h1>
                    </td>
                </tr>
                <tr>
                    <td>
                        <h3>
                            Livro Completo
                        </h3>
                    </td>
                    <td>
                        <h3>
                            Livro Abreviado
                        </h3>
                    </td>
                </tr>
                <tr>
                    <td>
                        - 1Jo&atilde;o 1:1 (junto, dois pontos)<br>
                        - 1Jo&atilde;o 1.1 (junto, ponto)<br>
                        - 1 Jo&atilde;o 1:1 (separado, dois pontos)<br>
                        - 1 Jo&atilde;o 1.1 (separado, ponto)<br>
                        - 1 Jo&atilde;o 1.1-5 (separado, ponto, sequencia)<br>
                        - 1Jo&atilde;o 1.1-5 (junto, dois pontos, sequencia)<br>
                        - 1 Jo&atilde;o 1.1-5 (separado, ponto, sequencia)<br>
                        - 1Jo&atilde;o 1:1-5 (junto, dois pontos, sequencia)<br>
                        - 1 Jo&atilde;o 1:1,3,5-7 (separado, dois pontos, v&iacute;rgula e sequencia)<br>
                        - 1Jo&atilde;o 1:1,3,5-7 (junto, dois pontos, v&iacute;rgula e sequencia)<br>
                        - 1 Jo&atilde;o 1.1,3,5-7 (separado, ponto, v&iacute;rgula e sequencia)<br>
                        - 1Jo&atilde;o 1.1,3,5-7 (junto, ponto, v&iacute;rgula e sequencia)<br>
                        - 1Jo&atilde;o 1.1,3,5 e 7 (junto, ponto, v&iacute;rgula e sequencia com "e")<br>
                        - 1 Jo&atilde;o 1.1,3,5 e 7 (separado, ponto, v&iacute;rgula e sequencia com "e")<br>
                    </td>
                    <td>
                        - 1Jo 1.1 (abreviado, junto, ponto)<br>
                        - 1 Jo 1.1 (abreviado, separado, ponto)<br>
                        - 1Jo 1:1 (abreviado, junto, dois pontos)<br>
                        - 1 Jo 1:1 (abreviado, separado, dois pontos)<br>
                        - 1 Jo 1.1-5 (abreviado, separado, ponto, sequencia)<br>
                        - 1Jo 1.1-5 (abreviado, junto, ponto, sequencia)<br>
                        - 1 Jo 1:1-5 (abreviado, separado, dois pontos, sequencia)<br>
                        - 1Jo 1:1-5 (abreviado, junto, dois pontos, sequencia)<br>
                        - 1 Jo 1.3,4,5-7 (abreviado, separado, ponto, v&iacute;rgula e sequencia)<br>
                        - 1Jo 1.3,4,5-7 (abreviado, junto, ponto, v&iacute;rgula e sequencia)<br>
                        - 1 Jo 1:3,4,5-7 (abreviado, separado, dois pontos, v&iacute;rgula e sequencia)<br>
                        - 1Jo 1:3,4,5-7 (abreviado, junto, dois pontos, v&iacute;rgula e sequencia)<br>
                        - 1Jo 1.1,3,5 e 7 (abreviado, junto, ponto, v&iacute;rgula e sequencia com "e")<br>
                        - 1 Jo 1.1,3,5 e 7 (abreviado, junto, ponto, v&iacute;rgula e sequencia com "e")<br>
                    </td>
                </tr>
            </table>
            <table style="width: 49%; float: left;margin-left: 15px;">
                <tr>
                    <td colspan="2">
                        <h1>
                            Conhe&ccedil;a a Vers&atilde;o PRO
                        </h1>
                    </td>
                </tr>
                <tr>
                    <td>

                    </td>
                    <th>
                        FREE
                    </th>
                    <th>
                        PRO
                    </th>
                </tr>
                <tr>
                    <td>
                        Selecionar Vers&atilde;o (NVI ou AA)
                    </td>
                    <td style="text-align: center;">
                        <img src="<?php echo plugin_dir_url(__FILE__) . "/img/no.png" ?>">
                    </td>
                    <td style="text-align: center;">
                        <img src="<?php echo plugin_dir_url(__FILE__) . "/img/yes.png" ?>">
                    </td>
                </tr>
                <tr>
                    <td>
                        Personalizar Fonte (Tamanho e Cor)
                    </td>
                    <td style="text-align: center;">
                        <img src="<?php echo plugin_dir_url(__FILE__) . "/img/no.png" ?>">
                    </td>
                    <td style="text-align: center;">
                        <img src="<?php echo plugin_dir_url(__FILE__) . "/img/yes.png" ?>">
                    </td>
                </tr>
                <tr>
                    <td>
                        Personalizar Cabe&ccedil;alho e Rodap&eacute;
                    </td>
                    <td style="text-align: center;">
                        <img src="<?php echo plugin_dir_url(__FILE__) . "/img/no.png" ?>">
                    </td>
                    <td style="text-align: center;">
                        <img src="<?php echo plugin_dir_url(__FILE__) . "/img/yes.png" ?>">
                    </td>
                </tr>
                <tr>
                    <td>
                        Remover cr&eacute;ditos do Desenvolvedor (rodap&eacute;)
                    </td>
                    <td style="text-align: center;">
                        <img src="<?php echo plugin_dir_url(__FILE__) . "/img/yes.png" ?>">
                    </td>
                    <td style="text-align: center;">
                        <img src="<?php echo plugin_dir_url(__FILE__) . "/img/no.png" ?>">
                    </td>
                </tr>
                <tr>
                    <td>

                    </td>
                    <td style="text-align: center;">
                        R$ 0,00
                    </td>
                    <td style="text-align: center;">
                        R$ 0,00<strong>*</strong>
                    </td>
                </tr>
                <tr>
                    <td colspan="3" style="text-align: center;">
                        &nbsp;
                    </td>
                </tr>
                <tr>
                    <td colspan="3" style="text-align: center;">
                        <strong>*</strong> A vers&atilde;o PRO &eacute; totalmente gratuita, para ter acesso aos recursos que ela oferece habilite os cr&eacute;ditos do desenvolvedor no campo "Exibir cr&eacute;ditos de <a href="//oevangelho.com">OEvangelho.com</a>", os cr&eacute;ditos aparecer&atilde;o nos rodap&eacute;s das Popups (tooltips) e modais geradas.
                    </td>
                </tr>
            </table>
            <table style="width: 100%;">
                <tr>
                    <td colspan="2">
                        <hr>
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <h1>
                            Ajude a manter o projeto gratuito fazendo uma doa&ccedil;&atilde;o
                        </h1>
                    </td>
                </tr>                
                <tr>
                    <td>
                        <a href="https://oevangelho.com/go/doar-pagseguro" target="_new"><img src="<?php echo plugin_dir_url(__FILE__) . "/img/doar_pagseguro.png" ?>"></a>
                        <a href="https://oevangelho.com/go/doar-paypal" target="_new"><img src="<?php echo plugin_dir_url(__FILE__) . "/img/doar_paypal.png" ?>"></a>
                    </td>
                </tr>
            </table>
        </form>
    </div>
    <?php
}

function bibliapopup_register_settings() {
    add_option('bibliapopup_creditos', '1');
    add_option('bibliapopup_versao', 'NVI');
    add_option('bibliapopup_header_color', '#5379bf');
    add_option('bibliapopup_header_txt_color', '#ffffff');
    add_option('bibliapopup_header_txt_size', '18');
    add_option('bibliapopup_subheader_color', '#4667a0');
    add_option('bibliapopup_subheader_txt_color', '#ffffff');
    add_option('bibliapopup_subheader_txt_size', '16');
    add_option('bibliapopup_footer_txt_color', '#ffffff');
    add_option('bibliapopup_footer_txt_size', '10');
    add_option('bibliapopup_body_color', '#e8ebf0');
    add_option('bibliapopup_body_txt_color', '#222222');
    add_option('bibliapopup_body_txt_size', '12');
    add_option("bibliapopup_avisoLido", 0);

    register_setting('bibliapopup_options_group', 'bibliapopup_creditos', 'bibliapopup_callback');
    register_setting('bibliapopup_options_group', 'bibliapopup_versao', 'bibliapopup_callback');
    register_setting('bibliapopup_options_group', 'bibliapopup_header_color', 'bibliapopup_callback');
    register_setting('bibliapopup_options_group', 'bibliapopup_header_txt_color', 'bibliapopup_callback');
    register_setting('bibliapopup_options_group', 'bibliapopup_header_txt_size', 'bibliapopup_callback');
    register_setting('bibliapopup_options_group', 'bibliapopup_subheader_color', 'bibliapopup_callback');
    register_setting('bibliapopup_options_group', 'bibliapopup_subheader_txt_color', 'bibliapopup_callback');
    register_setting('bibliapopup_options_group', 'bibliapopup_subheader_txt_size', 'bibliapopup_callback');
    register_setting('bibliapopup_options_group', 'bibliapopup_footer_txt_color', 'bibliapopup_callback');
    register_setting('bibliapopup_options_group', 'bibliapopup_footer_txt_size', 'bibliapopup_callback');
    register_setting('bibliapopup_options_group', 'bibliapopup_body_color', 'bibliapopup_callback');
    register_setting('bibliapopup_options_group', 'bibliapopup_body_txt_color', 'bibliapopup_callback');
    register_setting('bibliapopup_options_group', 'bibliapopup_body_txt_size', 'bibliapopup_callback');
}

add_action('admin_init', 'bibliapopup_register_settings');

function bibliapopup_filter_the_content($array) {
    $versao = (get_option('bibliapopup_creditos')) ? get_option('bibliapopup_versao') : "NVI";
    $mymodal = '
        <div id="myModal" class="modal">
            <!-- Modal content -->
            <div class="modal-content">
                <div class="modal-header-bpp">
                    <div class="header-pop" id="mytitle"></div>
                    <span class="close" id="close">&times;</span>                    
                </div>
                <div class="modal-subheader">
                    <a id="modalLink" href="http://oevangelho.com">
                        <div>Leia o cap&iacute;tulo inteiro</div>
                    </a>                   
                </div>
                <div class="modal-body" id="myverses">
                </div>
                <div class="modal-bpp-footer">';
    if (get_option("bibliapopup_creditos")) {
        $mymodal .= '<div style="margin-bottom: 1px;"><span id="versao">' . $versao . '</span>Desenvolvido por: <a href="http://oevangelho.com">OEvangelho.com</a><div>';
        $rodapeTool = 'Desenvolvido por: <a href=\"http://oevangelho.com\">OEvangelho.com</a>';
    } else {
        $mymodal .= '<div style="margin-bottom: 1px; display: none;">Desenvolvido por: <a href="http://oevangelho.com">OEvangelho.com</a><div>';
        $rodapeTool = '&nbsp;';
    }
    $mymodal .= '</div>
            </div>
        </div>
        <script>
            var bpom = jQuery.noConflict();
            bpom(function(){
               bpom(".myBtn").click(function (event) {
                    event.preventDefault();
                    
                    bpom("#myverses").html(\'<center><p>&nbsp;</p><p class="loadingText">Carregando vers&iacute;culos<p/><p><div class="windows8"><div class="wBall" id="wBall_1"><div class="wInnerBall"></div></div><div class="wBall" id="wBall_2"><div class="wInnerBall"></div></div><div class="wBall" id="wBall_3"><div class="wInnerBall"></div></div><div class="wBall" id="wBall_4"><div class="wInnerBall"></div></div><div class="wBall" id="wBall_5"><div class="wInnerBall"></div></div></div></p></center>\');
                    bpom("#mytitle").html("");
                    bpom("#myModal").css("display", "block");
                    var target = bpom(this);
                    var book = bpom(this).data("book");
                    var chapter = bpom(this).data("chapter");
                    var verses = bpom(this).data("verses");
                    
                    console.log(target.data("class"));
                    
                    var data = {
                        "action": "obter_verses",
                        "livro": book, 
                        "capitulo": chapter, 
                        "versiculos": verses
                        };
                    
                    bpom.post("' . admin_url('admin-ajax.php') . '", data, function(response) {
                        bpom("#myverses").html(response);
                    });
                    
                    var data2 = {
                        "action": "obter_link",
                        "livro": book, 
                        "capitulo": chapter
                        };

                    bpom.post("' . admin_url('admin-ajax.php') . '", data2, function(response) {
                        var url = bpom("#modalLink").attr("href");
                        var newUrl = url + response;
                        bpom("#modalLink").attr("href", newUrl);
                    });
                    
                    bpom("#mytitle").html(bpom(this).data("title"));
                    bpom("#mylink").html(book +" "+ chapter);
                });
                bpom("#close").click(function () {
                    bpom("#myModal").css("display", "none");
                });
                window.onclick = function (event) {
                    if (event.target == bpom("#myModal")) {
                        bpom("#myModal").css("display", "none");
                    }
                }
            });
        </script>
        <script>
            var bpop = jQuery.noConflict();
            bpop(window).bind("load", function(){
                
                bpop(".popover_title").each(function() {
                    
                    var target = bpop(this);
                    var book = bpop(this).data("book");
                    var chapter = bpop(this).data("chapter");
                    var verses = bpop(this).data("verses");
                                        
                    var data = {
                        "action": "obter_verses",
                        "livro": book, 
                        "capitulo": chapter, 
                        "versiculos": verses
                        };
                    
                    bpop.post("' . admin_url('admin-ajax.php') . '", data, function(response) {
                        target.attr("data-conteudo", response);
                        bpop("."+target.data("class")+"_content").html(response);
                    });
                    
                    var data2 = {
                        "action": "obter_link",
                        "livro": book, 
                        "capitulo": chapter
                        };
                    
                    bpop.post("' . admin_url('admin-ajax.php') . '", data2, function(response) {
                        var url = bpom("#modalLink").attr("href");
                        var newUrl = "http://oevangelho.com" + response;
                        target.attr("data-link", newUrl);
                        bpop("."+target.data("class")+"_header").html("<a href=\"" + newUrl + "\" target=\"_blank\">Leia o cap&iacute;tulo inteiro</a>");
                    });
                });
                
                bpop(".popover_title").on("mouseover", function(){     
                    
                    bpop("."+bpop(this).data("class")+"_header").html("<a href=\"" + bpop(this).data("link") + "\" target=\"_blank\">Leia o cap&iacute;tulo inteiro</a>");
                    
                    var target = bpop(this);
                    var book = bpop(this).data("book");
                    var chapter = bpop(this).data("chapter");
                    var verses = bpop(this).data("verses");
                    var title = bpop(this).data("title");
                    var content = bpop(this).data("conteudo");
                    var link = (bpop(this).data("link") == undefined) ? "" : "<a href=\"" + bpop(this).data("link") + "\" target=\"_blank\">Leia o cap&iacute;tulo inteiro</a>" ;

                    var data = {
                        "action": "obter_verses",
                        "livro": book, 
                        "capitulo": chapter, 
                        "versiculos": verses,
                        "titulo": title
                        };
                    
                   console.log(bpop(this).data("conteudo"));
                    
                    if(content != undefined){
                        
                        var conteudo = content;
                    
                    }else{                    
                        
                        var conteudo = \'<center><p class="loadingText">Carregando vers&iacute;culos<p/><p><div class="windows8"><div class="wBall" id="wBall_1"><div class="wInnerBall"></div></div><div class="wBall" id="wBall_2"><div class="wInnerBall"></div></div><div class="wBall" id="wBall_3"><div class="wInnerBall"></div></div><div class="wBall" id="wBall_4"><div class="wInnerBall"></div></div><div class="wBall" id="wBall_5"><div class="wInnerBall"></div></div></div></p></center>\';

                    }
                    
                    tippy("."+bpop(this).data("class")+"", {
                        arrow: false,
                        size: "large",
                        theme: "light",
                        interactive: "hover",
                        placement: "bottom",
                        content: "<div class=\"headerTool\">" + target.data("title") + "</div><div class=\"tippy-subheader "+bpop(this).data("class")+"_header\"></div><div class=\""+bpop(this).data("class")+"_content\" style=\"padding: 10px 7px; min-width: 330px;\">" + conteudo + "</div><div class=\"footerTool\"><span id=\"versao\">' . $versao . '</span>' . $rodapeTool . '</div>"
                    })
                    
                    const btn = document.querySelector("."+bpop(this).data("class")+"");
                    const tip = btn._tippy;
                    tip.setContent("<div class=\"headerTool\">" + target.data("title") + "</div><div class=\"tippy-subheader "+bpop(this).data("class")+"_header\">" + link + "</div><div class=\""+bpop(this).data("class")+"_content\" style=\"padding: 10px 7px; min-width: 330px;\">" + conteudo + "</div><div class=\"footerTool\"><span id=\"versao\">' . $versao . '</span>' . $rodapeTool . '</div>");
                });
            });
        </script>';
    return bibliapopup_searchMention($array) . $mymodal;
}

function sortArray($a, $b) {
    return strlen($b) - strlen($a);
}

// add the filter 
add_filter('the_content', 'bibliapopup_filter_the_content', 10);

function bibliapopup_searchMention($string) {
    $ident = 10;
    $matches = [];
    preg_match_all("/(\d ){0,1}([\w|á|à|ã|â|ä|Á|À|Ã|Â|Ä|é|è|ê|ë|É|È|Ê|Ë|í|ì|î|ï|Í|Ì|Î|Ï|ó|ò|õ|ô|ö|Ó|Ò|Õ|Ô|Ö|ú|ù|û|ü|Ú|Ù|Û|Ü|ñ|Ñ]){2,} (\d+)\.([0-9A-z,\-\–])+([\se0-9])+/", $string, $matches);
    usort($matches[0], 'sortArray');
    foreach ($matches[0] as $citacao) {
        ++$ident;
        $convert[$ident] = bibliapopup_separaPt($citacao, $ident);
        $refs[$ident] = $ident . 'citacao';
        $string = str_replace($citacao, $ident . 'citacao', $string);
    }

    $matches2 = [];
    preg_match_all("/(\d ){0,1}([\w|á|à|ã|â|ä|Á|À|Ã|Â|Ä|é|è|ê|ë|É|È|Ê|Ë|í|ì|î|ï|Í|Ì|Î|Ï|ó|ò|õ|ô|ö|Ó|Ò|Õ|Ô|Ö|ú|ù|û|ü|Ú|Ù|Û|Ü|ñ|Ñ]){2,} (\d){1,}\.([0-9A-z,\-\–])+/", $string, $matches2);
    usort($matches2[0], 'sortArray');
    foreach ($matches2[0] as $citacao2) {
        ++$ident;
        $convert[$ident] = bibliapopup_separaPt($citacao2, $ident);
        $refs[$ident] = $ident . 'citacao';
        $string = str_replace($citacao2, $ident . 'citacao', $string);
    }

    $matches4 = [];
    preg_match_all("/(\d ){0,1}([\w|á|à|ã|â|ä|Á|À|Ã|Â|Ä|é|è|ê|ë|É|È|Ê|Ë|í|ì|î|ï|Í|Ì|Î|Ï|ó|ò|õ|ô|ö|Ó|Ò|Õ|Ô|Ö|ú|ù|û|ü|Ú|Ù|Û|Ü|ñ|Ñ]){2,} (\d){1,}:([0-9A-z,\-\–])+/", $string, $matches4);
    usort($matches4[0], 'sortArray');
    foreach ($matches4[0] as $citacao4) {
        ++$ident;
        $convert[$ident] = bibliapopup_separa2Pt($citacao4, $ident);
        $refs[$ident] = $ident . 'citacao';
        $string = str_replace($citacao4, $ident . 'citacao', $string);
    }

    $matches3 = [];
    preg_match_all("/(\d ){0,1}([\w|á|à|ã|â|ä|Á|À|Ã|Â|Ä|é|è|ê|ë|É|È|Ê|Ë|í|ì|î|ï|Í|Ì|Î|Ï|ó|ò|õ|ô|ö|Ó|Ò|Õ|Ô|Ö|ú|ù|û|ü|Ú|Ù|Û|Ü|ñ|Ñ]){2,} (\d+):([0-9A-z,\-\–])+([\se0-9])+/", $string, $matches3);
    usort($matches3[0], 'sortArray');
    foreach ($matches3[0] as $citacao3) {
        ++$ident;
        $convert[$ident] = bibliapopup_separa2Pt($citacao3, $ident);
        $refs[$ident] = $ident . 'citacao';
        $string = str_replace($citacao3, $ident . 'citacao', $string);
    }

    return str_replace($refs, $convert, $string);
}

function bibliapopup_separaPt($mencao, $ident) {
    $mparts = explode('.', $mencao);
    $liv = explode(' ', $mparts[0]);
    $livro = bibliapopup_retiraSoAcentos((count($liv) > 2) ? $liv[0] . $liv[1] : $liv[0]);
    $capitulo = (count($liv) > 2) ? $liv[2] : $liv[1];
    $mparts[1] = str_replace(array(' ', 'e', '–'), array('', ',', '-'), $mparts[1]);
    $ver = [];

    if (!stripos($mparts[1], ' e ') && !stripos($mparts[1], '-')) {
        $versiculos = $mparts[1];
    } elseif (preg_match_all("/[0-9]{0,2}[\-]{1}[0-9]{0,2}/", $mparts[1], $ver)) {
        $vers = explode('-', $ver[0][0]);
        for ($i = $vers[0]; $i <= $vers[1]; $i++) {
            $v[] = $i;
        }
        $alter = implode(',', $v);
        $versiculos = str_replace($ver[0][0], $alter, $mparts[1]);
    }

    return '<a class="myBtn show-bpp-mob" data-title="' . htmlspecialchars($mencao) . '" data-book="' . $livro . '" data-chapter="' . $capitulo . '" data-verses="' . $versiculos . '">' . $mencao . '</a><a class="popover_title hide-bpp-mob pt' . str_replace(explode('|', ',|.| |-|–|:'), array("", "", "", "", "", ""), bibliapopup_retiraAcentos($mencao)) . $ident . '" data-class="pt' . str_replace(explode('|', ',|.| |-|–|:'), array("", "", "", "", "", ""), bibliapopup_retiraAcentos($mencao)) . $ident . '" data-title="' . htmlspecialchars($mencao) . '" data-book="' . $livro . '" data-chapter="' . $capitulo . '" data-verses="' . $versiculos . '">' . $mencao . '</a>';
}

function bibliapopup_separa2Pt($mencao, $ident) {
    $mparts = explode(':', $mencao);
    $liv = explode(' ', $mparts[0]);
    $livro = bibliapopup_retiraSoAcentos((count($liv) > 2) ? $liv[0] . $liv[1] : $liv[0]);
    $capitulo = (count($liv) > 2) ? $liv[2] : $liv[1];
    $mparts[1] = str_replace(array(' ', 'e', '–'), array('', ',', '-'), $mparts[1]);
    $ver = [];

    if (!stripos($mparts[1], ' e ') && !stripos($mparts[1], '-')) {
        $versiculos = $mparts[1];
    } elseif (preg_match_all("/[0-9]{0,2}[\-]{1}[0-9]{0,2}/", $mparts[1], $ver)) {
        $vers = explode('-', $ver[0][0]);
        for ($i = $vers[0]; $i <= $vers[1]; $i++) {
            $v[] = $i;
        }
        $alter = implode(',', $v);
        $versiculos = str_replace($ver[0][0], $alter, $mparts[1]);
    }

    return '<a class="myBtn show-bpp-mob" data-title="' . htmlspecialchars($mencao) . '" data-book="' . $livro . '" data-chapter="' . $capitulo . '" data-verses="' . $versiculos . '">' . $mencao . '</a><a class="popover_title hide-bpp-mob dpt' . str_replace(explode('|', ',|.| |-|–|:'), array("", "", "", "", "", ""), bibliapopup_retiraAcentos($mencao)) . $ident . '" data-class="dpt' . str_replace(explode('|', ',|.| |-|–|:'), array("", "", "", "", "", ""), bibliapopup_retiraAcentos($mencao)) . $ident . '" data-title="' . htmlspecialchars($mencao) . '" data-book="' . $livro . '" data-chapter="' . $capitulo . '" data-verses="' . $versiculos . '">' . $mencao . '</a>';
}

add_action('wp_ajax_obter_verses', 'bibliapopup_obterVers');
add_action('wp_ajax_nopriv_obter_verses', 'bibliapopup_obterVers');

function bibliapopup_obterVers() {
    $livro = strtolower($_REQUEST["livro"]);
    $capitulo = $_REQUEST["capitulo"];
    $verses = array_filter(explode(',', $_REQUEST["versiculos"]));
    $nverses = implode(',', $verses);
    $titulo = $_REQUEST["titulo"];
    $versao = (get_option('bibliapopup_creditos')) ? get_option('bibliapopup_versao') : "NVI";

    global $wpdb;

    $tbl = $wpdb->prefix . 'versiculos';
    $tbl2 = $wpdb->prefix . 'livros';

    $versiculos = $wpdb->get_results("SELECT v.verse, v.text FROM {$tbl} AS v "
            . "INNER JOIN $tbl2 AS l ON (v.book = l.id) "
            . "WHERE v.version = '{$versao}' AND "
            . "(l.abbrev = '{$livro}' OR l.link = '{$livro}') AND "
            . "chapter = {$capitulo} AND "
            . "verse IN ({$nverses})", OBJECT);

    foreach ($versiculos as $versiculo) {
        echo '<span class="verNum">' . $versiculo->verse . ".</span> " . $versiculo->text . "<br>";
    }

    die();
}

add_action('wp_ajax_obter_link', 'bibliapopup_obterLink');
add_action('wp_ajax_nopriv_obter_link', 'bibliapopup_obterLink');

function bibliapopup_obterLink() {
    $livro = strtolower($_REQUEST["livro"]);
    $capitulo = $_REQUEST["capitulo"];
    $versao = (get_option('bibliapopup_creditos')) ? get_option('bibliapopup_versao') : "NVI";

    global $wpdb;

    $tbl = $wpdb->prefix . 'versiculos';
    $tbl2 = $wpdb->prefix . 'livros';

    $versiculos = $wpdb->get_results("SELECT * FROM {$tbl} AS v "
            . "INNER JOIN $tbl2 AS l ON (v.book = l.id) "
            . "WHERE v.version = '{$versao}' AND "
            . "(l.abbrev = '{$livro}' OR l.link = '{$livro}') AND "
            . "chapter = {$capitulo} GROUP BY v.book, v.chapter", OBJECT);
    foreach ($versiculos as $versiculo) {
        echo "/biblia/" . $versiculo->version . "/" . $versiculo->link . "_" . $capitulo;
    }

    die();
}

function bibliapopup_retiraAcentos($str) {
    return preg_replace(explode(' ', '/(1)/ /(2)/ /(3)/ /(á|à|ã|â)/ /(é|è|ê)/ /(í|ì|î)/ /(ó|ò|õ|ô)/ /(ú|ù|û)/ /(Á|À|Ã|Â)/ /(É|È|Ê)/ /(Í|Ì|Î)/ /(Ó|Ò|Õ|Ô)/ /(Ú|Ù|Û)/'), explode(' ', 'u d t A E I O U a e i o u'), $str);
}

function bibliapopup_retiraSoAcentos($str) {
    return preg_replace(explode(' ', '/(á|à|ã|â)/ /(é|è|ê)/ /(í|ì|î)/ /(ó|ò|õ|ô)/ /(ú|ù|û)/ /(Á|À|Ã|Â)/ /(É|È|Ê)/ /(Í|Ì|Î)/ /(Ó|Ò|Õ|Ô)/ /(Ú|Ù|Û)/'), explode(' ', 'A E I O U a e i o u'), $str);
}

function bibliapopup_styles_method() {

    $bibliapopup_versao = get_option('bibliapopup_versao');
    $bibliapopup_header_color = get_option('bibliapopup_header_color');
    $bibliapopup_header_txt_color = get_option('bibliapopup_header_txt_color');
    $bibliapopup_header_txt_size = get_option('bibliapopup_header_txt_size');
    $bibliapopup_subheader_color = get_option('bibliapopup_subheader_color');
    $bibliapopup_subheader_txt_color = get_option('bibliapopup_subheader_txt_color');
    $bibliapopup_subheader_txt_size = get_option('bibliapopup_subheader_txt_size');
    $bibliapopup_footer_txt_color = get_option('bibliapopup_footer_txt_color');
    $bibliapopup_footer_txt_size = get_option('bibliapopup_footer_txt_size');
    $bibliapopup_body_color = get_option('bibliapopup_body_color');
    $bibliapopup_body_txt_color = get_option('bibliapopup_body_txt_color');
    $bibliapopup_body_txt_size = get_option('bibliapopup_body_txt_size');

    $custom_css = "
        /* The Modal (background) */
.modal {
    display: none; /* Hidden by default */
    position: fixed; /* Stay in place */
    z-index: 999999999; /* Sit on top */
    left: 0;
    top: 0;
    width: 100%; /* Full width */
    height: 100%; /* Full height */
    overflow: auto; /* Enable scroll if needed */
    background-color: rgb(0,0,0); /* Fallback color */
    background-color: rgba(0,0,0,0.4); /* Black w/ opacity */
    -webkit-animation-name: fadeIn; /* Fade in the background */
    -webkit-animation-duration: 0.4s;
    animation-name: fadeIn;
    animation-duration: 0.4s
}

/* Modal Content */
.modal-content {
    position: fixed;
    bottom: 0;
    z-index: 999999;
    background-color: " . $bibliapopup_body_color . ";
    width: 100%;
    height: 100%;
    -webkit-animation-name: slideIn;
    -webkit-animation-duration: 0.4s;
    animation-name: slideIn;
    animation-duration: 0.4s;
}

/* The Close Button */
.close {
    color: #fff;
    float: right;
    font-size: 28px;
    font-weight: bold;
}

.close:hover,
.close:focus {
    color: #ddd;
    text-decoration: none;
    cursor: pointer;
}

.loadingText{
    color: " . $bibliapopup_body_txt_color . " !important;
}

.modal-header-bpp {
    padding: 2px 16px !important;
    background-color: " . $bibliapopup_header_color . " !important;
    color: " . $bibliapopup_header_txt_color . " !important;
    height: 50px !important;
    z-index: 999999;
}
.modal-subheader{
    padding: 2px 16px !important;
    background-color: " . $bibliapopup_subheader_color . " !important;
    color: " . $bibliapopup_subheader_txt_color . " !important;
    height: 30px;
    z-index: 999999;
}

.modal-subheader a, .modal-subheader a:hover {
    color: " . $bibliapopup_subheader_txt_color . " !important;
    font-size: " . $bibliapopup_subheader_txt_size . "px;
}

.tippy-subheader{
    padding: 7px 16px;
    background-color: " . $bibliapopup_subheader_color . " !important;
    color: " . $bibliapopup_subheader_txt_color . " !important;
    height: 30px;
    z-index: 999999;
}

.tippy-subheader a, .tippy-subheader a:hover {
    color: " . $bibliapopup_subheader_txt_color . ";
    font-size: " . ($bibliapopup_subheader_txt_size - 4) . "px;
}

.header-pop {
    font-size: 20px;
    padding-top: 7px !important;
    font-weight: 900;
    float: left;
    z-index: 999999;
}

.modal-body {
    padding: 5px 5px;
    height: calc(100% - 100px);
    z-index: 999998;
    overflow-y: auto;
    overflow-x: no-display;
    color: " . $bibliapopup_body_txt_color . " !important;
}

.modal-bpp-footer, modal-bpp-footer a{
    padding: 0px !important;
    background-color: " . $bibliapopup_header_color . ";
    color: " . $bibliapopup_footer_txt_color . " !important;
    margin-bottom: 0px;
    height: 20px;
    font-size: " . $bibliapopup_footer_txt_size . "px;
    line-height: 20px !important;
    text-align: right;
    z-index: 999999;
}

.modal-bpp-footer a{
    color: " . $bibliapopup_footer_txt_color . " !important;
    text-decoration: none !important;
    font-weight: bold !important;
    box-shadow: none !important;
    margin-right: 3px;
}

.modal-bpp-footer #versao{
    font-size: " . $bibliapopup_footer_txt_size . "px;
    float: left !important;
    margin-left: 3px;
}

/* Add Animation */
@-webkit-keyframes slideIn {
    from {bottom: -300px; opacity: 0} 
    to {bottom: 0; opacity: 1}
}

@keyframes slideIn {
    from {bottom: -300px; opacity: 0}
    to {bottom: 0; opacity: 1}
}

@-webkit-keyframes fadeIn {
    from {opacity: 0} 
    to {opacity: 1}
}

@keyframes fadeIn {
    from {opacity: 0} 
    to {opacity: 1}
}

.tippy-content{
    text-align: left;
    font-size: " . $bibliapopup_body_txt_size . "px;
    background-color: " . $bibliapopup_body_color . ";
    color: " . $bibliapopup_body_txt_color . " !important;
}

.tippy-tooltip.light-theme .tippy-backdrop {
    background-color: #FFF;
    color: #000;
}

/* If `animateFill: false` */
.tippy-tooltip.light-theme {
    background-color: #fff;
    border: 2px solid #fff;
    color: #000;
    padding: 8px;
    border-radius: 4px;
    box-shadow: 2px 2px 10px 0px #888888;
}

.tippy-popper[x-placement^='top'] .tippy-tooltip.light-theme .tippy-arrow {
    border-top-color: #fff;
}
.tippy-popper[x-placement^='bottom'] .tippy-tooltip.light-theme .tippy-arrow {
    border-bottom-color: #fff;
}
.tippy-popper[x-placement^='left'] .tippy-tooltip.light-theme .tippy-arrow {
    border-left-color: #fff;
}
.tippy-popper[x-placement^='right'] .tippy-tooltip.light-theme .tippy-arrow {
    border-right-color: #fff;
}
/* Round arrow */
.tippy-tooltip.light-theme .tippy-roundarrow {
    fill: #fff;
}

.verNum{
    font-weight: bold;
}

.popover_title{
    cursor: pointer;
}

.headerTool{
    background: " . $bibliapopup_header_color . ";
    font-size: " . $bibliapopup_header_txt_size . "px;
    text-align: center;
    color: " . $bibliapopup_header_txt_color . ";
    padding: 4px;
    border-radius: 4px 4px 0px 0px;
}

.footerTool, .footerTool a{
    background: " . $bibliapopup_header_color . ";
    font-size: " . $bibliapopup_footer_txt_size . "px;
    text-align: right;
    color: " . $bibliapopup_footer_txt_color . ";
    padding: 3px;
    border-radius: 0px 0px 4px 4px;
}

.footerTool a{
    text-decoration: none;
    font-weight: bold;
}

.footerTool #versao{
    font-size: " . $bibliapopup_footer_txt_size . "px;
    float: left !important;
}

@media only screen and (max-width: 480px), only screen and (max-device-width: 480px) {
    .show-bpp-mob{ display: inline !important; }
    .hide-bpp-mob{ display: none !important; white-space: nowrap;}
}
@media only screen and (max-width:768px), only screen and (max-device-width: 768px) {
    .show-bpp-mob{ display: inline !important; }
    .hide-bpp-mob{ display: none !important; white-space: nowrap;}
}
@media only screen and (min-width:769px){
    .show-bpp-mob{ display: none !important; }
    .hide-bpp-mob{ display: inline !important; white-space: nowrap;}
}
@media only screen and (min-width:1200px){
    .show-bpp-mob{ display: none !important; }
    .hide-bpp-mob{ display: inline !important; white-space: nowrap;}
}

.windows8 {
	position: relative;
	width: 26px;
	height:26px;
	margin:auto;
}

.windows8 .wBall {
	position: absolute;
	width: 25px;
	height: 25px;
	opacity: 0;
	transform: rotate(225deg);
		-o-transform: rotate(225deg);
		-ms-transform: rotate(225deg);
		-webkit-transform: rotate(225deg);
		-moz-transform: rotate(225deg);
	animation: orbit 6.96s infinite;
		-o-animation: orbit 6.96s infinite;
		-ms-animation: orbit 6.96s infinite;
		-webkit-animation: orbit 6.96s infinite;
		-moz-animation: orbit 6.96s infinite;
}

.windows8 .wBall .wInnerBall{
	position: absolute;
	width: 3px;
	height: 3px;
	background: {$bibliapopup_body_txt_color};
	left:0px;
	top:0px;
	border-radius: 3px;
}

.windows8 #wBall_1 {
	animation-delay: 1.52s;
		-o-animation-delay: 1.52s;
		-ms-animation-delay: 1.52s;
		-webkit-animation-delay: 1.52s;
		-moz-animation-delay: 1.52s;
}

.windows8 #wBall_2 {
	animation-delay: 0.3s;
		-o-animation-delay: 0.3s;
		-ms-animation-delay: 0.3s;
		-webkit-animation-delay: 0.3s;
		-moz-animation-delay: 0.3s;
}

.windows8 #wBall_3 {
	animation-delay: 0.61s;
		-o-animation-delay: 0.61s;
		-ms-animation-delay: 0.61s;
		-webkit-animation-delay: 0.61s;
		-moz-animation-delay: 0.61s;
}

.windows8 #wBall_4 {
	animation-delay: 0.91s;
		-o-animation-delay: 0.91s;
		-ms-animation-delay: 0.91s;
		-webkit-animation-delay: 0.91s;
		-moz-animation-delay: 0.91s;
}

.windows8 #wBall_5 {
	animation-delay: 1.22s;
		-o-animation-delay: 1.22s;
		-ms-animation-delay: 1.22s;
		-webkit-animation-delay: 1.22s;
		-moz-animation-delay: 1.22s;
}



@keyframes orbit {
	0% {
		opacity: 1;
		z-index:99;
		transform: rotate(180deg);
		animation-timing-function: ease-out;
	}

	7% {
		opacity: 1;
		transform: rotate(300deg);
		animation-timing-function: linear;
		origin:0%;
	}

	30% {
		opacity: 1;
		transform:rotate(410deg);
		animation-timing-function: ease-in-out;
		origin:7%;
	}

	39% {
		opacity: 1;
		transform: rotate(645deg);
		animation-timing-function: linear;
		origin:30%;
	}

	70% {
		opacity: 1;
		transform: rotate(770deg);
		animation-timing-function: ease-out;
		origin:39%;
	}

	75% {
		opacity: 1;
		transform: rotate(900deg);
		animation-timing-function: ease-out;
		origin:70%;
	}

	76% {
	opacity: 0;
		transform:rotate(900deg);
	}

	100% {
	opacity: 0;
		transform: rotate(900deg);
	}
}

@-o-keyframes orbit {
	0% {
		opacity: 1;
		z-index:99;
		-o-transform: rotate(180deg);
		-o-animation-timing-function: ease-out;
	}

	7% {
		opacity: 1;
		-o-transform: rotate(300deg);
		-o-animation-timing-function: linear;
		-o-origin:0%;
	}

	30% {
		opacity: 1;
		-o-transform:rotate(410deg);
		-o-animation-timing-function: ease-in-out;
		-o-origin:7%;
	}

	39% {
		opacity: 1;
		-o-transform: rotate(645deg);
		-o-animation-timing-function: linear;
		-o-origin:30%;
	}

	70% {
		opacity: 1;
		-o-transform: rotate(770deg);
		-o-animation-timing-function: ease-out;
		-o-origin:39%;
	}

	75% {
		opacity: 1;
		-o-transform: rotate(900deg);
		-o-animation-timing-function: ease-out;
		-o-origin:70%;
	}

	76% {
	opacity: 0;
		-o-transform:rotate(900deg);
	}

	100% {
	opacity: 0;
		-o-transform: rotate(900deg);
	}
}

@-ms-keyframes orbit {
	0% {
		opacity: 1;
		z-index:99;
		-ms-transform: rotate(180deg);
		-ms-animation-timing-function: ease-out;
	}

	7% {
		opacity: 1;
		-ms-transform: rotate(300deg);
		-ms-animation-timing-function: linear;
		-ms-origin:0%;
	}

	30% {
		opacity: 1;
		-ms-transform:rotate(410deg);
		-ms-animation-timing-function: ease-in-out;
		-ms-origin:7%;
	}

	39% {
		opacity: 1;
		-ms-transform: rotate(645deg);
		-ms-animation-timing-function: linear;
		-ms-origin:30%;
	}

	70% {
		opacity: 1;
		-ms-transform: rotate(770deg);
		-ms-animation-timing-function: ease-out;
		-ms-origin:39%;
	}

	75% {
		opacity: 1;
		-ms-transform: rotate(900deg);
		-ms-animation-timing-function: ease-out;
		-ms-origin:70%;
	}

	76% {
	opacity: 0;
		-ms-transform:rotate(900deg);
	}

	100% {
	opacity: 0;
		-ms-transform: rotate(900deg);
	}
}

@-webkit-keyframes orbit {
	0% {
		opacity: 1;
		z-index:99;
		-webkit-transform: rotate(180deg);
		-webkit-animation-timing-function: ease-out;
	}

	7% {
		opacity: 1;
		-webkit-transform: rotate(300deg);
		-webkit-animation-timing-function: linear;
		-webkit-origin:0%;
	}

	30% {
		opacity: 1;
		-webkit-transform:rotate(410deg);
		-webkit-animation-timing-function: ease-in-out;
		-webkit-origin:7%;
	}

	39% {
		opacity: 1;
		-webkit-transform: rotate(645deg);
		-webkit-animation-timing-function: linear;
		-webkit-origin:30%;
	}

	70% {
		opacity: 1;
		-webkit-transform: rotate(770deg);
		-webkit-animation-timing-function: ease-out;
		-webkit-origin:39%;
	}

	75% {
		opacity: 1;
		-webkit-transform: rotate(900deg);
		-webkit-animation-timing-function: ease-out;
		-webkit-origin:70%;
	}

	76% {
	opacity: 0;
		-webkit-transform:rotate(900deg);
	}

	100% {
	opacity: 0;
		-webkit-transform: rotate(900deg);
	}
}

@-moz-keyframes orbit {
	0% {
		opacity: 1;
		z-index:99;
		-moz-transform: rotate(180deg);
		-moz-animation-timing-function: ease-out;
	}

	7% {
		opacity: 1;
		-moz-transform: rotate(300deg);
		-moz-animation-timing-function: linear;
		-moz-origin:0%;
	}

	30% {
		opacity: 1;
		-moz-transform:rotate(410deg);
		-moz-animation-timing-function: ease-in-out;
		-moz-origin:7%;
	}

	39% {
		opacity: 1;
		-moz-transform: rotate(645deg);
		-moz-animation-timing-function: linear;
		-moz-origin:30%;
	}

	70% {
		opacity: 1;
		-moz-transform: rotate(770deg);
		-moz-animation-timing-function: ease-out;
		-moz-origin:39%;
	}

	75% {
		opacity: 1;
		-moz-transform: rotate(900deg);
		-moz-animation-timing-function: ease-out;
		-moz-origin:70%;
	}

	76% {
	opacity: 0;
		-moz-transform:rotate(900deg);
	}

	100% {
	opacity: 0;
		-moz-transform: rotate(900deg);
	}
    }";
    wp_add_inline_style('bibliapopup', $custom_css);
}

if (get_option("bibliapopup_creditos")) {
    add_action('wp_enqueue_scripts', 'bibliapopup_styles_method');
}    