$(function(){


  const dashController = (()=>{

    const getUser = () => {
      $.ajax({
        url: `${BASE_URL}int/user`,
        type: 'GET',
        dataType: 'JSON',
        // data: {},
        beforeSend:function(xhr){
          xhr.setRequestHeader("Authorization", "Basic " + btoa(USERNAME + ":" + PASSWORD))
          xhr.setRequestHeader("SCM-INT-KEY", TOKEN)
        },
        success:function(response){
          $('#data1').text(response.data.length)
        },
        error:function(){}
      });

    }
    const getWarehouse = () => {
      $.ajax({
        url: `${BASE_URL}int/warehouse`,
        type: 'GET',
        dataType: 'JSON',
        // data: {},
        beforeSend:function(xhr){
          xhr.setRequestHeader("Authorization", "Basic " + btoa(USERNAME + ":" + PASSWORD))
          xhr.setRequestHeader("SCM-INT-KEY", TOKEN)
        },
        success:function(response){
          $('#data2').text(response.data.length)
        },
        error:function(){}
      });

    }
    const getSupplier = () => {
      $.ajax({
        url: `${BASE_URL}int/Supplier`,
        type: 'GET',
        dataType: 'JSON',
        // data: {},
        beforeSend:function(xhr){
          xhr.setRequestHeader("Authorization", "Basic " + btoa(USERNAME + ":" + PASSWORD))
          xhr.setRequestHeader("SCM-INT-KEY", TOKEN)
        },
        success:function(response){
          $('#data3').text(response.data.length)
        },
        error:function(){}
      });

    }

    return {
      init: () => {
        getUser(),
        getSupplier(),
        getWarehouse()
      }
    }

  })()

  dashController.init();

})
