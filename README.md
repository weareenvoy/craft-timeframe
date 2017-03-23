# Timeframe plugin for Craft CMS 3

Craft field type for a time frames ex. 10am - 12pm

## Installation

Follow the below steps to install with composer.
1. Install with composer `cd /craftproject`
2. Run the following command: `composer require weareenvoy/craft-timeframe`
3. Go to Settings > Plugins and enable the plugin.


## Template usage

For example if have a field named mondayHours with the timeframe field you can 
access the start and end time like so:
`{{entry.mondayHours.startTime|time('short)}} - {{entry.mondayHours.endTime|time('short)}}`

