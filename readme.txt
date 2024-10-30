=== LTL Freight Quotes - SEFL Edition ===
Contributors: enituretechnology
Tags: eniture,Southeastern Freight Lines,,LTL freight rates,LTL freight quotes, shipping estimates
Requires at least: 6.4
Tested up to: 6.6
Stable tag: 3.2.4
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Real-time LTL freight quotes from Southeastern Freight Lines. Fifteen day free trial.

== Description ==

Southeastern Freight Lines, abbreviated as SEFL, is a privately owned American LTL trucking company headquartered in Lexington, South Carolina. It originates service in the Southeastern and Southwestern United States and makes deliveries throughout the United States, Canada, and Mexico. A network of service partners is used for transportation to areas outside of its service area. SEFL is the 11th largest American LTL carrier with a revenue of over $1 billion. If you don’t have a Southeastern Freight Lines account number, contact them at 803-794-7300.

**Key Features**

* Displays negotiated LTL shipping rates in the WooCommerce checkout page.
* Provides quotes for shipments within the United States and to Canada.
* Custom label results displayed in the shopping cart.
* Define multiple warehouses.
* Identify products that drop ship from vendors.
* Display transit times with returned quotes.
* Product specific freight classes.
* Support for variable products.
* Option to determine a product's class by using the built in density calculator.
* Option to include residential delivery fees.
* Option to include fees for lift gate service at the destination address.
* Option to mark up quoted rates by a set dollar amount or percentage.
* Works seamlessly with other quoting apps published by Eniture Technology.

**Requirements**

* WooCommerce 6.4 or newer.
* A Southeastern Freight Lines (SEFL) account number..
* Your sefl.com username and password.
* Customer Address, the address on your Southeastern Freight Lines account.
* A API key from Eniture Technology.

== Installation ==

**Installation Overview**

Before installing this plugin you should have the following information handy:

* A Southeastern Freight Lines (SEFL) account number..
* Your sefl.com username and password.
* Customer Address, the address on your Southeastern Freight Lines account.

