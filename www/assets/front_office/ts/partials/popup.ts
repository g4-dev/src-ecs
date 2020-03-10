import * as $ from "jquery";

$('.connect-pop-toggle').on('click', function(e){
   e.preventDefault();
   $('.pop-up-connection').toggleClass('showPop');
});

var estCo = $('.connec-res').attr('connec');

$('.connec-res').click(function(){
   if(estCo === "false"){
      $(this).attr('href', '/login');
   }
});

//TODO verif si l'utlisateur est connecté - si oui on applique la prochaine ligne
// $('.connec-res').attr("connec", "true");

if(estCo === "true"){
   $('.connec-res').html('Compte');
   $('.connec-res').attr('href','/account');
}