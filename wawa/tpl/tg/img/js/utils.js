 // about cnzz

function parseParams(url){
    if( url == undefined){
        url = window.location.href;
    }   
    var indexOfQ = url.indexOf('?');
    if( indexOfQ == -1){
        return {}; 
    }   
    var search = url.slice(indexOfQ + 1); 
    var hashes = search.split('&');
    var params = {};
    for(var i = 0; i < hashes.length; i++){
        var hash = hashes[i].split('=', 2); 
        if ( hash.length == 1){ 
            params[hash[0]] = ''; 
        } else {
            params[hash[0]] = decodeURIComponent(hash[1]).replace(/\+/g, " ");
        } 
    }
    return params;
}

function getParam(key){
    var params = parseParams();
    return params[key];
}

function trackEvent(category, action, label, value) {
   
}
