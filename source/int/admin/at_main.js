
if(!TOKEN){
    window.location.replace(`${BASE_URL}internal`);
} else {
    $.ajax({
        url: `${BASE_URL}int/setting/user_info`,
        type: 'GET',
        dataType: 'JSON',
        beforeSend: function (xhr) {
            xhr.setRequestHeader("Authorization", "Basic " + btoa(USERNAME + ":" + PASSWORD))
            xhr.setRequestHeader("SCM-INT-KEY", TOKEN)
        },
        success: function (res) {
            if(res.status === true){
                const {level, status} = res.data;

                if(status === 'Nonaktif'){
                    sessionStorage.removeItem('INT-TOKEN')
                    window.location.replace(`${BASE_URL}internal`)
                } else {
                    if(level !== 'admin'){
                        window.location.replace(`${BASE_URL}${level}`)
                    } else {
                        setSession(res.data);
                    }
                }
            } else {
                sessionStorage.removeItem('INT-TOKEN')
                window.location.replace(`${BASE_URL}internal`)
            }
        },
        error: function (err) {
            sessionStorage.removeItem('INT-TOKEN')
            window.location.replace(`${BASE_URL}internal`)
        }
    })
}