# [HumHub](https://github.com/humhub/humhub) Basic Chat

This module was updated for HumHub Version 1.1.1
This is a fork of  <https://github.com/petersmithca/humhub-basic-chat>

## Description


This module adds a simple chat widget.  
Chats older than a defined amount of days are deleted by cron(!)

**Note:** The chat is more a shoutbox and not a real chat, cause it does not support user to user private chat.

Widget works on spaces, dashboard and profile, thanks to contributions from @WebCrew for styling and making more size agnostic

If you do not want one or more of these, its best to just edit the config and remove the lines for the section you dont want.

## Installation
1. Download the module and upload it to your modules directory >yourdomain.com>protected>modules
2. Rename module directory ```humhub_chat``` (May not be required!)
3. Enable module from >Admin>Modules

## Administration

In `Administration -> Basic Chat` you can choose between two basic themes and define the timeout for cron
 