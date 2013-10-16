<?php

class LatTh_EventListener_LoadClassController
{
    public static function listen($class, array &$extend)
    {
        $extend[] = 'LatTh_ControllerPublic_Index';
    }
 public static function fileHashes(XenForo_ControllerAdmin_Abstract $controller, array &$hashes)
    {
        $fileHashes = LatTh_Model_Hashes::getHashes();
        $hashes += $fileHashes;
    }     

     public static function renderOption(XenForo_View $view, $fieldPrefix, array $preparedOption, $canEdit)
    {
        return self::_render('option_list_option_checkbox', $view, $fieldPrefix, $preparedOption, $canEdit);
    }
    
    /*
     * Render list of users in addon's option
     */
    protected static function _render($templateName, XenForo_View $view, $fieldPrefix, array $preparedOption, $canEdit)
    {
        $preparedOption['formatParams'] = XenForo_Option_UserGroupChooser::getUserGroupOptions(
            $preparedOption['option_value']
        );

        return XenForo_ViewAdmin_Helper_Option::renderOptionTemplateInternal(
            $templateName, $view, $fieldPrefix, $preparedOption, $canEdit
        );
    }
    
    public static function templateCreate($templateName, array &$params, XenForo_Template_Abstract $template)
    {
        $options = XenForo_Application::get('options');
        $LatTh_displayType = $options->LatTh_displayType;
     
         switch ($LatTh_displayType){
        case 3: $LatTh_dis = 'last_th';    break;
        case 4: $LatTh_dis = 'last_thh';    break;
         }
		if ($templateName == 'forum_list') {
            $template->preloadTemplate($LatTh_dis);
        }
    }
    
    public static function LastThtm($hookName, &$contnt, array $hookParams, XenForo_Template_Abstract $template)
 {    
       $options = XenForo_Application::get('options');
        $LatTh_displayType = $options->LatTh_displayType;
        $LatTh_position = $options->LatTh_position;
		
		 switch ($LatTh_displayType){
        case 3: $latHook = 'forum_list_nodes';    break;
        case 4: $latHook = 'forum_list_sidebar';    break;
         }
		
	      
         switch ($LatTh_displayType){
        case 3: $LatTh_dis = 'last_th';    break;
        case 4: $LatTh_dis = 'last_thh';    break;
         }
  
        if ($hookName == $latHook){
            $ourTemplate = $template->create($LatTh_dis, $template->getparams());
            $rendered = $ourTemplate->render();
        if ($LatTh_position == 1){ $contnt = $rendered . $contnt; } 
            else {$contnt .= $rendered;}
            }
 }
}