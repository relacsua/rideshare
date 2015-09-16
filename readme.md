# RideShare

Application that matches drivers with passengers.

## Setup with Vagrant

### Setting up the vagrant environment

1. Install [Virtual Box](https://www.virtualbox.org/)
2. Install [Vagrant](https://www.vagrantup.com/downloads.html)
3. Setup [laravel/homestead](http://laravel.com/docs/5.1/homestead) environment.

### Setting up project

1. Clone this repository into your projects folder.
2. Run ```$ composer update```. Make sure [composer](https://getcomposer.org/doc/00-intro.md) is installed before you run this command.
3. Change directory to your homestead directory and run these commands: ```$ vagrant run``` and ```$ vagrant ssh```
4. Setup oracle in the homestead environment by following this [guide](http://kogentadono.com/2011/11/02/installing-oci8-on-ubuntu/);
5. The website can be accessed at http://homstead.app.