function fill_alias() {
	var value = $("input[id*='name']").val();
	if (!value) {
		var value = $("input[id*='title']").val();
	}
	$("input[id*='alias']").val(translit(value));
}
function capitalize(item) {
	text = $(item).parent().closest('div').children('input').val();	
	new_text = text.toLowerCase();
	new_text = (new_text.substr(0,1).toUpperCase())+(new_text.substr(1));
	$(item).parent().closest('div').children('input').val(new_text);	
}
function ucwords(str){
  str.toLowerCase();  
  return str.replace(/(\b)([a-zA-Z])/g,
           function(firstLetter){
              return   firstLetter.toUpperCase();
           });
}
function translit(value) {
	var rusChars = new Array('а', 'б', 'в', 'г', 'д', 'е', 'ё', 'ж', 'з', 'и', 'й', 'к', 'л', 'м', 'н', 'о', 'п', 'р', 'с', 'т', 'у', 'ф', 'х', 'ч', 'ц', 'ш', 'щ', 'э', 'ю', '\я', 'ы', 'ъ', 'ь', ' ', '\'', '\"', '\#', '\$', '\%', '\&', '\*', '\,', '\:', '\;', '\<', '\>', '\?', '\[', '\]', '\^', '\{', '\}', '\|', '\!', '\@', '\(', '\)', '\-', '\=', '\+', '\/', '\\');
	var transChars = new Array('a', 'b', 'v', 'g', 'd', 'e', 'jo', 'zh', 'z', 'i', 'j', 'k', 'l', 'm', 'n', 'o', 'p', 'r', 's', 't', 'u', 'f', 'h', 'ch', 'c', 'sh', 'csh', 'e', 'ju', 'ja', 'y', '', '', '-', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '');
	var from = value;
	from = from.toLowerCase();
	var to = "";
	var len = from.length;
	var character,
	isRus;
	for (var i = 0; i < len; i++) {
		character = from.charAt(i, 1);
		isRus = false;
		for (var j = 0; j < rusChars.length; j++) {
			if (character == rusChars[j]) {
				isRus = true;
				break;
			}
		}
		to += (isRus) ? transChars[j] : character;
	}
	return to;
}
function deletecode(id) {
	location.href = '../deletecode/' + id;
}
function generate_codes() {
	var count = $('#count').val();
	var symbols = $('#symbols').val();
	if (count && symbols) {
		for (var i = 0; i < count; i++) {
			var number = Math.random();
			var id = number.toString(36).substr(2, symbols);
			console.log(id);
			$('#Coupons_codes').tagsinput('add', id);
		}
	}
}
$('.confirm-delete').on('click', function (e) {
	e.preventDefault();
	var id = $(this).data('id');
	console.log(id);
	$('#myModal').data('id', id);
	var newid = $('#myModal').data('id');
	console.log(newid);
});
$('#myModal').on('show', function () {
	var id = $(this).data('id');
	console.log(id);
})
$('.confirm-deletes').on('click', function (e) {
	e.preventDefault();
	var id = $(this).data('id');
	$('#fModal').data('id', id).modal('show');
});
$('#fModal').on('show', function () {
	var id = $(this).data('id');
})
$('#btnYes').click(function () {
	var id = $('#myModal').data('id');
	location.href = "./deluser/" + id;
	$('#myModal').modal('hide');
});
$('#btnYesRegion').click(function () {
	var id = $('#myModal').data('id');
	location.href = "./delregion/" + id;
	$('#myModal').modal('hide');
});
$('#btnYesArea').click(function () {
	var id = $('#myModal').data('id');
	location.href = "./delarea/" + id;
	$('#myModal').modal('hide');
});
$('#btnYesBanner').click(function () {
	var id = $('#myModal').data('id');
	location.href = "./delbanner/" + id;
	$('#myModal').modal('hide');
});
$('#btnYesCategory').click(function () {
	var id = $('#myModal').data('id');
	location.href = "./delcategory/" + id;
	$('#myModal').modal('hide');
});
$('#btnYesCategoryField').click(function () {
	var id = $('#myModal').data('id');
	location.href = "../delcategoryfield/" + id;
	$('#myModal').modal('hide');
});
$('#btnYesCategoryFieldValue').click(function () {
	var id = $('#myModal').data('id');
	location.href = "../deletefieldvalue/" + id;
	$('#myModal').modal('hide');
});
$('#btnYesAdv').click(function () {
	var id = $('#myModal').data('id');
	location.href = "./deladv/" + id;
	$('#myModal').modal('hide');
});
$('#btnYesPage').click(function () {
	var id = $('#myModal').data('id');
	location.href = "./delpage/" + id;
	$('#myModal').modal('hide');
});
$('#btnYesNews').click(function () {
	var id = $('#myModal').data('id');
	location.href = "./delnews/" + id;
	$('#myModal').modal('hide');
});
$('#btnYesMenu').click(function () {
	var id = $('#myModal').data('id');
	location.href = "./delmenu/" + id;
	$('#myModal').modal('hide');
});
$('#btnYesJobCategory').click(function () {
	var id = $('#myModal').data('id');
	location.href = "./deljobcategory/" + id;
	$('#myModal').modal('hide');
});
$('#btnYesJobCategoryField').click(function () {
	var id = $('#myModal').data('id');
	location.href = "../deljobcategoryfield/" + id;
	$('#myModal').modal('hide');
});
$('#btnYesJobsCategoryField').click(function () {
	var id = $('#fModal').data('id');
	location.href = "./deljobcategoryfield/" + id;
	$('#fieldsModal').modal('hide');
});
$('#btnYesJobCategoryFieldValue').click(function () {
	var id = $('#myModal').data('id');
	location.href = "../deletejobfieldvalue/" + id;
	$('#myModal').modal('hide');
});
$('#btnYesJobD').click(function () {
	var id = $('#myModal').data('id');
	location.href = "../deljob/" + id;
	$('#myModal').modal('hide');
});
$('#btnYesJobR').click(function () {
	var id = $('#myModal').data('id');
	location.href = "../delresume/" + id;
	$('#myModal').modal('hide');
});
$('#btnYesCoupon').click(function () {
	var id = $('#myModal').data('id');
	location.href = "./delcoupon/" + id;
	$('#myModal').modal('hide');
});
$('#btnYesCouponsCategory').click(function () {
	var id = $('#myModal').data('id');
	location.href = "./delcouponscategory/" + id;
	$('#myModal').modal('hide');
});
$('#btnYesShops').click(function () {
	var id = $('#myModal').data('id');
	location.href = "./delshop/" + id;
	$('#myModal').modal('hide');
});
$('#advs_town_delete').click(function () {
	var name = $('#advs_name').val();
  var town = $(this).data('town');
  var in_town = $(this).data('in');  
  var new_name = name.replace(in_town, '');
  $('#advs_name').val($.trim(new_name));
});
$('#adv_approve_button').click(function (e) {
	e.preventDefault();
  $('#advs_moder_approved').attr('checked',true);
  $(this).closest('form').submit();
});
