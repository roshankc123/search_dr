window.onload = ()=>{
    var randomAnchor = document.querySelector(".home-search-items form > a");
    randomAnchor.replaceWith(randomAnchor.lastChild);
    var srch_inpt = document.querySelector("input[type=search]");

    document.getElementById("search-btn").addEventListener("click", function(e){
        e.preventDefault();
        if(srch_inpt.value.length>0){
            var request = makeRequest("GET", `search_body.php?search=${srch_inpt.value}`);
            if(!request) {
                console.log('Request not supported');
                return;
            }
            
            request.onreadystatechange = () => {
                if(request.readyState==4&&request.status==200){
                    var response=request.responseText;
                    document.body.innerHTML=response;
                }
                else if(request.readyState==4&&request.status!=200){
                    console.log("Error occured!!!");
                }
            };
            request.send();
        }
    });
}

function makeRequest(method, url) {
    var request = new XMLHttpRequest();
    if ("withCredentials" in request) {
        request.open(method, url, true);
    } 
    else if (typeof XDomainRequest != "undefined") {
        request = new XDomainRequest();
        request.open(method, url);
    } else {
        request = null;
    }
    return request;
}