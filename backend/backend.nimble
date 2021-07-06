# Package

version       = "0.1.0"
author        = "George Lemon"
description   = "Open Source Wiki for Busy Devs"
license       = "GPL-3.0-only"
srcDir        = "src"
bin           = @["backend", "cli"]
binDir        = "../bin"
namedBin["backend"] = "server"
namedBin["cli"] = "cli"


# Dependencies

requires "nim >= 1.4.8"
requires "jester >= 0.5.0"
requires "norm >= 2.3.0"
requires "markdown >= 0.8.5"
requires "clymene >= 0.6.8"
requires "norm >= 2.3.0"