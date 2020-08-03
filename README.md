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

You can type `./bin/puc` to see all available commands.

To get you started, add at least one utility:
```
./bin/puc utility:create gas
```

Every time you top up or read your meter, add that data in:
```
./bin/puc reading:add gas 15 10
```

Here we've added €10 and the total after top-up was €15.
If you just read your meter without topping up, simply omit the last parameter.

Once you've added some data (at least two entries), you can generate prediction:
```
./bin/puc expiration:calculate gas --event
```

The output will tell you an estimate of the expiration date.
The `--event` option will even generate a calendar event if you need a reminder.