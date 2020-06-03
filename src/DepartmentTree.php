<?php


namespace task_report;


class DepartmentTree extends AbstractTree
{

    public function treeFactory(DataProvider $data)
    {
        $arrData = $data->getData();
        foreach ($arrData as $itemData)
            $this->addContainerTree(new ContainerTree(new Department($itemData['ID'], $itemData['NAME'])));
        foreach ($arrData as $itemData)
            if($itemData['IBLOCK_SECTION_ID'])
            {
                $this->getContainerById($itemData['IBLOCK_SECTION_ID'])->addContainerArrChildrenId($itemData['ID']);
                $this->getContainerById($itemData['ID'])->setContainerPreId($itemData['IBLOCK_SECTION_ID']);
            }
    }
}