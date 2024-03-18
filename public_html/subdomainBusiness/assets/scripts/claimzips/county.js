	 /*
	  	  Javascript form helping functions for consumer_records_search.php
	*/
    function CheckStates(val)
    {
          if(val !="")
              DisableStates();
		  else
              EnableStates();
    }
	
	// onload function for states checkboxes
   function onloader()
   {
	   if(document.getElementById('optNone').checked == false)
	      DisableStates()
	  else
          EnableStates();
    }

	//Disables state boxes when a country search is selected
	 function DisableStates()
	 {
	  x = document.searchform;
	  chkBoxes  = x.elements;  
	  for(u = 4; u < 70; u++)// go through  checkboxes for states and provinces
	  {
		  chkBoxes[u].disabled = true;
		  //chkBoxes[u].style.backgroundColor = "#FF4444";
		  //chkBoxes[u].style.color = "#FF4444";

	   }  
	 }

	//Enables state boxes when a country search is selected
	 function EnableStates()
	 {
	  x = document.searchform;
	  chkBoxes  = x.elements;  
	  for(u = 4; u < 70; u++)// go through  checkboxes for states and provinces  5 & 68 for the radio buttons
	  {
		  chkBoxes[u].disabled = false;
		  //chkBoxes[u].style.backgroundColor = "#FFFFFF";
	   }  
	 }

    function CheckCounties()
	{
	  chkBoxes  = x.elements;   //the checkboxes for states and provinces
	  for(u = 4; u < 56; u++)// go through all the  checkboxes for US states 
	  {
		  if(chkBoxes[u].checked == true)
		  {
			  return true;
		  }
	  }
	  alert('You must select at least one US State');
	  return false;
	}
	 function CheckForm(subCounties)
	 {
	  x = document.searchform;
	  var errMessage;
	  GoStates = false;
	   if( x.optALL.checked ==  true ||  x.optCAN.checked ==  true ||  x.optUS.checked ==  true)
			  GoStates = true;
	  //if(document.getElementById('US_CAN_ALL').value != '')// added 12/17/2009 for new select box for US/Can
      else 
	  {
	      chkBoxes  = x.elements;   //the checkboxes for states and provinces
		  for(u = 4; u < 70; u++)// go through all the radios for US/Can and checkboxes for states and provinces
		  {
			  if(chkBoxes[u].checked == true)
			  {
				  GoStates = true;
				  break;
			  }
		  }  
	  }
	  if(GoStates == false)
	  {
		 alert('You Must Select a State or a Province or check the US or check Canada or check Both!');
		 x.states1.focus(); // puts focus on Alabama checkbox
		 return false;
	  }

     if(x.txtZipRadius.value.length)
	 {
     //  alert('ZipRadisu = ' + x.txtZipRadiusMiles.value);
	  if(x.txtZipRadiusMiles.value > 250 || x.txtZipRadiusMiles.value < 0 || x.txtZipRadiusMiles.value == '')
	  {
		x.txtZipRadiusMiles.select();
		alert('You Must Enter a Mile Radius between 1 and 250!');
		return false;
	  }//
	  else if((isNaN(x.txtZipRadius.value) || x.txtZipRadius.value.length != 5))
	  {
		x.txtZipRadius.select();
		alert('You Must Enter a valid zip code for the radius search!');
		return false;
	  }
	 }

	   /*  else      if(x.txtCPCRadius.value.length)
	 { // commented out, 1/14/2010, JDF,  until we fix canadian postal codes
     //  alert('ZipRadisu = ' + x.txtZipRadiusMiles.value);
	  if(x.txtCPCRadiusMiles.value > 250 || x.txtCPCRadiusMiles.value < 0 || isNaN(x.txtCPCRadiusMiles.value))
	  {
		x.txtCPCRadiusMiles.select();
		alert('You Must Enter a Mile Radius between 1 and 250 for Canadian radius search!');
		return false;
	  }//
	  else if((x.txtCPCRadius.value.length < 6))
	  {
		x.txtCPCRadius.select();
		alert('You Must Enter a valid Canadian postal code for the Canadian radius search!');
		return false;
	  }
	 }  */
	 return true;
   }

	 /// Locks out city,  and zip boxes when counties are selected then unlocks them if unselected
	 function LockoutBoxes(value)
	 {
	  x = document.forms[0];
	   if(value != "")
	  {
        for(xyz = 0; xyz < x.city.length; xyz++)
	    {
		   x.city[xyz].disabled = true;
		   x.city[xyz].style.backgroundColor="#FF4444";
        }
		   x.txtZipRadiusMiles.disabled = true;
		   x.txtZipRadius.disabled = true;
		   x.txtZipRadiusMiles.style.backgroundColor="#FF4444";
		   x.txtZipRadius.style.backgroundColor="#FF4444";
		   for(a=0; a < x.txtZip.length; a++)
		   {
			x.txtZip[a].disabled = true;
			x.txtZip[a].style.backgroundColor="#FF4444";
		   }
		 }
		else
		{
         for(xyz = 0; xyz < x.city.length; xyz++)
	     {
		   x.city[xyz].disabled = false;
		   x.city[xyz].style.backgroundColor="#CCCCDD";
         }
		   x.txtZipRadiusMiles.disabled = false;
		   x.txtZipRadius.disabled = false;
		   x.txtZipRadiusMiles.style.backgroundColor="#CCCCDD";
		   x.txtZipRadius.style.backgroundColor="#CCCCDD";
		   for(a=0; a < x.txtZip.length; a++)
		   {
			x.txtZip[a].disabled = false;
			x.txtZip[a].style.backgroundColor="#CCCCDD";
		   }
		   /*  x.MHHIncLo.disabled = false;
		   x.MHHIncHi.disabled = false;
		   x.MHHIncLo.style.backgroundColor="#FFFFFF";
		   x.MHHIncHi.style.backgroundColor="#FFFFFF";  */
		 }
	 }
	 function LockoutBoxesRadius(value)
	 {
	  x = document.forms[0];
	   if(value != "")
	   {
        for(xyz = 0; xyz < x.city.length; xyz++)
	    {
		   x.city[xyz].disabled = true;
		   x.city[xyz].style.backgroundColor="#FF4444";
        }
		   x.Counties.disabled = true;
		   x.Counties.style.backgroundColor="#FF4444";
		   for(a=0; a < x.txtZip.length; a++)
		   {
			x.txtZip[a].disabled = true;
			x.txtZip[a].style.backgroundColor="#FF4444";
		   }
		 }
		else
		 {
         for(xyz = 0; xyz < x.city.length; xyz++)
	     {
		   x.city[xyz].disabled = false;
		   x.city[xyz].style.backgroundColor="#CCCCDD";
         }
		   x.Counties.disabled = false;
		   x.Counties.style.backgroundColor="#CCCCDD";
		   for(a=0; a < x.txtZip.length; a++)
		   {
			x.txtZip[a].disabled = false;
			x.txtZip[a].style.backgroundColor="#CCCCDD";
		   }
		 }
	 }
	//locks out counties box if state is changed
	 function CheckCounty(state)
	 {
	  x = document.forms[0];
	  if(state != document.getElementById('St').innerHTML)
	  {
	   x.Counties.value='';
	   x.Counties.disabled=true;
	   LockoutBoxes('');
	  }
	  else
	  {
	   x.Counties.value='';
	   x.Counties.disabled=false;
	  }
	 }
   //////////////////////////////// BOX JUMPER FUNCTION ////////////////////////////////////////////
    /*  USE inside input element    onkeyup="NextBox(this.id, event);"   id="blaubleh  */
       function NextBox(boxID, event)
       {
           //alert(event.keyCode);
        if(event.keyCode > 47)   // unprintable characters are all less than 47
        {
        Box = document.getElementsByTagName('input');
        BoxL = Box.length;
        llen = document.getElementById(boxID).value.length;
        maxL = document.getElementById(boxID).maxLength;
        if(llen >= maxL)
         {
            for (x=0; x<BoxL; x++ )
            {
                if(boxID == Box[x].id )
                {
                    Box[++x].focus();
                    //Box[x].select();
                    break;
                }
            }
         }
        }// key check
       }
       ////////////////////// END FUNCTION //////////////////////