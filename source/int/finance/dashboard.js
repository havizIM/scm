$(function (){

  const dashController = (()=>{

    const getOrder = () => {
      $.ajax({
        url: `${BASE_URL}int/order`,
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
        error:function(err){}
      });

    }

    const getShipping = () => {
      $.ajax({
        url: `${BASE_URL}int/shipping`,
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

    const getInvoice = () => {
      $.ajax({
        url: `${BASE_URL}int/invoice`,
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

    const getPayment = () => {
      $.ajax({
        url: `${BASE_URL}int/payment`,
        type: 'GET',
        dataType: 'JSON',
        // data: {},
        beforeSend:function(xhr){
          xhr.setRequestHeader("Authorization", "Basic " + btoa(USERNAME + ":" + PASSWORD))
          xhr.setRequestHeader("SCM-INT-KEY", TOKEN)
        },
        success:function(response){
          $('#data4').text(response.data.length)
        },
        error:function(){}
      });

    }


    return {

      init: () => {
        // console.log('Apsss Is Santuyy');
        getOrder(),
        getInvoice(),
        getPayment(),
        getShipping()
      }
    }


  })()

  dashController.init()


})