If you need assistance obtaining any of the above information, contact your local Southeastern Freight Lines
or call the [Southeastern Freight Lines](http://sefl.com) corporate office at 803-794-7300.

A more extensive and graphically illustrated set of instructions can be found on the *Documentation* tab at
[eniture.com](https://eniture.com/woocommerce-sefl-ltl-freight/).

**1. Install and activate the plugin**
In your WordPress dashboard, go to Plugins => Add New. Search for "eniture SEFL freight quotes", and click Install Now.
After the installation process completes, click the Activate Plugin link to activate the plugin.

**2. Get a API key from Eniture Technology**
Go to [Eniture Technology](https://eniture.com/woocommerce-sefl-ltl-freight/) and pick a
subscription package. When you complete the registration process you will receive an email containing your API key and
your login to eniture.com. Save your login information in a safe place. You will need it to access your customer dashboard
where you can manage your API keys and subscriptions. A credit card is not required for the free trial. If you opt for the free
trial you will need to login to your [Eniture Technology](http://eniture.com) dashboard before the trial period expires to purchase
a subscription to the API key. Without a paid subscription, the plugin will stop working once the trial period expires.

**3. Establish the connection**
Go to WooCommerce => Settings => SEFL. Use the *Connection* link to create a connection to your Southeastern Freight Lines (SEFL)
account.

**4. Select the plugin settings**
Go to WooCommerce => Settings => SEFL. Use the *Quote Settings* link to enter the required information and choose
the optional settings.

**6. Define warehouses and drop ship locations**
Go to WooCommerce => Settings => SEFL. Use the *Warehouses* link to enter your warehouses and drop ship locations.  You should define at least one warehouse, even if all of your products ship from drop ship locations. Products are quoted as shipping from the warehouse closest to the shopper unless they are assigned to a specific drop ship location. If you fail to define a warehouse and a product isn’t assigned to a drop ship location, the plugin will not return a quote for the product. Defining at least one warehouse ensures the plugin will always return a quote.

**7. Enable the plugin**
Go to WooCommerce => Settings => Shipping. Click on the Shipping Zones link. Add a US domestic shipping zone if one doesn’t already exist. Click the “+” sign to add a shipping method to the US domestic shipping zone and choose SEFL from the list.

**8. Configure your products**
Assign each of your products and product variations a weight, Shipping Class and freight classification. Products shipping LTL freight should have the Shipping Class set to “LTL Freight”. The Freight Classification should be chosen based upon how the product would be classified in the NMFC Freight Classification Directory. If you are unfamiliar with freight classes, contact the carrier and ask for assistance with properly identifying the freight classes for your  products.

== Frequently Asked Questions ==

= How do I get an SEFL account number?

Call SEFL at 803-794-7300.

= Where do I find my sefl.com username and password?

Contact SEFL customer service (803-794-7300) or request a username and password online.

= How do I get a API key for the plugin?

You must register your installation of the plugin, regardless of whether you are taking advantage of the trial period or purchased a API key outright. At the conclusion of the registration process an email will be sent to you that will include the API key. You can also login to eniture.com using the username and password you created during the registration process and retrieve the API key from the My API keys tab.

= How do I change my plugin API key from the trial version to one of the paid subscriptions?

Login to eniture.com and navigate to the My API keys tab. There you will be able to manage the licensing of all of your Eniture Technology plugins. Refer to the Documentation tab on this page for more thorough instructions.

= How do I install the plugin on another website?

The plugin has a single site API key. To use it on another website you will need to purchase an additional API key. If you want to change the website with which the plugin is registered, login to eniture.com and navigate to the My API keys tab. There you will be able to change the domain name that is associated with the API key.

= Do I have to purchase a second API key for my staging or development site?

No. Each API key allows you to identify one domain for your production environment and one domain for your staging or development environment. The rate estimates returned in the staging environment will have the word “Sandbox” appended to them.

= Why isn’t the plugin working on my other website?

If you can successfully test your credentials from the Connection page (WooCommerce > Settings > SEFL > Connections) then you have one or more of the following licensing issues: 1) You are using the API key on more than one domain. The API keys are for single sites. You will need to purchase an additional API key. 2) Your trial period has expired. 3) Your current API key has expired and we have been unable to process your form of payment to renew it. Login to eniture.com and go to the My API keys tab to resolve any of these issues.

= Why are the shipment charges I received on the invoice from Southeastern Freight Lines (SEFL) different than what was quoted by the app?

Common reasons include a difference in the quoted versus billed shipment parameters (weight, dimensions, freight class), or additional services (such as residential delivery) were required. Compare the details of the invoice to the shipping settings on the products included in the shipment. Consider making changes as needed. Remember that the weight of the packing materials is included in the billable weight for the shipment. If you are unable to reconcile the differences call SEFL customer service (803-794-7300) for assistance.

= Why do I sometimes get a message that a shipping rate estimate couldn’t be provided?

There are several possibilities:

The most common reason is that one or more of the products in the shopping cart did not have its shipment parameters (weight, dimensions, freight class) adequately populated. Check the settings for the products on the order and make corrections as necessary.

1) The city entered for the shipping address may not be valid for the postal code entered. A valid City+State+Postal Code combination is required to retrieve a rate estimate. Contact us by phone (404-369-0680) or email (support@eniture.com) to inquire about Address Validation solutions for this problem.

2) Your shipment exceeded constraining parameters of SEFL’s web service.

3) The SEFL web service isn’t operational.

4) Your SEFL account has been suspended or cancelled.

5) There is an issue with the Eniture Technology servers.

6) Your subscription to the application has expired because payment could not be processed.

7) There is an issue your server.

= How do I determine the freight class for my product(s)?

The easiest thing to do is to contact your Southeastern Freight Lines representative and ask for assistance. However, the official source is the National Motor Freight Classification (NMFC) directory maintained by the National Motor Freight Transportation Agency (NMFTA.org). You can purchase a hard copy of the directory or obtain an online subscription to it from their web site.

= How does the density calculator work?

The density calculator will calculate a freight class by performing a calculation using the product weight and dimensions as inputs. In most cases the returned freight class will match the product’s (commodity’s) freight class as recorded in the National Motor Freight Classification (NMFC) directory. However, this is not always true and in the event there are differences, the freight class recorded in the National Motor Freight Classification (NMFC) directory takes precedence. An incorrectly identified freight class can result in unexpected shipping charges and even fees. You are solely responsible for accurately identifying the correct freight class for your products. If you need help doing this, contact your Southeastern Freight Lines Freight representative for assistance.


== Screenshots ==

1. Carrier inclusion page
2. Quote settings page
3. Quotes displayed in cart

== Changelog ==

= 3.2.4 =
* Update: Updated connection tab according to WordPress requirements 

