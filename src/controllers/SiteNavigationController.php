<?php

namespace envision\sitenavigation\controllers;

use Craft;
use craft\web\Controller;
use envision\sitenavigation\SiteNavigation;

class SiteNavigationController extends Controller
{
    public function actionSaveSections()
    {
      // This action should only be available to the control panel
      $this->requireCpRequest();

      $sections = Craft::$app->getRequest()->getRequiredParam('sections');

      SiteNavigation::$plugin->siteNavigation->saveSections($sections);

      Craft::$app->getSession()->setNotice(Craft::t('site-navigation', 'Settings saved.'));

      return $this->redirect('site-navigation');
    }
}
