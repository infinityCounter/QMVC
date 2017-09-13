# QMVC
A barebone, secure, simple PHP7 MVC application.
______

QMVC v2.0 is on its way!
===================
Through positive feedback and continued development, **QMVC** has really been able to grow into its own with the impending v2.0 release. Featuring major changes to its code and available APIs, **QMVC v2.0** more readily fulfills its purpose as a **simple to use barebone PHP7 MVC application**, which is **now more secure than ever**!

----------

What's New in v2.0?
-------------
QMVC v2.0 is a complete rewrite of the original barebone application. The purpose of this rewrite can be categorized under two headings:

- To make QMVC **more secure** than ever
- Make QMVC **simpler to develop upon and easier to deploy**

To facilitate the new requirements several new features have been added in addition to the overall restructuring of the project:

- Implementations of Mozilla web security recommendations as defined [here](https://developer.mozilla.org/en-US/docs/Web/Security), Including Subresource Integrity, and Content Security Policy.

- Strictly PHP7 only code in QMVC v2.0 base, avoiding any pitfalls caused by pre PHP7 vulnerabilities.

- QMVC v2.0 now uses the TWIG templating engine for view rendering.

- New laravel style router instead of the QMVC v1.0 Angular like state router.

- Removal of custom QMVC psudeo-ORM infavor of allowing user chosen ORM or other database management library.

- Middlewares for HTTP request interactions.

- PHPUnit Unit Tests for all base core code.

- Switching to the Caddy web server instead of Apache for a simpler and more secure deploy.

- Migrating from Vagrant to Docker for simpler and less expensive development and testing.

Additionally greater care is now also taken to **sanitize both input and output data to/from the client side** as to protect as **injection attacks**. More on each of the aforementioned will be discussed in further detail in additional sections.

-------

Pure Object Oriented PHP7 code
-------------

The switch to PHP7 was a simple one, the richer feature set of PHP7 in addition to optimizations and known vulnerabilities made it the simple choise. PHP7 is more efficient than ever before:

- Improvements to optimizations for internal data structures have resulted in significant memory savings, increases in performance, and the ability to support a higher load capacity on the same hardware.

- PHP7 adds return types, and scalar type hints such as Boolean, float, and string. Allows for writing better, cleaner, more efficient code, and removes the need for constant, sometimes faulty type checking.

- Thought not used in QMVC v2.0, PHP7 does have support for asynchronous programming.

For a full list of PHP7 features see [here](http://php.net/manual/en/migration70.php).

Additionally PHP7 though still fairly new has resolved many vulnerabilities of previous versions of PHP7 without introducing many major new vulnerabilities. Details can be found here, [PHP7.1 vulnerabilities](https://www.cvedetails.com/vulnerability-list/vendor_id-74/product_id-128/version_id-206539/PHP-PHP-7.1.0.html), and here [PHP vulnerabilities version history](https://www.cvedetails.com/version-list/74/128/1/PHP-PHP.html).

-------

*DOCUMENTATION TO BE UPDATED IN THE FUTURE*
author: Emile Keith (@infinityCounter)
