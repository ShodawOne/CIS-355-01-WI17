// URL String
//rootURL     = "http://csis.svsu.edu/";
rootURL     = "https://csis.svsu.edu/";
//userNameURL = "~alpero";
userNameURL = "~mrdurfee/cis355/booklistapp/";
ajaxURL = "ajax/";
URL         = rootURL + userNameURL + ajaxURL;

// Get ID from URL
function getID() {
    id = window.location.search.substring(1);
    id = id.split("=");
    return id[1];
}

