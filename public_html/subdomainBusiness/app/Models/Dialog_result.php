<?php
class Dialog_result extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function GetDR($title, $message, $tag = false, $height = false)
    {
        $dr = new dialogResult();
        $dr->Title = $title;
        $dr->Message = $message;
        $dr->Tag = $tag;

        if(!empty($height))
        {
            $dr->Height = $height;
        }

        return json_encode($dr);
    }
	public function GetDR_athena($message){
        return json_encode($message);
	}
}

class dialogResult{
    var $Title;
    var $Height;
    var $Message;
    var $Tag;
}
