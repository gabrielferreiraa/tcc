$(document).ready(function(){window.rate=0;const t=$(".panel-heading").width();$(".panel-body").css("width",t-95),moment.locale("pt-br"),$('a[data-toggle="pill"]').on("shown.bs.tab",function(t){const e=".date-end",a="DD/MM/YYYY",o=$($(t.target).attr("href"));if($(t.target).attr("href").match(/prazo/)){const s=moment(o.find(e).text(),a),n=moment(moment().format(a),a),r=n.diff(s,"days"),i=r>0?r:r*-1,c=n>s?"subtract":"add",d="add"==c?"será ":"foi ";o.find(e).text(null).append(d+"<b>"+moment()[c](i,"days").calendar().toLowerCase()+"</b>")}}),$(".escolho-voce").on("click",function(){const t=webroot+"/projects/fixUserProject",e={project:$(this).data("project"),user:$(this).data("user"),userName:$(this).data("user_name")};$.post(t,e,function(t){"success"===t.result.status?($("#collapse"+e.project).find(".user-"+e.user).addClass("fixed"),$(this).html('<i class="fa fa-check-circle"></i> '+e.userName.toUpperCase()+" FOI ESCOLHIDO").addClass("white"),Messenger().post({message:t.result.data,type:"success",showCloseButton:!0})):Messenger().post({message:t.result.data,type:"error",showCloseButton:!0})}.bind(this),"json")}),$(".open-partner").on("click",function(){var t=webroot+"projects/show-partner",e=$(".project-window-"+$(this).data("project"));e.toggleClass("open");var a=$(this).data("dev").split("-"),o={id:a[0]},s="contractor"==a[1]?"Contratante":"Freelancer";$.post(t,o,function(t){if("success"===t.result.status){null!==t.result.data.picture&&e.find("img").attr("src",t.result.data.picture),e.find(".name").text(t.result.data.name),e.find(".created").text(s+" desde "+t.result.data.created),e.find(".finished").html("Projeto finalizados: <span>"+t.result.data.finished+"</span>");var a=e.find("button");a.on("click",function(){window.location.href=webroot+"visualizar-perfil/"+t.result.data.id})}},"json")}),$(".star-input").change(function(){var t=$(this);const e={1:"Péssimo :´(",2:"Ruim :(",3:"Regular :l",4:"Bom :)",5:"Ótimo :D"};window.rate=t.attr("value"),$(".rate").text(e[t.attr("value")])}),$(".open-modal-reputation").on("click",function(t){$("#reputation-"+$(this).data("project")).modal("show")}),$(".finishProject").on("click",function(t){const e=webroot+"projects/finish-project",a={project:$(this).data("project"),rate:window.rate};$.post(e,a,function(t){},"json")}),$(".open-anexo").click(function(){$("#project-file-"+$(this).data("project")).modal("show")})});