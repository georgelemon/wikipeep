import markdown

let test = """
# WikiPeep & i18n Support
Currently, WikiPeep version <code>1.0.0</code> does not support internationalization. But this is already in [roadmap for January 2021](/roadmap).
"""

proc parser*(): string =
    return markdown(test)