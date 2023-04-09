"use strict";
let  extractData_thenDisplay=function(){}
let too_manySMS=function(){}
let sms_toUsers=function(){}

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
    //survey feedback table
    extractData_thenDisplay=function(url){
        //Function to get data
        async function getData(url) {
            // Storing response
            const response = await fetch(url);
            // Storing data in form of JSON
            var data = await response.json();
            //console.log(data);
            if (response) {
                //hide loader
                spinner.setAttribute('hidden', '');    
            }
            show_feedbackForm(data);
            //alert(JSON.stringify(data))
        }
        getData(url)
    }

    let show_feedbackForm=function(data){
        let text = "";
        modalFooter.innerHTML=  closeBtn
        modalTitle.innerHTML=data.companyName +data.respType + data.fullName + data.datePosted + data.dateReceived ;
        let quesNamesArray=JSON.parse(data.quesName);     //How many How can
        let quesTypeIDArray=JSON.parse(data.quesTypeID);  //1,2 0,0, 2
        let quesOptionsArray=JSON.parse(data.quesOptions); //Yes, No
        let responseTemp=JSON.parse(data.response); //{1:"one", 2:"two"} or [0ne, two]
        
        //convert object to array
        let responseArray=[]
        if (typeof responseTemp === 'object'){
            responseArray=Object.values(responseTemp); 
        }else{
            responseArray=responseTemp;   
        }
                
        let pageCount=0
        let quesName=""
        let ulResponse="";
        let options=""
        let optionsArray=[];
        quesTypeIDArray.forEach(myFunction);
        alert(JSON.stringify(responseArray))
        function myFunction(item, index) {
            if (item > 0){
                quesName= (pageCount +1)     + ' . ' + quesNamesArray[index]
                text +=  quesName + "<br>";  
                ulResponse= "<ul>"
                options="" ;
                optionsArray=JSON.parse(quesOptionsArray[pageCount])
                let bold1='';
                let bold2="";
                if (item==2){ //radio
                    bold1='<strong>';
                    bold2="</strong>";
                    //alert(JSON.stringify(optionsArray) + ' === ' + pageCount)
                    for (let i=0; i < optionsArray.length; i++ ){
                       options += "<li> " +  optionsArray[i] + " </li>"
                    }
                } 
                ulResponse += bold1 + responseArray[pageCount]  + bold2
                text += options + ulResponse + "</ul>"
                pageCount++
            }else{
              text +=  quesNamesArray[index] + "<br>"  
            }
            
        }
        modalBody.innerHTML=text;
        modalBtnID.click()
    }
    
    too_manySMS=function(smsMsg,tel){
        spinner.setAttribute('hidden', '');
        modalTitle.innerHTML="Error: Too many sms sent to " + tel + " Please send this text  manaually";
        modalBody.innerHTML=smsMsg;
        //copy to clipboard
        copyToClipboard=function(){
            navigator.clipboard.writeText(smsMsg)
            const mytt = document.getElementById('tt');
            const tooltip = new bootstrap.Tooltip(mytt,{
            trigger:'click'
            })
            
            tooltip.show();
            setTimeout(function () {
            tooltip.hide();
            }, 600)

        }
        modalFooter.innerHTML= copyBtn +   closeBtn
        modalBtnID.click()
    }
    sms_toUsers=function(userID,statusID,tel,responseTypeID,URLpath){
        let post_data={
            userID:userID,
            statusID:statusID,
            tel:tel,
            responseTypeID:responseTypeID
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
            spinner.setAttribute('hidden', '');
            // alert(JSON.stringify(post_data))
            window.location.reload();
            alert("Sent");
        })
        .catch(function(error) {
            alert(error);
            spinner.setAttribute('hidden', '');
        }); 
    }

}) 