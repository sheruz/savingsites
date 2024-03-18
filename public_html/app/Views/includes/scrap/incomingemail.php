<?=$this->extend("layout/scrapmaster")?>

<?=$this->section("pageTitle")?>
  Savings Sites
<?=$this->endSection()?>
  
<?=$this->section("scrapcontent")?>
<?php $i = 0; ?>
<style>
  body {
font-family: Arial;
}
table {
  font-family: arial, sans-serif;
  border-collapse: collapse;
  width: 100%;
}
tr:nth-child(even) {
  background-color: #dddddd;
}
td, th {
  padding: 8px;
  width:100px;
  border: 1px solid #dddddd;
  text-align: left;       
}
.form-container {
  padding: 20px;
  background: #F0F0F0;
  border: #e0dfdf 1px solid;        
  border-radius: 2px;
}
* {
  box-sizing: border-box;
}

.columnClass {
  float: left;
  padding: 10px;
}

.row:after {
  content: "";
  display: table;
  clear: both;
}

.btn {
  background: #333;
  border: #1d1d1d 1px solid;
  color: #f0f0f0;
  font-size: 0.9em;
  width: 200px;
  border-radius: 2px;
  background-color: #f1f1f1;
  cursor: pointer;
}

.btn:hover {
  background-color: #ddd;
}

.btn.active {
  background-color: #666;
  color: white;
}

</style>
<script>
  function getEmails() {
    document.getElementById('dataDivID').style.display = "block";
  }
  </script>

  <h2>List Emails from Gmail using PHP and IMAP</h2>

  <div id="btnContainer">
    <button class="btn active" onclick="getEmails()">
      <i class="fa fa-bars"></i>Click to get gmail mails
    </button>
  </div>
  <br>
  
  <div id="dataDivID" class="form-container" style="display:none;">
    <?php

     
   


































    
      $host = '{mail.nexusfleck.com:143/imap/notls}INBOX';
      $user = 'salman@nexusfleck.com';
      $password = 'aL)qQfequn2M';

 

      /* Establish a IMAP connection */
      $conn = imap_open($host, $user, $password)
        or die('unable to connect Gmail: ' . imap_last_error());
        // echo "<pre>";print_r($conn);die;
      /* Search emails from gmail inbox*/
      $mails = imap_search($conn, 'ALL');

      /* loop through each email id mails are available. */
      if ($mails) {

        /* Mail output variable starts*/
        $mailOutput = '';
        $mailOutput.= '<table><tr><th>Subject </th><th> From </th>
            <th> Date Time </th> <th> Content </th></tr>';

        /* rsort is used to display the latest emails on top */
        rsort($mails);

        /* For each email */
        foreach ($mails as $email_number) {

          /* Retrieve specific email information*/
          $headers = imap_fetch_overview($conn, $email_number, 0);

          /* Returns a particular section of the body*/
          $message = imap_fetchbody($conn, $email_number, '1');
          $subMessage = substr($message, 0, 150);
          $finalMessage = trim(quoted_printable_decode($subMessage));

          $mailOutput.= '<div class="row">';

          /* Gmail MAILS header information */        
          $mailOutput.= '<td><span class="columnClass">' .
                $headers[0]->subject . '</span></td> ';
          $mailOutput.= '<td><span class="columnClass">' .
                $headers[0]->from . '</span></td>';
          $mailOutput.= '<td><span class="columnClass">' .
                $headers[0]->date . '</span></td>';
          $mailOutput.= '</div>';

          /* Mail body is returned */
          $mailOutput.= '<td><span class="column">' .
          $finalMessage . '</span></td></tr></div>';
        }// End foreach
        $mailOutput.= '</table>';
        echo $mailOutput;
      }//endif

      /* imap connection is closed */
      imap_close($conn);
      ?>
  </div>


<script src="https://code.jquery.com/jquery-3.6.3.min.js" integrity="sha256-pvPw+upLPUjgMXY0G+8O0xUf+/Im1MZjXxxgOcBQBXU=" crossorigin="anonymous"></script>

<?=$this->endSection()?>