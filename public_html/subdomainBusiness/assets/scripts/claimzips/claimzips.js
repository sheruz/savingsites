var _gaq = _gaq || [];



_gaq.push(





        ['testing._setAccount', 'UA-27015768-1'],

        ['testing._trackPageview', '/tracking/homepage/'],



        ['_setCustomVar', 46, 'Split test Email All', 'x1000_y100_selfeat_newform', 1],

        ['_setCustomVar', 47, 'Rated people split', 'original', 1],

        ['_setCustomVar', 48, 'Rubicon MPU 20% split', 'rubicon', 1],



        ['_setAccount', 'UA-2562160-1'],

        ['_trackPageview'],

        ['_trackPageLoadTime']



    );

$(document).ready(function () {

    $("#errorMessage").hide();

    $("#stateError").hide();

});

(function () {

    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;

    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';

    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);



})();



function validate() {

    var chks = document.getElementsByName('states[]');

    var hasChecked = false;

    for (var i = 0; i < chks.length; i++) {

        if (chks[i].checked) {

            hasChecked = true;

            break;

        }

    }

    if (hasChecked == false) {

        alert("Please select at least one.");

        return false;

    }

    return true;

}

function checkzip(me) {

    if (me.value.length < 5 || isNaN(me.value)) {

        document.getElementById(me.id).select();

        

    }

    window.setTimeout(function () { document.getElementById(me.id).focus(); }, 0);

}



function NextBox(boxID, event) {



    if (event.keyCode > 47)   // unprintable characters are all less than 47

    {

        Box = document.getElementsByTagName('input');

        BoxL = Box.length;

        llen = document.getElementById(boxID).value.length;

        maxL = 5;

        if (llen >= maxL) {

            for (x = 0; x < BoxL; x++) {

                if (boxID == Box[x].id) {

                    Box[++x].focus();

                    //Box[x].select();

                    break;

                }

            }

        }

    } // key check

}

function submitform1(pressedButton) {

    var hasValue = false;

    var allValuesAreNumber = true;

    var errorString = "";

    var subarr = new Array();

    $("input[type=text]").each(function () {

        if (this.value != "") {

            hasValue = true;

            if (isNaN(this.value) || this.value.length != 5) {



                allValuesAreNumber = false;

            }

            else {

                subarr.push(this.value);

            }

        }

    });

    if (!hasValue) {

        errorString = "You must enter some zip codes!!!<br/>";

    }

    if(!allValuesAreNumber){

        errorString += "All Zip Codes Must Be 5 Digit Numbers!!!";

    }

    if(errorString.length > 0)

    {

        $("#errorMessage").html(errorString);

        $("#errorMessage").show("slow");

        return false;

    }

    //Load Table....

    if (pressedButton == 0) {

        $.blockUI({ message: "Claiming Your Zip Codes<br/>This may take a minute."});

        return true;

    }

    PageMethod("http://www.savingssites.com/claimzips/get_zip_table", "Getting Your Zip Code Results<br/>This may take a minute.", { 'txtZip': subarr }, getTableSuccessful, null);



    return false;



}

//////////////////////////////////////////////////

//function CheckStates() {

//    var selVal = $("#selState").val();

//    if (selVal == '') {

//        $("#stateError").show("slow");

//        $("#selState").focus();

//        return false;

//        

//    }

//    return true;

//}

function CheckStates() { //alert(1);

    if (document.searchform2.selState.value != '')

        return true;

    else {

        $("#stateError").show("slow");

        document.searchform2.selState.focus();

        return false;

    }

}

//////////////////////////////////////////////////

function getTableSuccessful(result) {

    $.unblockUI();

    $("#divZipCounts").html(result.Tag);

    $("#divZipCounts table").dataTable(

                {

                    "sDom": 't',

                    "iDisplayLength": -1,

                    "bSort": false,

                    "bJQueryUI": true

                }); ;

}

//////////////////////////////////////////////////

function submitform() {

    var state = document.getElementById("state");

    if (state.value != '') {

        return true;

    }

    else {

        alert("Select A State");

        state.focus();

        return false

    }



}

/* if (stateChecked == true && emailChecked == true || strUser1=="Select"||strUser2=="Select"||strUser3=="Select")

{



document.searchform.action="index.php";

document.searchform.submit();

}

if (stateChecked == false || emailChecked == false)

{



alert("Please select at least one.");

return false;

} */

function claimform() {

    document.searchform.action = "query.php";

    document.searchform.submit();

}



function fillcounty() {



    var e = document.getElementById("state");

    var sid = e.options[e.selectedIndex].value;

    document.searchform.action = "index.php?fill=county&sid=" + sid;

    document.searchform.submit();

}





function selectmenu(me) {

    document.getElementById("menu0").className = "";

    document.getElementById("menu1").className = "";

    document.getElementById("menu2").className = "";

    document.getElementById("menu3").className = "";



    switch (me) {

        case 0: document.getElementById('menu0').className = "hi-active"; break;

        case 1: document.getElementById("menu1").className = "hi-active"; break;

        case 2: document.getElementById("menu2").className = "hi-active"; break;

        case 3: document.getElementById("menu3").className = "hi-active"; break;

    }

}