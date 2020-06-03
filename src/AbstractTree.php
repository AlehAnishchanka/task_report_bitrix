<?php

namespace task_report;
abstract class AbstractTree
{
    protected $tree;
    protected $levelTab;
    protected $currentId;
    protected $currentSortKey = 0;
    protected $treeSelectForHTML;

    public function __construct($request)
    {
        $this->tree = [];
        $this->treeFactory(new DataProvider($request));
        $this->levelTab = 0;
        $this->currentId = $this->array_key_first($this->tree);
        $this->treeSelectForHTML = "<select multiple size='10' name=departmentArr>";
        $this->sortTree("setIndexForSortDepartment");
    }

    protected function addContainerTree(ContainerTree $container)
    {
        $this->tree[$container->getContainerId()] = $container;
        return $this;
    }

    protected function getContainerById($containerId)
    {
        return $this->tree[$containerId];
    }

    abstract public function treeFactory(DataProvider $data);

    public function ifExistsNextNoVisitedContainer()
    {
        if ($this->getContainerById($this->currentId)->getContainerArrChildrenId()) {
            return count(array_filter($this->getContainerById($this->currentId)->getContainerArrChildrenId(), function ($id) {
                    return !$this->getContainerById($id)->isContainerVisited();
                })) > 0;
        } else
            return false;
    }

    public function next()
    {
        $arrIdNoVisitedContainers = array_filter($this->getContainerById($this->currentId)->getContainerArrChildrenId(), function ($id) {
            return !$this->getContainerById($id)->isContainerVisited();
        });
        $this->levelTab++;
        $this->currentId = array_shift($arrIdNoVisitedContainers);//$arrIdNoVisitedContainers[0];
        return $this->currentId;//$arrIdNoVisitedContainers[0];
    }

    public function prev()
    {
        //echo "Зашел в prev";
        $preId = $this->getContainerById($this->currentId)->getPreId();
        $this->levelTab--;
        $this->currentId = $preId;
    }

    public function treeReduce($function)
    {
        $retReduce = $function("", $this->getContainerById($this->currentId)->getContainerContent(),$this->getContainerById($this->currentId)->getLevel());
        $this->getContainerById($this->currentId)->setContainerVisited();
        while ($this->existsNoVisitedContainer()) {
            if ($this->ifExistsNextNoVisitedContainer()) {
                $this->next();
                $retReduce = $function($retReduce, $this->getContainerById($this->currentId)->getContainerContent(),$this->getContainerById($this->currentId)->getLevel());
                $this->getContainerById($this->currentId)->setContainerVisited();
            } else $this->prev();
        }
        $this->resetTreeVisitedContainers();
        return $retReduce;
    }

    private function sortTree()
    {
        $this->treeMap("setIndexForSortDepartment");
        //usort($this->tree, "sortDepartment");
    }

    public function setIndexForSortDepartment ()
    {
        $this->getContainerById($this->currentId)->setKeySort($this->currentSortKey++);
    }

    private function sortDepartment($a,$b)
    {
        $aIndexSort = $a->getKeySort();
        $bIndexSort = $b->getKeySort();
        if ($aIndexSort == $bIndexSort) {
            return 0;
        }
        return ($aIndexSort < $bIndexSort) ? -1 : 1;
    }

    public function treeMap ($function)
    {
        $this->$function();
        $this->getContainerById($this->currentId)->setContainerVisited();
        $this->getContainerById($this->currentId)->setLevel($this->levelTab);
        $this->treeSelectForHTML .= "<option value=".$this->currentId.">" . str_repeat("----",$this->levelTab) . substr($this->getContainerById($this->currentId)->getContainerContent(),0,200) . "</option>";
        while ($this->existsNoVisitedContainer()) {
            if ($this->ifExistsNextNoVisitedContainer()) {
                $this->next();
                $this->$function();
                $this->getContainerById($this->currentId)->setContainerVisited();
                $this->getContainerById($this->currentId)->setLevel($this->levelTab);
                $this->treeSelectForHTML .= "<option value=".$this->currentId.">" . str_repeat("----",$this->levelTab) . substr($this->getContainerById($this->currentId)->getContainerContent(),0,200) . "</option>";
            } else $this->prev();
        }
        $this->resetTreeVisitedContainers();
        $this->treeSelectForHTML .= "</select>";
    }

    public function existsNoVisitedContainer()
    {
        $arrNoVisitedConts = array_filter($this->tree, function ($cont) {
            return !$cont->isContainerVisited();
        });
        return count($arrNoVisitedConts) > 0;
    }

    private function array_key_first($arr)
    {
        foreach ($arr as $key => $value) return $key;
    }

    public function toString()
    {
        $strForPrint = $this->treeReduce(function ($str,$addedStr,$numbSpaces)
        {
            return $str.str_repeat("----",$numbSpaces).$addedStr."<br>";
        });
        return $strForPrint;
    }

    private function resetTreeVisitedContainers()
    {
        foreach ($this->tree as $key=>$item) {
            $this->getContainerById($key)->resetContainerVisited();
        }
        $this->levelTab = 0;
        $this->currentId = $this->array_key_first($this->tree);
    }

    public function getTreeSelectForHTML()
    {
        return $this->treeSelectForHTML;
    }


}