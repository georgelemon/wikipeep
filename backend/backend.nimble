# Package

version       = "0.1.0"
author        = "George Lemon"
description   = "Open Source Wiki for Busy Devs"
license       = "GPL-3.0-only"
srcDir        = "src"
bin           = @["backend"]
binDir        = "../bin"
namedBin["backend"] = "server"


# Dependencies

requires "nim >= 1.4.8"
requires "jester >= 0.5.0"
