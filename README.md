# QMVC
A **simple**, **secure** PHP7 MVC microframework.
______

QMVC v2.0 is on its way!
===================
Through positive feedback and continued development, **QMVC** has really been able to grow into its own with the impending v2.0 release. Featuring major changes to its code and available APIs, **QMVC v2.0** more readily fulfills its purpose as a **simple to use, and secure PHP7 MVC microframework**, which is **now more secure than ever**!

*Please note that while QMVC v2.0 is intended to be a simple and secure MVC solution for PHP7, do not rely entirely on the claims made here to gaurantee the security of your web application. Please follow proper procedure in testing and securing your application.*

----------

What's New in v2.0?
-------------
QMVC v2.0 is a complete rewrite of the original barebone application. The purpose of this rewrite can be categorized under two headings:

- To make QMVC **more secure** than ever
- Make QMVC **simpler to develop upon and easier to deploy**

To facilitate the new requirements several new features have been added in addition to the overall restructuring of the project:

- Implementations of Mozilla web security recommendations as defined [here](https://developer.mozilla.org/en-US/docs/Web/Security), Including Subresource Integrity, and Content Security Policy.

- Strictly PHP7 only code in QMVC v2.0 base code (*not including project dependencies*), avoiding any pitfalls caused by pre PHP7 vulnerabilities.

- QMVC v2.0 now uses the TWIG templating engine for view rendering.

- New Routing system that follows a laravel style router implementation. The new routing system now supports middleware for HTTP request and response manipulation.

- Removal of custom QMVC psudeo-ORM in favor of allowing user chosen ORM or other database management library.

- PHPUnit Unit Tests for all base core code.

- Switching to the Caddy web server instead of Apache for a simpler and more secure deploy.

- Migrating from Vagrant to Docker for simpler and less expensive development and testing.

Additionally greater care is now also taken to **sanitize both input and output data to/from the client side**, helping to defend against **injection attacks**. More on each of the aforementioned will be discussed in further detail in additional sections.

-------
Mozilla Web Security Recommendations
--------------
Mozilla in its series of [web security articles](https://developer.mozilla.org/en-US/docs/Web/Security) outlines several  measures that can be taken to help increase the security of websites and web applications by eliminating potential vulnerabilities. These recommendations fall under data sanitation, securely storing and transporting sensitive data, utilizing existing web protocols (HTTPS) to your advantage to secure your application, and others. 

Based on the wide area of coverage of these recommendations it is not possible to implement all of them in this barebone application, however many key recommendations are **already built into QMVC v2.0**.  

- QMVC v2.0 assures Content Security by using HTTP Strict Transport Security and Content Security Policy to reduce Man-in-the-middle, Cross Site Scripting(XSS), and data injection vulnerabilities.

-  QMVC v2.0 automatically detects server response content type and automatically sets the correct MIME header. While usually overlooked this is a potential attack vector. It is recommended that the server set the correct MIME type [instead of having the web browser guess](https://developer.mozilla.org/en-US/docs/Web/Security/Securing_your_site/Configuring_server_MIME_types#Why_browsers_should_not_guess_MIME_types).

- QMVC v2.0 will include a custom *TWIG extension* for supporting [subresource integrity](https://developer.mozilla.org/en-US/docs/Web/Security/Subresource_Integrity). Securing you application against any unexpected external resource alteration. 

-  TLS is of utmost importance, and that's why QMVC v2.0 made the big switch from Apache 2 to Caddy, but more on this will be discussed later.

In addition the Mozilla web security resources mentioned, [OWASP](https://www.owasp.org/index.php/Main_Page) was heavily used as a reference. OWASP though no longer heavily actively maintained is a not-for-profit organization focused on improving web security, that can be utilized as a trusted point of reference. 

*Please consider reading the entirety of both the Mozilla web security and OWASP web security document for information on how to properly secure your web application.* 


-------

Pure Object Oriented PHP7 code
-------------

The switch to PHP7 was a simple one, the richer feature set of PHP7 in addition to optimizations and known vulnerabilities made it the simple choice. PHP7 is more efficient than ever before:

- Improvements to optimizations for internal data structures have resulted in significant memory savings, increases in performance, and the ability to support a higher load capacity on the same hardware.

- PHP7 adds return types, and scalar type hints such as Boolean, float, and string. Allows for writing better, cleaner, more efficient code, and removes the need for constant, sometimes faulty type checking.

- Thought not used in QMVC v2.0, PHP7 does have support for asynchronous programming.

For a full list of PHP7 features see [here](http://php.net/manual/en/migration70.php).

Additionally PHP7 though still fairly new has resolved many vulnerabilities of previous versions of PHP7 without introducing many major new vulnerabilities. Details can be found here, [PHP7.1 vulnerabilities](https://www.cvedetails.com/vulnerability-list/vendor_id-74/product_id-128/version_id-206539/PHP-PHP-7.1.0.html), and here [PHP vulnerabilities version history](https://www.cvedetails.com/version-list/74/128/1/PHP-PHP.html).

-------

Switching to TWIG v2 Templating Engine
-------

The TWIG Templating engine was developed as a part of the PHP [symfony framework](https://symfony.com), however it readily available as an independent library to be used in any PHP application. 

Switching from regular PHP/HTML views to Compiled TWIG templates **abstracts backend code from front end, making it easier for front end developers to work independently of backend developers**.

While there exist other templating engines, TWIG was selected after considering factors presented in the following articles: [TOP 5 PHP templating engines](http://www.sitecrafting.com/blog/top-5-php-template-engines/), and [OWASP XSS Cheat Sheet](https://www.owasp.org/index.php/XSS_(Cross_Site_Scripting)_Prevention_Cheat_Sheet). TWIG is not only popular, but has active development, a large reservoir of documentation and support, and includes many powerful features that **increase the flexibility and security of applications that use TWIG**. [Such as contextuale escaping](https://twig.symfony.com/doc/2.x/filters/escape.html).

Additionally if any features desired are not by default included in the TWIG templating engine, it is easy to just write a [TWIG extension](https://twig.symfony.com/doc/2.x/advanced.html).


--------

New Routing System
--------

Previously QMVC v1.0 used an Angular like routing style

> *Angulars routing system primarily focused on the use of States, which were composed of a view bound to a controller. While this style of routing makes sense when considering a framework that will only be used to develop web applcations where views and controllers are tightly coupled.  QMVC v2.0 seeks to be useful not only for developing MVC applications, but regular web APIs as well.*

Instead, **QMVC v2.0 has switched to a laravel style routing**. Laravel which is one of the most popular PHP web frameworks, is known for its simple routing, which makes it easy and quick to get a web application up and running.

Routes will no longer tightly couple a controller to a view, thus creating and impleneting new routes will be simpler than ever. Additionally with the inclusion of the TWIG templating engine, returning views is simpler than ever.

**Middlewares** are the coolest new feature added to QMVC. Middlewares make it possible to manipulate Request and Response data *before and after* being proccessed by a route's handling method.

---------

Removing QMVC Native Database Interface
--------

QMVC v1.0 boasted an incomplete Native Interface for Querying MySQL databases. This psuedo **ORM** required users of QMVC to manually write and implement their own models since it had no scafolding tools. 

Additionally the functionality supported was very very limited, while the system not being a complete ORM of its own could be crudely manipulated to possibly perform malicious attacks.

This functionality from **QMVC v1.0** was directly in opposition to the desired results of **QMVC v2.0**, and as such was subsequently removed.

Adding a popular PHP ORM was considered at first, however after much deliberation this was decided against. QMVC on its own would not provide any additional functionality or interface over the ORM, therefore there was no point in choosing one prematurely.

However it is recommended to use an ORM that will fulfill the criteria of being:

- Simple to use.
- Supports major relational database systems: **MySQL, SQL Server, PostgreSQL, and SQLite**.
- Secure with no major known vulnerabilities that have not been patched.
- Extensive documentation and support available.

Against these criteria QMVC v2.0 suggests choosing from one of the following ORMs:

- [Doctrine 2](http://www.doctrine-project.org) ---  [Vulnerability Report](http://www.cvedetails.com/vendor/11395/Doctrine-project.html)
- [RedBeanPHP](https://redbeanphp.com/index.php)
- [Propel](http://propelorm.org)

Due consideration should be given to which ORM is chosen, but regardless of ORM chosen proper data sanitization practices will help to secure your data source.

--------

Unit Tests for all QMVC v2.0 core code
--------

All QMVC v2.0 core code has been tested using [PHPUnit](https://phpunit.de). Unit tests are available in the [**Base/Tests/**](https://github.com/infinityCounter/QMVC/tree/dev_v2.0/Base/Tests) directory. Writing tests with PHPUnit is fairly simple and it ensures code functions as expected before a deploy or publish. 

Testing against multiple casses in a controlled environemnt reveals flaws and potential attack vectors in your code. Which is why QMVC v2.0 now recommends using **PHPUnit** or any other unit testing framework of your choosing to properly test all your code when developing. **Aim for max test coverage!** Maybe give [Test Driven Development](https://code.tutsplus.com/tutorials/lets-tdd-a-simple-app-in-php--net-26186) a spin while you're at it. 

--------

Caddy, a mondern webserver
--------


--------

Contributing
------

Feel free to submit any pull request or fork and continue to develop!

Lincensed under the MIT license, see [here](https://github.com/infinityCounter/QMVC/blob/dev_v2.0/LICENSE).

-------

*DOCUMENTATION TO BE UPDATED IN THE FUTURE*

author: Emile Keith (@infinityCounter)
