//From boostrap team
var tooltipTriggerList = [].slice.call(
    document.querySelectorAll('[data-bs-toggle="tooltip"]')
    );
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
    return new bootstrap.Tooltip(tooltipTriggerEl);
});
//** End of boostrap team  */
let copyToClipboard=function(){}
const modalBtnID = document.querySelector('#modalBtnID');
const modalTitle= document.querySelector('.modal-title');
const modalBody= document.querySelector('.modal-body');
const modalFooter= document.querySelector('.modal-footer');
const modalDialogID = document.getElementById("modal-dialogID");
const copyBtn= '<button type="button" class="btn btn-primary"  id="tt" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Copied!!!"  onClick="copyToClipboard()" >Copy to clipboard</button>';
const closeBtn= '<button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>';



//*** borrowed space for spinner */
const spinner = document.getElementById("spinner");
const alertDangerID = document.getElementById("alertDangerID");
const alertInfoID = document.getElementById("alertInfoID");

let show_alertInfo=function(xText){
    alertInfoID.innerHTML=xText;
    fadeIn(alertInfoID);
    setTimeout(() => { fadeOut(alertInfoID);}, 5*1000);
}

let show_alertDanger=function(xText){
    alertDangerID.innerHTML=xText;
    fadeIn(alertDangerID);
    const x= setTimeout(fadeOut(alertDangerID), 5*1000);
}
;
