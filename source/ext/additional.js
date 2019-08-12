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
	$('#session_name').text(data.nama_lengkap);
	$('#session_email').text(data.email);

	$('#info_id_user').text(data.id_user);
	$('#info_nama_lengkap').text(data.nama_lengkap);
	$('#info_jenis_kelamin').text(data.jenis_kelamin);
	$('#info_telepon').text(data.telepon);
	$('#info_email').text(data.email);
	$('#info_alamat').text(data.alamat);
	$('#info_level').text(data.level);
	$('#info_status').text(data.status);
	$('#info_tgl_reg_user').text(data.tgl_reg_user);

	if (data.warehouse.length !== 0) {

	}
}