= 3.2.3 =
* Update: Introduced capability to suppress parcel rates once the weight threshold has been reached.
* Update: Compatibility with WordPress version 6.5.2
* Update: Compatibility with PHP version 8.2.0
* Fix:  Incorrect product variants displayed in the order widget.

= 3.2.2 =
* Update: Introduced the handling unit feature.
* Update: Updated the description text in the warehouse.

= 3.2.1 =
* Update: Changed required plan from standard to basic for delivery estimate options.

= 3.2.0 =
* Update: Introduced the Origin Level Markup feature
* Update: Introduced the Product Level Markup Feature
* Update: Display "Free Shipping" at checkout when handling fee in the quote settings is  -100% .
* Update: Introduce the Shipping Logs feature.

= 3.1.10 =
* Update: Compatibility with WooCommerce HPOS(High-Performance Order Storage)

= 3.1.9 =
* Update: Modified expected delivery message at front-end from “Estimated number of days until delivery” to “Expected delivery by”.
* Fix: Inherent Flat Rate value of parent to variations.
* Fix: Fixed space character issue in city name. 

= 3.1.8 =
* Update: Added compatibility with "Address Type Disclosure" in Residential address detection

= 3.1.7 =
* Update: Compatibility with WordPress version 6.1
* Update: Compatibility with WooCommerce version 7.0.1

= 3.1.6 =
* Update: Show In-store pickup and local delivery options if API returns error

= 3.1.5 =
* Update: Introduced connectivity from the plugin to FreightDesk.Online using Company ID

= 3.1.4 =
* Update: Compatibility with WordPress version 6.0.
* Update: Included tabs for freightdesk.online and validate-addresses.com

= 3.1.3 =
* Update: Compatibility with WordPress multisite network
* Fix: Fixed support link.

= 3.1.2 =
* Update: Compatibility with PHP version 8.1.
* Update: Compatibility with WordPress version 5.9.

= 3.1.1 =
* Update: Relocation of NMFC Number field along with freight class.

= 3.1.0 =
* Update: Added features, Multiple Pallet Packaging and data analysis.

= 3.0.0 =
* Update: Compatibility with PHP version 8.0.
* Update: Compatibility with WordPress version 5.8.
* Fix: Corrected product page URL in connection settings tab.

= 2.3.1 =
* Update: Added feature "Weight threshold limit"
* Update: Added feature In-store pickup with terminal information

= 2.3.0 =
* Update: Cuttoff Time.
* Update: Added images URL for freightdesk.online portal.
* Update: CSV columns updated.
* Update: Virtual product details added in order meta data.
* Update: Compatibility with Shippable addon.
* Update: Compatibility with Micro-warehouse addon.

= 2.2.2 =
* Update: Introduced new features, Compatibility with WordPress 5.7, Order detail widget for draft orders, improved order detail widget for Freightdesk.online, compatibly with Shippable add-on, compatibly with Account Details(ET) add-don(Capturing account number on checkout page).

= 2.2.1 =
* Update: Fixed issue, when small product added to the cart page.

= 2.2.0 =
* Update: Compatibility with WordPress 5.6

= 2.1.0 =
* Update: Added features, a)Product Nesting b)Compatibility with Freightdesk.online

= 2.0.6 =
* Update: Compatibility with WordPress 5.5

= 2.0.5 =
* Update: Compatibility with WordPress 5.4

= 2.0.4 =
* Update: Change of Label AS logic for shipments originate from multiple locations

= 2.0.3 =
* Update: Introduced Test connection with thirdParty and shipper account

= 2.0.2 =
* Update: Compatibility with WordPress 5.1

= 2.0.1 =
* Fix: Identify one warehouse and multiple drop ship locations in basic plan.

= 2.0.0 =
* Update: Introduced new features and Basic, Standard and Advanced plans.

= 1.3.1 =
*Update: Compatibility with WordPress 5.0

= 1.3.0 =
* Update: Introduced compatibility with the Residential Address Detection plugin.

= 1.2.0 =
* Update: Added the ability to identify the 3rd party account number 

= 1.1.2 =
* Fix: JS conflict resolved on test connection

= 1.1.1 =
* Fix: Fixed issue with new reserved word in PHP 7.1

= 1.1.0 =
* Update: Compatibility with WordPress 4.9

= 1.0.0 =
* Initial release.

== Upgrade Notice ==

