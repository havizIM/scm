
if (!TOKEN) {
    window.location.replace(`${BASE_URL}`);
} else {
    $.ajax({
        url: `${BASE_URL}ext/setting/user_info`,
        type: 'GET',
        dataType: 'JSON',
        beforeSend: function (xhr) {
            xhr.setRequestHeader("Authorization", "Basic " + btoa(USERNAME + ":" + PASSWORD))
            xhr.setRequestHeader("SCM-EXT-KEY", TOKEN)
        },
        success: function (res) {
            if (res.status === true) {
                const { data } = res;

                if(data.supplier.status_supplier === 'Nonaktif'){
                    sessionStorage.removeItem('EXT-TOKEN')
                    window.location.replace(`${BASE_URL}`)
                } else {
                    setSession(res.data);
                }
            } else {
                sessionStorage.removeItem('EXT-TOKEN')
                window.location.replace(`${BASE_URL}`)
            }
        },
        error: function (err) {
            sessionStorage.removeItem('EXT-TOKEN')
            window.location.replace(`${BASE_URL}`)
        }
    })
}