
$(".productID").focusout(function(){
    if(jQuery.inArray( this.value, products)!=-1){
        csvJSON[this.id]["order_id"] = this.value;
        $(this).css("border", "solid green 1px");
        totalErrors=totalErrors-1;
        errorDisplay(totalErrors);
    }else{
        swal("Not valid product ID");
    }               
});

$(".customerName").focusout(function(){
    if(this.value!="" && this.value!=null){
        csvJSON[this.id]["name"] = this.value;
        $(this).css("border", "solid green 1px");
        totalErrors=totalErrors-1;
        errorDisplay(totalErrors);
    }else{
        swal("Value can not be empty");
    }               
});

$(".email").focusout(function(){
    var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;  
    if(regex.test(this.value)){
        csvJSON[this.id]["email"] = this.value;
        $(this).css("border", "solid green 1px");
        totalErrors=totalErrors-1;
        errorDisplay(totalErrors);
    }else{
        swal("Not a valid Email");
    }               
});

$(".addressOne").focusout(function(){
    if(this.value!="" && this.value!=null){
        csvJSON[this.id]["address_line_one"] = this.value;
        $(this).css("border", "solid green 1px");
        totalErrors=totalErrors-1;
        errorDisplay(totalErrors);
    }else{
        swal("Value can not be empty");
    }               
});

$(".postCode").focusout(function(){
    if(this.value!="" && this.value!=null && this.value.length>=4){
        csvJSON[this.id]["postcode"] = this.value;
        $(this).css("border", "solid green 1px");
        totalErrors=totalErrors-1;
        errorDisplay(totalErrors);
    }else{
        swal("Post code must be 4 or more characters");
    }               
});

$(".state").focusout(function(){
    var statesArray = ["NSW", "ACT", "VIC", "QLD", "SA", "NT", "TA"];
    if(this.value!="" && this.value!=null && (jQuery.inArray( this.value, statesArray)!=-1)){
        csvJSON[this.id]["state"] = this.value;
        $(this).css("border", "solid green 1px");
        totalErrors=totalErrors-1;
        errorDisplay(totalErrors);
    }else{
        swal("State must be 4 one of 'NSW, ACT, VIC, QLD, SA, NT, TA'");
    }               
});

$(".country").focusout(function(){    
    if(this.value!="" && this.value!=null){
        csvJSON[this.id]["country"] = this.value;
        $(this).css("border", "solid green 1px");
        totalErrors=totalErrors-1;
        errorDisplay(totalErrors);
    }else{
        swal("Value can not be empty");
    }               
});

$("#addCSV_Data").click(function(){
    if(totalErrors==0){
        addData();
    }else{
        swal({
            title: 'There are some invalid data!',
            text: "Do you want exclude them and continue?",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, Add!'
            }).then((result) => {
            if (result.value) {
                addData();  
            }
        })
    }
                                   
});

function addData(){
    var i=1;
    for (row in csvJSON){
        if(csvJSON[i]['errors']=="0"){
            var stringifyJSON = JSON.stringify(csvJSON[i]);
            url="data.php?data="+stringifyJSON;
            ajaxAddDataQ(url, i);
        }       
        i=i+1;                    
    }
}

function ajaxAddDataQ(url, rowNo){       
    if(window.XMLHttpRequest){
        xmlhttp = new XMLHttpRequest();
    }else{
        xmlhttp = new ActiveXObject('Microsoft.XMLHTTP');
    }

    xmlhttp.onreadystatechange = function(){
        if(xmlhttp.readyState == 4 && xmlhttp.status == 200){            
            //console.log(xmlhttp.responseText);
            dataInsertResponse(xmlhttp.responseText, rowNo);                                                                                          
        }
    }
    
    xmlhttp.open('GET', url, false);
    xmlhttp.send();
}

function dataInsertResponse(response, i){
    id="#trID"+i;
    if(response=="inserted"){
        $(id).css("background-color", "#4CAF50");
    }else{
        $(id).css("background-color", "#D20117");
    }
    
}

function errorDisplay(totErros){
    if(totErros>0){                    
        $("#errorNote").html("This CSV has total number of "+totErros+" invalid data which are marked in red <br> You can use the 'Tab' key to move to the next invalid data feild to correct them!");
        $("#errorBlock").show();
    }else{
        $("#errorBlock").hide();
    }
}