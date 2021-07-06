import json, os, strutils, asyncdispatch, jester
import backend/controller

proc getSectionByName(section:string): string =
    ## Retrieve the section name from URL
    return section

proc getArticleByName(article:string): string =
    ## Retrieve the article slug from URL
    return article

# https://github.com/omrilotan/isbot/blob/main/index.js
# proc isBot(agent:string): bool =
    ## Determine if current request is made by a bot.
    # return agent

# proc sendResponse() =
    ## Send HTTP Response
    ## For SEO bots will serve only text/markup contents

## Register Wikipeep routes
router routes:
    # GET Method for home page
    get "/":
        controller.viewHomepage()

    # GET Endpoint for root api
    get "/backdoor":
        controller.rest("index")

    # GET Endpoint for retrieving articles
    get "/backdoor/articles":
        controller.rest("articles")

    # GET Endpoint for retrieving sections
    get "/backdoor/sections":
        controller.rest("sections")

    # # GET Method for retrieving a single article page
    # get "/@section/@article":
    #     resp(getSectionByName(@"section")&" "&getArticleByName(@"article"))

    # GET Endpoint for retrieving Wikipeep settings
    get "/backdoor/settings":
        controller.rest("settings")
    
    # Handle 404 Errors
    error Http404:
        resp Http404, "404 | Looks you took a wrong turn somewhere."

    # Handle 500 Errors
    error Exception:
        resp Http500, "500 | Something bad happened: " & exception.msg

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