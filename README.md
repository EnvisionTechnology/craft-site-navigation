# Site Navigation plugin for Craft CMS 3.4.x

## Installation

To install the plugin, manually add the package using composer.

`composer require envision/craft-site-navigation`

Then go to Settings > Plugins and choose to 'Install' the Site Navigation plugin.

## Settings

In the Control Panel, go to Site Navigation. There, select and reorganize sections on the site to display in the menu. Only singles and sections are selectable. Channels are excluded from the menu options.

## Display

To display all pages in an ordered list, add this tag to your template:

`{{ craft.siteNavigation.render() }}`

Optionally, set how many levels to show. For example, a typical main navigation starting at the first level and only showing direct children would be:

`{{ craft.siteNavigation.render(2) }}`

## Roadmap

- Add option to show children of a particular entry for subnavigation.

Brought to you by [Envision](https://www.envisionsuccess.net)
