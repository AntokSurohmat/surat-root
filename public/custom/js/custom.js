/**
 * AdminLTE Demo Menu
 * ------------------
 * You should not use this file in production.
 * This file is for demo purposes only.
 */

/* eslint-disable camelcase */

(function ($) {
  'use strict'

  // setTimeout(function () {
  //   if (window.___browserSync___ === undefined && Number(localStorage.getItem('AdminLTE:Demo:MessageShowed')) < Date.now()) {
  //     localStorage.setItem('AdminLTE:Demo:MessageShowed', (Date.now()) + (15 * 60 * 1000))
  //     // eslint-disable-next-line no-alert
  //     alert('You load AdminLTE\'s "demo.js", \nthis file is only created for testing purposes!')
  //   }
  // }, 1000)

  // Make the dashboard widgets sortable Using jquery UI
  $('.connectedSortable').sortable({
    placeholder: 'sort-highlight',
    connectWith: '.connectedSortable',
    handle: '.card-header, .nav-tabs',
    forcePlaceholderSize: true,
    zIndex: 999999
  })
  $('.connectedSortable .card-header').css('cursor', 'move')

})(jQuery)

function logout() {
  var option = {
    backdrop: 'static',
    keyboard: true
  };
  $('#modal-logout').modal(option);
  $('#modal-logout').modal('show');
}
function gen_pangol(base_url){
	var randomnumber=Math.floor(000001 + Math.random() * 9999999);
	var temp_kode = randomnumber;
	var url_destination = base_url;

	var dup = $.ajax({
		type: "POST",
		url: url_destination,
		data:{kode:temp_kode},
		cache: false,
		async: false
	}).responseText;
	var result = eval('('+dup+')');
	if (result.success){
		return temp_kode;
	}else{
		gen_pangol(url_destination);
	}
} // Generate Kode Kas

/*-- Costum Sweetalert2 --*/
const swalWithBootstrapButtons = Swal.mixin({
  customClass: {
    confirmButton: 'btn btn-success',
    cancelButton: 'btn btn-danger'
  }
})
/*-- /. Costum Sweetalert2 --*/
