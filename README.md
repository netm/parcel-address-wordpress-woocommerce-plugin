# NZ Post ParcelAddress Wordpress Woocommerce Plugin
A Wordpress Plugin that auto completes address using the NZ Post ParcelAddress API

## Installation
- Apply to NZ Post for a ClientId and Secret for the ParcelAddress API
- Click the 'Code' button to download the zip of this project and either add it to your plugins folder or upload through the Wordpress GUI, activate the plugin.
- Look for the settings 'Parcel Address Settings' under 'Settings' in main backend Wordpress menu, fill in the API settings
- Check your Checkout page has auto complete for the first address field

## Features

* ParcelAddress Autocomplete address Suggestions
* Address suggestions are relative to the selected country
* Removes State/Region for NZ addresses
* Works for both Billing and Shipping addresses
* Supports the latest version of Wordpress

## Debugging

It doesn't work!

* Use your inspector to see if it loads the appropriate files (look for parcel_address_plugin.js) NB: it only loads on checkout pages
* Check in the inspector for Javascript errors, if the API authentication is broken it will tell you

## Need help? Or a customised plugin?

* Post an issue on the Github project or contact me.

## With thanks to...
- NZ Post
- This was forked from Picwa, kevin0210, https://wpsocket.com/plugin/parcel-address-autocomplete-for-woocommerce/installation/
