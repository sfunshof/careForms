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
      })
    }
}
  
ready(function() {
    
    let dataTable = document.getElementById('serviceUserSurveyFeedbackTableID') || false
    const serviceUserSelectYearID    = document.getElementById("serviceUserSelectYearID"); 
    const serviceUserSelectMonthID  = document.getElementById("serviceUserSelectMonthID"); 
    let monthVal=-1;
   
    //survey feedback table
    if (dataTable) {
         dataTable = new simpleDatatables.DataTable("#serviceUserSurveyFeedbackTableID",{
            searchable:false,
            perPageSelect:false,
            fixedheight:true,
            sortable:false,
            labels:{
              info:""
            }
        })
    }  
    
    let year =serviceUserSelectYearID.options[serviceUserSelectYearID.selectedIndex].value
    let monthText=serviceUserSelectMonthID.options[serviceUserSelectMonthID.selectedIndex].text
    monthVal = serviceUserSelectMonthID.options[serviceUserSelectMonthID.selectedIndex].value
    serviceUserSelectYearFunc=function(){
        year=serviceUserSelectYearID.options[serviceUserSelectYearID.selectedIndex].value
        let result=get_reloadURL();
        let URLreload=result.URLreload;
        window.location.replace(URLreload)        
    }
    serviceUserSelectMonthFunc=function(){
        monthText=serviceUserSelectMonthID.options[serviceUserSelectMonthID.selectedIndex].text
        monthVal=serviceUserSelectMonthID.options[serviceUserSelectMonthID.selectedIndex].value
        let result=get_reloadURL();
        let URLreload=result.URLreload;
        window.location.replace(URLreload) 
    }
    surveyServiceuserFunc=function(userID, statusID,  responseTypeID, unique_value, sentCount,   tel){
        //statusID 1 Created not sent  => Send
        //statusID 2 Sent not received => Re-send
        //statusID 3 Received => view
        //const token = document.head.querySelector("[name~=csrf-token][content]").content;
      
        // spinner.removeAttribute('hidden');
        let URLpath=serviceUser_sendSMSURL;

        //View 
        if (statusID==3){
            URLpath=user_viewURL + "/" + userID + "/" + unique_value + "/" +  responseTypeID;
            // Calling that async function to display the feedback form's data
            extractData_thenDisplay(URLpath);
            return 0;
        }
      
        //check if it has already been sent 2wise
        //bring modal to copy sms messages
        if ((statusID==2) && (sentCount==2)){
            let smsMsg= smsPreText + URLbase + "/" + unique_value
            //bring out the modal
            too_manySMS(smsMsg,tel)
            return 0;
        }    
        
        //Send SMS to the clients
        let result=get_reloadURL();
        let date_of_interest=result.date_of_interest;
        let URLreload=result.URLreload;
        sms_toUsers(userID,statusID,tel,responseTypeID,URLpath,date_of_interest,URLreload)
        
    }
    let get_reloadURL=function(){
        let monthStr=monthVal < 10 ? "0" + monthVal: monthVal
        let date_of_interest=  year + "-" + monthStr + "-01"    
        let pageNo= typeof dataTable.currentPage !== 'undefined' ? dataTable.currentPage :-1 ;
        let URLreload=URLbase+ '/serviceUser/show_surveyfeedback/' +monthVal + '/' + year + '/' + pageNo
        const result={"date_of_interest":date_of_interest, "URLreload":URLreload }
        return result;
    }     
    
    if (dateFlag==1){
        show_alertInfo("This time period is not yet active")
    }
    

}) 