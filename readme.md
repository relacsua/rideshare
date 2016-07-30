# RideShare

![RideShare](screenshots/WelcomePage.png)

### Introduction

A CS2102(Introduction to Database Systems) project. A car sharing app built on Laravel PHP Framework and Oracle Database. Refer to the [project report](https://goo.gl/A36Hwp), for more info.

### Installation

#### Setting up the vagrant environment

1. Install [Virtual Box](https://www.virtualbox.org/)
2. Install [Vagrant](https://www.vagrantup.com/downloads.html)
3. Setup [laravel/homestead](http://laravel.com/docs/5.1/homestead) environment.

#### Setting up project

1. Clone this repository into your projects folder.
2. Run ```$ composer update```. Make sure [composer](https://getcomposer.org/doc/00-intro.md) is installed before you run this command.
3. Change directory to your homestead directory and run these commands: ```$ vagrant run``` and ```$ vagrant ssh```
4. Setup oracle in the homestead environment by following this [guide](http://kogentadono.com/2011/11/02/installing-oci8-on-ubuntu/).
5. Connect to the SoC vpn for Oracle access, if you are connecting outside of school.
6. The website can be accessed at http://homstead.app.