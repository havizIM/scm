$(function(){


 const dashController = (() => {

   const getOrder = () => {
     $.ajax({
       url: `${BASE_URL}ext/order`,
       type: 'GET',
       dataType: 'JSON',
       // data: {},
       beforeSend: function (xhr) {
           xhr.setRequestHeader("Authorization", "Basic " + btoa(USERNAME + ":" + PASSWORD))
           xhr.setRequestHeader("SCM-EXT-KEY", TOKEN)

       },
       success:function(response){
         $('#data1').text(response.data.length)
       },
       error:function(){}
     });

   }

   const getShipping = () => {
     $.ajax({
       url: `${BASE_URL}ext/shipping`,
       type: 'GET',
       dataType: 'JSON',
       // data: {},
       beforeSend: function (xhr) {
           xhr.setRequestHeader("Authorization", "Basic " + btoa(USERNAME + ":" + PASSWORD))
           xhr.setRequestHeader("SCM-EXT-KEY", TOKEN)

       },
       success:function(response){
         $('#data2').text(response.data.length)
       },
       error:function(){}
     });

   }

   const getInvoice = () => {
     $.ajax({
       url: `${BASE_URL}ext/invoice`,
       type: 'GET',
       dataType: 'JSON',
       // data: {},
       beforeSend: function (xhr) {
           xhr.setRequestHeader("Authorization", "Basic " + btoa(USERNAME + ":" + PASSWORD))
           xhr.setRequestHeader("SCM-EXT-KEY", TOKEN)

       },
       success:function(response){
         $('#data3').text(response.data.length)
       },
       error:function(){}
     });

   }

   const getProduct = () => {
     $.ajax({
       url: `${BASE_URL}ext/product`,
       type: 'GET',
       dataType: 'JSON',
       // data: {},
       beforeSend: function (xhr) {
           xhr.setRequestHeader("Authorization", "Basic " + btoa(USERNAME + ":" + PASSWORD))
           xhr.setRequestHeader("SCM-EXT-KEY", TOKEN)

       },
       success:function(response){
         $('#data4').text(response.data.length)
       },
       error:function(){}
     });

   }

   const getPayment = () => {
     $.ajax({
       url: `${BASE_URL}ext/payment`,
       type: 'GET',
       dataType: 'JSON',
       // data: {},
       beforeSend: function (xhr) {
           xhr.setRequestHeader("Authorization", "Basic " + btoa(USERNAME + ":" + PASSWORD))
           xhr.setRequestHeader("SCM-EXT-KEY", TOKEN)

       },
       success:function(response){
         $('#data5').text(response.data.length)
       },
       error:function(){}
     });

   }


   return {
     init: () => {

       getOrder(),
       getShipping(),
       getInvoice(),
       getProduct()
     }
   }

 })()

 dashController.init()

})
