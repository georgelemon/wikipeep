import json, jester

## Implement dynamicall calling procedures
# https://github.com/krux02/opengl-sandbox/blob/master/examples/console.nim

template json_response*(data: JsonNode, code=Http200): untyped =
    ## Template for creating a REST API Response via JSON module
    mixin resp
    resp code, @{"Content-Type": "application/json"}, $(data)

template view*(data:string, code=Http200): untyped =
    ## Template for creating a Response HTML based on given view
    mixin resp
    resp code, data


template viewHomepage*(): untyped =
    ## Template for creating homepage view
    view("test template")

template viewArticle*(): untyped =
    ## Template for creating single article view
    view("test single article")

template viewSection*(): untyped =
    ## Template for creating section view containing articles
    view("test section")


template rest*(endpoint:string): untyped =
    ## Create REST API Responses
    json_response(%*{
            "status": 200,
            "entries": {
                "github": "https://github.com/georgelemon/wikipeep",
                "documentation": "https://github.com/georgelemon/wikipeep/wiki",
                "powered_by": "🃏 Jester Framework | Written in Nim",
                "license": "GPLv3",
            }
        }, Http200)
