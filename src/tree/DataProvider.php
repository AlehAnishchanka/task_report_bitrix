<?php


namespace Tree;

use MongoDB\Driver\Query;

class DataProvider
{
    private $isTest = true;
    private $data;
    public function __construct( $query)
    {
        if($this->isTest) $this->data = $this->getDataArr();
        else $this->data = $this->getArrByRequest($query);
    }

    public function getData()
    {
        return $this->data;
    }

    private function getArrByRequest($req) {
        global $DB;
        $executedReq = $DB->Query($req, true);
        while($elemArr = $executedReq->Fetch()) $returnArr[] = $elemArr;
        return $returnArr;
    }

    private function getDataArr()
    {
        return include_once "testArrForDataProvider.php";
    }

}