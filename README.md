# PAYG Utility Calculator

This is a command line tool to help predict when a pay-as-you-go utility will run out of credits.

## Why

This may not be a common problem, but I have to pay my gas upfront (using what is known as pay-as-you-go, or prepayment meter).
Furthermore, the place to check the amount left is located outside of my apartment, so I tend to always wonder how much I have left but am too lazy to check it out myself.

This tool allows me to simply input the rare few times I did check the amount left / topped up the amount and generate (basic) predictions based on that.

## Stack

This CLI tool is built using PHP 7.4 and Symfony Console.

It stores the data in a SQLite database thanks to Doctrine.

## How to use it

First, run `composer install` to build all the dependencies. It will also configure your SQLite DB.

Then you should be ready to go!

Simply type `./bin/puc` to see all available commands.
