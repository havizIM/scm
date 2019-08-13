$(function(){

  const dashController = (() => {

    const getOrder = () => {
      $.ajax({
        url: `${BASE_URL}int/order`,
        type: 'GET',
        dataType: 'JSON',
        // data: {},
        beforeSend: function (xhr) {
            xhr.setRequestHeader("Authorization", "Basic " + btoa(USERNAME + ":" + PASSWORD))
            xhr.setRequestHeader("SCM-INT-KEY", TOKEN)

        },
        success:function(response){
          $('#data1').text(response.data.length)
        },
        error:function(err){}
      });

    }

    const getShipping = () => {
      $.ajax({
        url: `${BASE_URL}int/shipping`,
        type: 'GET',
        dataType: 'JSON',
        // data: {},
        beforeSend: function (xhr) {
            xhr.setRequestHeader("Authorization", "Basic " + btoa(USERNAME + ":" + PASSWORD))
            xhr.setRequestHeader("SCM-INT-KEY", TOKEN)

        },
        success:function(response){
          $('#data2').text(response.data.length)
        },
        error:function(err){}
      });

    }

    return {
      init: () => {
        // console.log('ApsIsRunning');
        getOrder(),
        getShipping()
      }
    }

  })()

  dashController.init();

})
