import json

template json*(message: JsonNode, code): untyped =
    mixin resp
    resp code, @{"Content-Type": "application/json"}, $(message)