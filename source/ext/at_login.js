
if (TOKEN) {
    $.ajax({
        url: `${BASE_URL}ext/setting/user_info`,
        type: 'GET',
        dataType: 'JSON',
        beforeSend: function (xhr) {
            xhr.setRequestHeader("Authorization", "Basic " + btoa(USERNAME + ":" + PASSWORD))
            xhr.setRequestHeader("SCM-EXT-KEY", TOKEN)
        },
        success: function (res) {
            if (res.data.length !== 0) {
                const { status_supplier } = res.data;

                if (status_supplier === 'Aktif') {
                    window.location.replace(`${BASE_URL}supplier/`)
                }
            } else {
                sessionStorage.removeItem('EXT-TOKEN')
            }

        },
        error: function (err) {
            sessionStorage.removeItem('EXT-TOKEN')
        }
    })
}