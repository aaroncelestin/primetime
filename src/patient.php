<?php
namespace Primetime;
class Patient {
    public $firstname;
    public $middlename;
    public $lastname;
    public $fullname = array("firstname"=>$firstname,
                             "middlename"=>$middlename,
                             "lastname"=>$lastname);

    public $ptemail;                         
    public $ptaddress;
    public $ptaddress2;
    public $ptPhone1;
    public $ptPhone2;
    public $ptGender;
    public $ptMstatus;
    public $ptCity;
    public $ptState;
    public $ptZip;
    public $ptDOB;
    public $ptReligious;
    public $ptPhone2;
    public $ptGender;
    public $ptMstatus;
    public $ptCity;
    public $ptState;
    public $ptZip;                     
    function __construct($firstname, $middlename, $lastname){
        $this->firstname = $firstname;
        $this->middlename = $middlename;
        $this->lastname = $lastname;
    }

}