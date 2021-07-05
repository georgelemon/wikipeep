# Package

version       = "0.1.0"
author        = "George Lemon"
description   = "Wikipeep - Command Line Interface powered by Klymene"
license       = "GPL-3.0-or-later"
srcDir        = "src"
bin           = @["cli"]
binDir        = "../bin"
namedBin["cli"] = "cli"

# Dependencies

requires "nim >= 1.4.8"
requires "markdown >= 0.8.5"
requires "clymene >= 0.6.8"