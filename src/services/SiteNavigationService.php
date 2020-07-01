<?php
namespace envision\sitenavigation\services;

use Craft;
use craft\base\Component;
use craft\models\Section;

use envision\sitenavigation\SiteNavigation;
use envision\sitenavigation\models\SettingsModel;

class SiteNavigationService extends Component
{ 

  public function initSections() 
  {
    $sections = [];

    foreach (Craft::$app->sections->getAllSections() as $section) {
      // Exclude channels
      if ($section->type === Section::TYPE_CHANNEL) {
        continue;
      }

      $sections[$section->handle] = [
          'sectionName' => $section->name,
          'sectionHandle' => $section->handle,
          'includeInMenu' => '',
      ];
    }
    return $this->saveSections($sections);
  }

  public function addSection($newSection) {
    // Exclude channels
    if ($newSection->type === Section::TYPE_CHANNEL) {
      return false;
    }
    $settings = SiteNavigation::$plugin->getSettings();
    $sections = $settings->sections;

    $sections[$newSection->handle] = [
      'sectionName' => $newSection->name,
      'sectionHandle' => $newSection->handle,
      'includeInMenu' => '',
    ];

    return $this->saveSections($sections);
  }


  public function removeSection($oldSection) {
    // Exclude channels
    if ($oldSection->type === Section::TYPE_CHANNEL) {
      return false;
    }

    $settings = SiteNavigation::$plugin->getSettings();
    $sections = $settings->sections;

    if ( array_key_exists($oldSection->handle, $sections) ) {
      unset($sections[$oldSection->handle]);
    }

    return $this->saveSections($sections);
  }

  public function getSections() {
    $settings = SiteNavigation::$plugin->getSettings();

    return $settings->sections;
  }

  public function includedSections() {
    $allSections = $this->getSections();
    $included = [];

    // filter to only included sections
    foreach ($allSections as $section) {
      if ($section['includeInMenu'] === '1') { 
        $included[] = $section['sectionHandle'];
      }
    }

    return $included;
  }

  public function saveSections($sections)
  {
    //Craft::info($sections, 'tester save');

    $plugin = SiteNavigation::getInstance();
    if (\Craft::$app->plugins->savePluginSettings($plugin, ['sections' => $sections])) {
        return true;
    }
    return false;
  }

}
