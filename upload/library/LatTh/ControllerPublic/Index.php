<?php
class LatTh_ControllerPublic_Index extends XFCP_LatTh_ControllerPublic_Index {
    
    
    public function actionIndex()
    {
        if(method_exists('XFCP_LatTh_ControllerPublic_Index', 'actionIndex')){
            $response = parent::actionIndex();    
            if ($response instanceof XenForo_ControllerResponse_View) {
                $this->getTicker($response);
            }
            return $response;        
        }
    }
    
    public static function getTicker($response)
    {
        $options = XenForo_Application::get('options');
        $user = XenForo_Visitor::getInstance();
        $last_on= $options->last_on;
        $grOptions = $options->lusr_group;
        if ($last_on AND in_array($user['user_group_id'], $grOptions)){
        if(empty($response->params['LatTh']))
        {
            $response->params['LatTh'] = array();
        }
        
        $LatThModel = XenForo_Model::create('LatTh_Model_LatTh');
        
        $Threads=array();
  $nodesliarr= $options->LatTh_forum_nodes;
  $nodesli= implode(",", $nodesliarr);

  if ($nodesli !="" ){
   $_Threads = $LatThModel->getThreadsByForumIds($nodesli, $options->LatTh_threads_count);
  
   for ($x=0; $x < count($_Threads); $x++)
   {
    $ThreadObject = $_Threads[$x];
    $ThreadObject['post_date2'] = date("d.m.Y",$ThreadObject['post_date']);
    if ($options->LatTh_cut_title) {
     $ThreadObject['title'] = substr($ThreadObject['title'], 0, $options->LatTh_title_length);
     $ThreadObject['title'] = $ThreadObject['title'] . '...';
    }
    $Threads[$x] = $ThreadObject;
   }
  }
        
        if ($nodesli=="") {
            $nodes = 1;
            } else {
            $nodes = 0;
            }
            
        $response->params['LatTh'] += array(
            "nodes" => $nodes,
            "threads" => $Threads,
            "time" => time()
        );
    }
    }
}