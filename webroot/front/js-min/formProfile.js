$(document).ready(function(){function e(){const e=webroot+"utils/populate-cities",t={state:$(this).val()};$.post(e,t,function(e){var t=$("#city-id"),n="";$.each(e.result.data,function(e,t){n+='<option value="'+e+'">'+t+"</option>"}),t.html(n)},"json")}function t(){const e=$("#cep").val().replace("-","");$.get("http://api.postmon.com.br/v1/cep/"+e,function(e){var t=$("#state-id"),n=$("#city-id"),a=t.find("option"),o=n.find("option");a.map(function(a,o){o.text.toLowerCase()==e.estado_info.nome.toLowerCase()&&(t.val(a),n.trigger("change"))}),o.map(function(t,a){a.text.toLowerCase()==e.cidade.toLowerCase()&&(n.val(t),n.trigger("change"))}),"undefined"!=typeof e.logradouro&&$("#street").val(e.logradouro)})}function n(){$("#picture-image").trigger("click")}function a(e){o(this.files)}function o(e){if(e&&e[0]){var t=new FileReader;t.onload=function(e){$(".img-user").attr("src",e.target.result),$("#picture").val(e.target.result)},t.readAsDataURL(e[0])}}$("#skills-ids").select2({minimumInputLength:1,escapeMarkup:function(e){switch(e){case"Please enter 1 or more characters":return"Informe 1 ou mais caracteres";case"Searching…":return"Procurando...";case"No results found":return"Nada encontrado";default:return e}},language:{noResults:function(){return"Habilidade não encontrada"}}});var r=function(e){return 11===e.replace(/\D/g,"").length?"(00) 00000-0000":"(00) 0000-00009"},i={onKeyPress:function(e,t,n,a){n.mask(r.apply({},arguments),a)}};$("#cel-phone").mask(r,i),$("#cep").mask("00000-000"),$("#state-id").change(e),$(".btn-buscar-cep").click(t),$(".img-user").click(n),$("#picture-image").change(a)});