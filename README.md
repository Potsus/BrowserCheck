# BrowserCheck
A php tool to detect the current browser and set compatibility levels

fastBrowserCheck is a collection of small tools that will check the browser version and compares it to a list of known compatible versions.

browserCheck employs simmilar but more comprehensive methods to tell the user about their current browser.
It will read from the same list of confirmed compatible browser versions and present the user with download options in the event their browser is unsupported.
Unsupported browsers don't have to be explicitly listed and if they icons in the logos folder they will be displayed with them along with whatever information BrowserCheck can gether while displaying the unsupported response text.

### Configuration:
You can change the location of browser icons and information about supported browsers in `config.ini`.

Set the name of your application under `appName` to make sure it's shown properly in the support text.

set the minimum acceptable version for each supported browser in the `browsers` array like this: `browsers[<ua>] = <minimum version>` where `<ua>` is the name in the user agent string of the browser you support. The current list should cover the most common browsers so you only need to set the versions you support for each. This is a convienient way to change the versions of different browsers you support, but for more advanced use you will need to look at `supported_browsers.php`


Currently I'm working on an update to allow unsupported browsers with a supported layout engine to pass with a flag in the config file to allow this.

#### Adding new browsers: `supported_browsers.php`
for now any browser added to the config with no entry in `supported_browsers.php` will throw an error to prevent you from shipping while supporting an unknown browser. You should add an entry to `supported_browsers.php` if you want to support it.

first thing you'll need is the name of the browser

Mozilla/5.0 | (Macintosh; Intel Mac OS X 10_13_0) | AppleWebKit/537.36 | (KHTML, like Gecko) | Chrome/61.0.3163.100 | Safari/537.36
the mozilla legacy flag | Info about the client computer | Layout engine | layout engine info | browser/version 1 | browser/version 2

you want the `browser` from that first browser/version combonation
follow the template at the top of `supported_browsers.php` to finish out the addition.


### Use:
___
you can see the provided `index.php` for an example use case
See `test.php` for examples of more advanced use
first import `browserCheck.php` into your php file

define your class instance with `$browser = new browser(<ua string>);`
`<ua string>` is an optional variable that will let you provide a User Agent String to test with but otherwise BrowserCheck will pull in the User Agent of the client making the page request

BrowserCheck will process the user agent on construction of the class instance and from there you can access its usefull functions. 

`drawPage()` will echo a box with info about the browser as well as support information and if unsupported will draw a box of downloads for compatible browsers.

`quickDraw()` will echo just the info and support text

___
`fastBrowserCheck.php` provides a stripped down and faster way of checking the browser and returning the compatibility status.
Just import it and call `checkBrowser()` to return `true` or `false` on the browser's compatibility.
you can also call `checkBrowser(<user agent string>)` for testing purposes

### User agent overview
A User Agent String is a bit of text your browser sends along with its request to a website. It provides information about the browser that lets the website know what is requesting the webpage and can inform the website on what kind of content it wants to return. A common example would be filtering out requests from bots crawling your site.

For example `Mozilla/5.0 (Macintosh; Intel Mac OS X 10_13_0) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/61.0.3163.100 Safari/537.36` is the User Agent String for a Chrome browser version 61 on OSX 10.13

