# Pharenheit

## Overview

Pharenheit allows you to develop in [http://scriptor.github.com/pharen/](Pharen) without the need to manually recompile
after each change.  Pharenheit even allows you to `require` other `.phn` files directly in your Pharen source, without
the need to precompile them first.

For example, here's `includer.phn`:

    ;includer.phn
    ;<?php require __DIR__ . '/../pharenheit.php'; return; ?>

    (require "includee.phn")
    (echo (greet-person "visitor"))

...and `includee.phn`:

    ;includee.phn
    ;<?php require __DIR__ . '/../pharenheit.php'; return; ?>

    (fn greet-person (name)
        (. "Hello " name "!"))

Notice how in `includer.phn` you can directly require a `.phn` file?

Pharenheit can also tell when a file has changed and will automatically recompile them as necessary on each load.

## Installation

In order to use Pharenheit, you need two things: `pharenheit.php` and the Pharenheit `.htaccess` file.  Place the
`.htaccess` file at the root of your Pharen project.  You may also place the `pharenheit.php` file there, although
its placement is not as important (just make sure you can require it).

In the `.htaccess` file, change the line

    SetEnv HTTP_PHAREN_HOME "E:\Apps\Pharen"

...to reflect the location of your Pharen install.  It needs to be the directory where `pharen.php` is.  Alternatively,
you can set the environment variables `PHAREN_HOME`.

At the top of all your Pharen source files, place the following line of code:

    ;<?php require '/path/to/pharenheit.php'; return; ?>

The `;` at the beginning ensures that Pharen treats it as a comment.  That's it!  It should work now.  Take a look at
the examples included in this repository for more help.

## Restrictions

Currently, Pharenheit only works for PHP web applications on Apache servers.