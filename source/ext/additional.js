console.log('Additional is running...');

const PROTOCOL = window.location.protocol
const HOST = window.location.host
const PATH = HOST === 'localhost' ? 'scm/' : ''
const BASE_URL = `${PROTOCOL}//${HOST}/${PATH}`
const TOKEN = sessionStorage.getItem('EXT-TOKEN')
const USERNAME = 'scm-webapp'
const PASSWORD = 'codemaniacindo'

var makeNotif = (icon, heading, text, position) => {
	$.toast({
		heading: heading,
		text: text,
		position: position,
		loaderBg: '#ff6849',
		icon: icon,
		hideAfter: 3500,
		stack: 1
	});
}

var setSession = (data) => {
	$('#session_pic').text(data.nama_pic);
	$('#session_supplier').text(data.supplier.nama_supplier);

	$('#info_id_pic').text(data.id_pic);
	$('#info_nama_pic').text(data.nama_pic);

	$('#info_handphone').text(data.handphone);
	$('#info_email_pic').text(data.email_pic);
	$('#info_username').text(data.username);
	$('#info_tgl_reg_pic').text(data.tgl_reg_pic);

	if (data.supplier.length !== 0) {
		$('#info_id_supplier').text(data.supplier.id_supplier);
		$('#info_nama_supplier').text(data.supplier.nama_supplier);
		$('#info_alamat').text(data.supplier.alamat);
		$('#info_telepon').text(data.supplier.telepon);
		$('#info_fax').text(data.supplier.fax);
		$('#info_npwp').text(data.supplier.npwp);
		$('#info_email').text(data.supplier.email);
		$('#info_tgl_reg_supplier').text(data.supplier.tgl_reg_supplier);
		$('#info_status_supplier').text(data.supplier.status_supplier);
	}
}
