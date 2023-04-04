"use strict";
let serviceUserSelectYearFunc=function(){}
let serviceUserSelectMonthFunc=function(){}
let surveyServiceuserFunc=function(){}

function ready(callbackFunc) {
  if (document.readyState !== 'loading') {
      // Document is already ready, call the callback directly
      callbackFunc();
    } else if (document.addEventListener) {
      // All modern browsers to register DOMContentLoaded
      document.addEventListener('DOMContentLoaded', callbackFunc);
    } else {
      // Old IE browsers
      document.attachEvent('onreadystatechange', function() {
        if (document.readyState === 'complete') {
          callbackFunc();
        }
      });
  }
}
  
  ready(function() {
    //This isa very silly approach. I should have use getElementById. 
    // make everything
    
    //survey feedback table
   let dataTable = document.getElementById('serviceUserSurveyFeedbackTableID') || false
    if (dataTable) {
      let dataTablet = new simpleDatatables.DataTable("#serviceUserSurveyFeedbackTableID",{
        searchable:false,
        perPageSelect:false,
        fixedheight:true,
        sortable:false,
        labels:{
          info:""
        }
      })
    }  
        
    serviceUserSelectYearFunc=function(){
        alert("best")
    }
    serviceUserSelectMonthFunc=function(){
        alert("tesr")
    }
    surveyServiceuserFunc=function(userID, statusID, tel, uniqueNo){
      //statusID 1 Created not sent  => Send
      //statusID 2 Sent not received => Re-send
      //statusID 3 Received => view
      //const token = document.head.querySelector("[name~=csrf-token][content]").content;
      const spinner = document.getElementById("spinner");
      spinner.removeAttribute('hidden');

      let URLpath=serviceUser_sendSMSURL;
      if (statusID==3){
          URLpath=serviceUser_viewResponse;
      }
      
      let post_data={
      userID:userID,
      statusID:statusID,
      tel:tel,
      uniqueNo:uniqueNo
    }
    fetch(URLpath, {
      headers: {
          "Content-Type": "application/json",
          "Accept": "application/json, text-plain, */*",
          "X-Requested-With": "XMLHttpRequest",
          "X-CSRF-TOKEN": token
          },
      method: 'Post',
      credentials: "same-origin",
      body: JSON.stringify(post_data)
  })
  .then((data) => {
      alert(tel + ' gg ' +  uniqueNo)
      spinner.setAttribute('hidden', '');
      //alert(JSON.stringify(data))
      window.location.reload();
      
      //alert("Sent");
  })
  .catch(function(error) {
      alert(error);
      spinner.setAttribute('hidden', '');
  }); 


  }

    
    

  }) 