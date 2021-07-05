import json
import asyncdispatch, jester, os, strutils

proc getSectionByName(section:string): string =
    ## Retrieve the section name from URL
    return section

proc getArticleByName(article:string): string =
    ## Retrieve the article slug from URL
    return article

## Register Wikipeep routes
router routes:
    # GET Method for home page
    get "/":
        resp "It's alive!"

    # GET Method for retrieving a single article page
    get "/@section/@article":
        resp(getSectionByName(@"section")&" "&getArticleByName(@"article"))

    # GET Endpoint for root api
    get "/backdoor":
        const data = $(%*{
                "status": 200,
                "version": "0.1.0",
                "description": "Wikipeep | Fast & Open source wiki platform for busy devs",
                "about": {
                    "github": "https://github.com/georgelemon/wikipeep",
                    "documentation": "https://github.com/georgelemon/wikipeep/wiki",
                    "powered_by": "🃏 Jester Framework | Written in Nim",
                    "license": "GPLv3",
                }
            })
        resp(data, "application/json")

    # GET Endpoint for retrieving published articles
    get "/backdoor/articles":
        var data = $(%*{
                "status": 200,
                "entries": [],
            })

    # GET Endpoint for retrieving Wikipeep sections
    get "/backdoor/sections":
        var data = $(%*{
                "status": 200,
                "entries": [],
            })

    # GET Endpoint for retrieving Wikipeep settings
    get "/backdoor/settings":
        var data = $(%*{
                "status": 200,
                "entries": [],
            })
    
    # Handle 404 Errors
    error Http404:
        resp Http404, "Looks you took a wrong turn somewhere."

    # Handle 500 Errors
    error Exception:
        resp Http500, "Something bad happened: " & exception.msg

## Start Server procedure
## By default Wikipeep will boot on port 6531
proc startServer() =
    # let port = paramStr(1).parseInt().Port
    let port = Port(6520)
    let settings = newSettings(port=port)
    var jester = initJester(routes, settings=settings)
    jester.serve()

when isMainModule:
    startServer()