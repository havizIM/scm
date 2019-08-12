
if (TOKEN) {
    $.ajax({
        url: `${BASE_URL}int/setting/user_info`,
        type: 'GET',
        dataType: 'JSON',
        beforeSend: function (xhr) {
            xhr.setRequestHeader("Authorization", "Basic " + btoa(USERNAME + ":" + PASSWORD))
            xhr.setRequestHeader("SCM-INT-KEY", TOKEN)
        },
        success: function (res) {
            if(res.data.length !== 0){
                const { level, status } = res.data;

                if (status === 'Aktif') {
                    window.location.replace(`${BASE_URL}${level}/`)
                }
            } else {
                sessionStorage.removeItem('INT-TOKEN')
            }
            
        },
        error: function (err) {
            sessionStorage.removeItem('INT-TOKEN')
        }
    })
}