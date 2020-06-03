<?php


namespace task_report;


class ContainerTree
{
    private $containerId;
    private $containerContent;
    public $containerArrChildrenId;
    private $containerPreId;
    private $containerNextId;
    private $containerVisited;
    private $keySort;
    private $level;

    public function __construct(ContainerContent $containerItem)
    {
        $this->containerId = $containerItem->getId();
        $this->containerContent = $containerItem->getContent();
        $this->containerArrChildrenId = [];
        $this->containerPreId = null;
        $this->containerNextId = null;
        $this->containerVisited = false;
        $this->keySort = null;
    }

    public function getContainerId()
    {
        return $this->containerId;
    }

    public function getPreId()
    {
        return $this->containerPreId;
    }

    public function setContainerPreId($containerPreId)
    {
        $this->containerPreId = $containerPreId;
    }

    public function getNextId()
    {
        return $this->containerNextId;
    }

    public function getContainerContent()
    {
        return $this->containerContent;
    }

    public function getContainerArrChildrenId()
    {
        return $this->containerArrChildrenId;
    }

    public function addContainerArrChildrenId($idChildren)
    {
        $this->containerArrChildrenId[] = $idChildren;
    }

    public function isContainerVisited ()
    {
        return $this->containerVisited;
    }

    public function setContainerVisited()
    {
        $this->containerVisited = true;
    }

    public function resetContainerVisited()
    {
        $this->containerVisited = false;
    }

    public function getKeySort()
    {
        return $this->keySort;
    }

    public function setKeySort($keySort)
    {
        $this->keySort = $keySort;
    }

    public function getLevel()
    {
        return $this->level;
    }

    public function setLevel($level)
    {
        $this->level = $level;
    }


}