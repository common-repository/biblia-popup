(function () {
    /*tinymce.PluginManager.add('ttip_shortcode_button', function (editor, url) {
     editor.addButton('ttip_shortcode_button', {
     text: ' Bíblia Popup',
     image: url + '/biblia.png',
     onclick: function () {
     // Get the modal
     var modal = document.getElementById('myModal');
     var btn = document.getElementById("myBtn");
     var addshort = document.getElementById("addShort");
     var span = document.getElementsByClassName("close")[0];
     modal.style.display = "block";
     span.onclick = function () {
     modal.style.display = "none";
     }
     window.onclick = function (event) {
     if (event.target == modal) {
     modal.style.display = "none";
     }
     }
     addshort.onclick = function () {
     var versao = document.getElementById('versoes');
     var livro = document.getElementById('livros');
     var capitulo = document.getElementById('capitulos');
     var versiculo = document.getElementById('versiculos');
     
     editor.insertContent('[bibliapopup versao="' + versao.value + '" livro="' + livro.value + '" capitulo="' + capitulo.value + '" versiculos="' + versiculo.value + '"]');
     modal.style.display = "none";
     }
     }});
     });*/


    jQuery('.color-field').wpColorPicker();
})();