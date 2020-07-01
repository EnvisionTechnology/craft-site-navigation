<?php
namespace envision\sitenavigation;

use Craft;
use craft\base\Plugin;
use craft\models\Section;
use craft\services\Sections;
use craft\events\SectionEvent;
use craft\web\twig\variables\CraftVariable;
use yii\base\Event;

use envision\sitenavigation\models\SettingsModel;
use envision\sitenavigation\services\SiteNavigationService;
use envision\sitenavigation\variables\SiteNavigationVariable;

class SiteNavigation extends Plugin
{
  public static $plugin;
  public $hasCpSettings = true;

  public function init()
  {
    parent::init();
    self::$plugin = $this;

    // Register services as components
    $this->setComponents([
      'siteNavigation' => SiteNavigationService::class,
    ]);

    // Register variable
    Event::on(CraftVariable::class, CraftVariable::EVENT_INIT, function(Event $event) {
      /** @var CraftVariable $variable */
      $variable = $event->sender;
      $variable->set('siteNavigation', SiteNavigationVariable::class);
    });

    // initialize sections for if plugin is installed after sections are created
    if ( $this->getSettings()->sections === [] ) {
      $this->siteNavigation->initSections();
    }

    // Add section on creation
    Event::on(Sections::class, Sections::EVENT_AFTER_SAVE_SECTION, function(SectionEvent $e) {
      if ($e->isNew) {
        $this->siteNavigation->addSection($e->section);
      }
    });

    // Remove section on delete
    Event::on(Sections::class, Sections::EVENT_BEFORE_DELETE_SECTION, function(SectionEvent $e) {
      $this->siteNavigation->removeSection($e->section);
    });

  }

  protected function createSettingsModel(): SettingsModel
  {
      return new SettingsModel();
  }
  protected function settingsHtml()
  {
      return Craft::$app->getView()->renderTemplate('site-navigation/index', [
          'sections' => $this->siteNavigation->includedSections()
      ]);
  }
}