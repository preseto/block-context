# [<img src="https://blockcontext.com/wp-content/uploads/sites/3/2018/11/block-context-logo.png" alt="Block Conete" width="80" align="left" /> Block Context for Gutenberg](https://blockcontext.com)

**A WordPress plugin to show or hide any Gutenberg block in context.**

[![Build Status](https://travis-ci.org/preseto/block-context.svg?branch=master)](https://travis-ci.org/preseto/block-context)

Source of the [Gutenberg Block Context plugin](https://blockcontext.com) for WordPress.


## Requirements

- WordPress 5.0+ or the [Gutenberg Plugin](https://wordpress.org/plugins/gutenberg/).
- [Composer](https://getcomposer.org) and [Node.js](https://nodejs.org) for dependency management.
- [Vagrant](https://www.vagrantup.com) and [VirtualBox](https://www.virtualbox.org) for local testing environment.


## Install

- Search for "Block Context" under "Plugins → Add New" in your WordPress dashboard.

- Install as a [Composer](https://packagist.org/packages/preseto/block-context) dependency:

	  composer require preseto/block-context


## Development

1. Clone the plugin repository:

	   git clone https://github.com/preseto/block-context.git
	   cd block-context

2. Setup the development environment and tools using [Composer](https://getcomposer.org) and [Node.js](https://nodejs.org):

	   composer install

3. Start a virtual testing environment using [Vagrant](https://www.vagrantup.com/) and [VirtualBox](https://www.virtualbox.org/):

	   vagrant up

	which will be available at [http://blockcontext.local](http://blockcontext.local) after provisioning (username: `admin`, password: `password`).

4. Build the plugin JS and CSS assets:

	   composer build


## Screenshots

TODO


## Credits

Created by [Kaspars Dambis](https://kaspars.net).
