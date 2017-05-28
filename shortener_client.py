import urllib.request
import urllib.parse


def short_url(shortener_url, long_url, api_key):
    """
    Shortens an url
    :param shortener_url: url of your shortener script
    :param long_url: the url you want to shorten
    :param api_key: your key set in settings
    :return: short url
    """
    r = urllib.request.urlopen(shortener_url +
                               "/?link=" + urllib.parse.quote(long_url) +
                               '&key=' + urllib.parse.quote(api_key)).read().decode("UTF8")
    if r.startswith('Setting is not completed') or r.startswith("Wrong API key"):
        raise ValueError(r)
    return r
