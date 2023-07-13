function addQueryParameter(type) {
  var url = window.location.href;

  // Remove the existing query string, if present
  var index = url.indexOf("?");
  if (index !== -1) {
    url = url.substring(0, index);
  }

  // Add the new query parameter
  var separator = url.indexOf("?") !== -1 ? "&" : "?";
  var newUrl = url + separator + "type=" + type;
  window.location.href = newUrl;
}
