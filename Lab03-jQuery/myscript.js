//Wipawadee Monkhut 5910406451
var dataCompany = [];
var inputText = "";
var keyPress = "";
var defineTag =  $("#body-table tr").clone(true);
rowsData = document.getElementsByTagName("tr");
var symbolCheckBox = "";
var companyCheckBox = "";
var marketCheckBox = "";
var industryCheckBox = "";
var sectorCheckBox = "";
var webSiteCheckBox = "";
var listSearch = [];
$('#section-advance-search').hide(); // hidden advance search
$("#input-text").val("");   //clear text feild
var showStatus = 0;
$(".filled-in").prop("checked", false);

$(document).ready(function() {    

   $('#input-text').keydown(function(event){ 
        var keyCode = (event.keyCode ? event.keyCode : event.which);   
        if (keyCode == 13) { // 13 = enter
            inputText = $("#input-text").val();
            searchData(inputText);
            console.log('Press key Enter');
        }
    });
    $('#submit-btn').click(function() {

        inputText = $("#input-text").val();
        searchData(inputText);
        console.log('click on submit button');
    });

    $('#advanced-search').click(function() {
        $("#input-text").val("");   //clear text feild
        /*get value from checkbox*/ 
        symbolCheckBox = $("#symbolCheck").val();
        companyCheckBox = $("#companyCheck").val();
        marketCheckBox = $("#marketCheck").val();
        industryCheckBox = $("#industryCheck").val();
        sectorCheckBox = $("#sectorCheck").val();
        webSiteCheckBox = $("#webSiteCheck").val();
        /*add value to array*/
        listSearch.push(symbolCheckBox);
        listSearch.push(companyCheckBox)
        listSearch.push(marketCheckBox);
        listSearch.push(industryCheckBox);
        listSearch.push(sectorCheckBox);
        listSearch.push(webSiteCheckBox);

        inputText = $("#input-text").val();
        searchData(inputText);
        console.log('click on submit button');

        if(showStatus == 0){
            showStatus = 1;
            $('#section-advance-search').show();
            searchDataAdvance(listSearch,value)
            
        }
        else{
            showStatus = 0;
            $('#section-advance-search').hide();
            searchData("");
            $(".filled-in").prop("checked", false);
            $("#input-text").val("");
        }

    });

    $.ajax({
        url: "data2.json",
        dataType: "json"
    }).done(function(response) {
        console.log(response);
        dataCompany = response; //copy object in file data2.json to Array     

        var bodyTag = defineTag; // clone loop tag
        var newTag = ""; // create new html tag 
    
        $.each(dataCompany,function(i,k){ // for each loop data 
            var objHTML = bodyTag; 
            objHTML.find("td:eq(0)").html(i+1).end()
            .find("td:eq(1)").html(dataCompany[i].Symbol).end()
            .find("td:eq(2)").html(dataCompany[i].Company).end()
            .find("td:eq(3)").html(dataCompany[i].Market).end()
            .find("td:eq(4)").html(dataCompany[i].Industry).end()
            .find("td:eq(5)").html(dataCompany[i].Sector).end()
            .find("td:eq(6)").html(dataCompany[i].WebSite).end();
            newTag += $(objHTML)[0].outerHTML; // create tag each row
            });
            $("#body-table").replaceWith(newTag); // replace row
    });


        
});

function searchData(value){
    value = value.toLowerCase();
    
    
    $.each(dataCompany,function(i,k){   // i start from 0
        
        if(value == ""){
            rowsData[i+1].style.display = null;     //row[0] = header table
        }

        if( 
            dataCompany[i].Symbol.toLowerCase().search(value) != -1 ||
            dataCompany[i].Company.toLowerCase().search(value) != -1 ||
            dataCompany[i].Market.toLowerCase().search(value) != -1 ||
            dataCompany[i].Industry.toLowerCase().search(value) != -1 ||
            dataCompany[i].Sector.toLowerCase().search(value) != -1 ||
            dataCompany[i].WebSite.toLowerCase().search(value) != -1 ){

                rowsData[i+1].style.display = null;

        }else{
                rowsData[i+1].style.display = 'none';
            
        }
    });
}

function searchDataAdvance(array,value){

    if(value == ""){
        $.each(dataCompany,function(i,k){
            rowsData[i+1].style.display = null;     //row[0] = header table
        });
        
    }
    else{

        for(var j = 0 ; j < array.length ; j++){
            if(array[j] == "on" && j == 0){
                $.each(dataCompany,function(i,k){
                    if(dataCompany[i].Symbol.toLowerCase().search(value) != -1 ){
                        rowsData[i+1].style.display = null;
                    }
                });
            }
            else if(array[j] == "on" && j == 1){
                $.each(dataCompany,function(i,k){
                    if(dataCompany[i].Company.toLowerCase().search(value) != -1){
                        rowsData[i+1].style.display = null;
                    }
                });
            }

            else if(array[j] == "on" && j == 2){
                $.each(dataCompany,function(i,k){
                    if(dataCompany[i].Market.toLowerCase().search(value) != -1){
                        rowsData[i+1].style.display = null;
                    }
                });
            }

            else if(array[j] == "on" && j == 3){
                $.each(dataCompany,function(i,k){
                    if(dataCompany[i].Industry.toLowerCase().search(value) != -1){
                        rowsData[i+1].style.display = null;
                    }
                });
            }
            

            else if(array[j] == "on" && j == 4){
                $.each(dataCompany,function(i,k){
                    if(dataCompany[i].Sector.toLowerCase().search(value) != -1){

                    }
                });
            }

            else if(array[j] == "on" && j == 5){
                $.each(dataCompany,function(i,k){
                    if(dataCompany[i].WebSite.toLowerCase().search(value) != -1){
                        rowsData[i+1].style.display = null;
                    }
                });
            }
            else{
                rowsData[i+1].style.display = 'none';
            }
        }
    }
}
