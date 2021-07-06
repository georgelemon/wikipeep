import ../md
import tables

proc command*(args: Table[system.string, system.any]):string =
    ## CLI Command for compiling and publishing contents
    return parser()