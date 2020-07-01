<?php
namespace envision\sitenavigation\variables;

use Craft;
use craft\web\View;
use envision\sitenavigation\SiteNavigation;
use envision\sitenavigation\models\SettingsModel;

class SiteNavigationVariable
{
    public function getSections()
    {
      $sections = SiteNavigation::$plugin->siteNavigation->getSections();
      return $sections;
    }

    public function includedSections()
    {
      $sections = SiteNavigation::$plugin->siteNavigation->includedSections();
      return $sections;
    }
    
    public function render($limit = 10, $startLevel = 1)
    {      
      $oldMode = \Craft::$app->view->getTemplateMode();
      \Craft::$app->view->setTemplateMode(View::TEMPLATE_MODE_CP);
      $html = \Craft::$app->view->renderTemplate('site-navigation/menu', [
        'sections' => SiteNavigation::$plugin->siteNavigation->includedSections(),
        'limit' => $limit,
        'level' => $startLevel,
      ]);
      echo $html;
      \Craft::$app->view->setTemplateMode($oldMode);
    }
}
