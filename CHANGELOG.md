# Changelog

All notable changes to `nova-notifications` will be documented in this file.

## 1.0.6 - 09.10.2018

* Remove custom styles to avoid Nova styles overriding

## 1.0.5

* Fix bug where notifications were not shown if there was only one
* Change how notifications and notifiables are found. Works not automatically. So the config is not necessary anymore.

## 1.0.4

* Remove TailwindCSS preflight to prevent overriding styles in Nova itself
* Make notificationClasses per default an array to prevent problem with checking length

## 1.0.3

* Added translation files for EN and FR
* Style CI fixes

## 1.0.2 - 2018-09-10

- The path to the migration directory was wrong. This was fixed.

## 1.0.1 - 2018-09-10

- The error message was not being shown on the send page when there was no notification class. This was fixed.

## 1.0.0 - 2018-09-10

- Initial release