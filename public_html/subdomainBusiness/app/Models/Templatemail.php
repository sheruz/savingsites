<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Templatemail extends CI_Model
{

    function send($templateText, $to, $from, $subject, $data, $templateFile = false)
    {

      $this->load->library('email');

        if(!is_array($from)){
            $from = array($from);
        }
        foreach($from as $fr)
        {
            if(is_array($fr))
            {
               $this->email->from( $fr['email'], $fr['name']);
            }
            else
            {
                $this->email->from($fr->email, $fr->name);
            }
        }

        if(!is_array($to)){ $to = array($to);}

        foreach($to as $address)
        {
            $this->email->to($address); 
        }
        $this->email->subject($subject);
        if(!empty($templateFile))
        {
            $templateText = $this->load->view($templateFile, $data, true);
        }
        $this->email->message($templateText);	


        $this->email->send();


    

    }
}