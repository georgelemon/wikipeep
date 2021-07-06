import clymene
import cli/commands/[status, publish, make]

let sheet = """
Wikipeep 🤟 Open Source Wiki for Busy Devs

Usage:
    wikipeep status                       # Determine if there are any unpublished changes #
    wikipeep publish <status>             # Compile markdown contents and publish for 'new' or 'updates' #
    wikipeep make <visibility>            # Make your Wikipeep instance private or public #
    wikipeep (-h | --help)
    wikipeep (-v | --version)

Options:
    -h --help        Show this screen.
    -v --version     Show version.
"""

when isMainModule:
    let args = docopt(sheet, version = "Wikipeep 0.1.0")

    if args["status"]:
        echo "get status"
    elif args["publish"]:
        echo publish.command(args)
    elif args["make"]:
        echo "change the wikipeep visibility"
