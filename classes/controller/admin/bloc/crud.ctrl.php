<?php
namespace Lib\Blocs;

class Controller_Admin_Bloc_Crud extends \Nos\Controller_Admin_Crud
{
//    protected function init_item()
//    {
//        dd($this->item->bloc_type);
//        parent::init_item();
//        if ($this->item->bloc_type == 'folder') {
//            $this->config['layout']['content']['proprietes']['params']['options']['allowExpand'] = false;
//            $this->config['layout']['content']['proprietes']['params']['options']['expanded'] = false;
//        }
//    }

//    protected function fieldset($fieldset)
//    {
//        $fieldset = parent::fieldset($fieldset);
//        if ($this->item->bloc_type == 'folder') {
////            dd($this->config['layout']['content']['proprietes']['params']);
//            $this->config['layout']['content']['proprietes']['params']['options']['allowExpand'] = false;
//            $this->config['layout']['content']['proprietes']['params']['options']['expanded'] = false;
//        }
//        return $fieldset;
//    }

    public function action_form($id = null)
    {
        $this->item = $this->crud_item($id);
        if ($this->item->bloc_type == 'folder') {
            $this->config['layout_update']['content']['proprietes']['params']['options']['allowExpand'] = false;
            $this->config['layout_update']['content']['proprietes']['params']['options']['expanded'] = false;
        }
//        dd($this->config);
        return parent::action_form($id);
    }
}
