<?php
require "vendor/autoload.php";

$request = "select ID, NAME, IBLOCK_SECTION_ID from b_iblock_section where IBLOCK_ID=5";
$tree = new Tree\DepartmentTree($request);
echo $tree->getTreeSelectForHTML();
//$tree->treeReduce(function($a,$b){return $a." ".$b." ";});
//$str = $tree->toString();
//print_r($str);
//var_dump($tree);
//print_r((new DataProvider("select ID, NAME, IBLOCK_SECTION_ID from b_iblock_section where IBLOCK_ID=5"))->getData());