window.onload = ()=>{
    var main_home=true;
    var randomAnchor = document.querySelector(".home-search-items form > a");
    randomAnchor.replaceWith(randomAnchor.lastChild);
    var srch_inpt = document.querySelector("input[type=search]");

    document.getElementById("search-btn").addEventListener("click", function(e){
        e.preventDefault();
        if(srch_inpt.value.length>0){
            var request = makeRequest("GET", `api/local/main.php?search=${srch_inpt.value}`);
            if(!request) {
                console.log('Request not supported');
                return;
            }
            request.onreadystatechange = () => {
                if(request.readyState==4&&request.status==200){
                    var response=JSON.parse(request.responseText);
                    console.log(response);
                    if(main_home){
                        unwrap(document.querySelector(".home-nav>div"));
                        document.querySelector(".home-nav").className="main-search-nav";
                    } 
                    var search_container = document.createElement("div");
                        if(!main_home){
                            document.querySelector(".search-conainer").replaceWith(search_container);
                        } 
                        search_container.className="search-conainer";
                    var result_status = document.createElement("div");
                        result_status.className="result-status";
                        result_status.innerHTML = (response[0][1]==0 ? "No" : response[0][1])+ " results found";
                    var search_result = document.createElement("div");
                        search_result.className="search-result";
                        
                        for(var i=1; response[i]; i++){
                            var each_card = document.createElement("div");
                                each_card.className="each-card";
                                each_card.setAttribute("data-roll-id", response[i][1]);
                            var back_img = document.createElement("div");
                                back_img.className="back-img";

                                /* Here is the problem */
                                
                                back_img.style="background-image: url('no-pic.png');background-color: #00CED1;background-size: cover;width: 200px;height: 230px; position: relative;margin-right: 5px;";
                                console.log(back_img.style.backgroundImage);
                            var roll = document.createElement("div");
                                roll.className="roll";
                            var name = document.createElement("div");
                                name.className="name";

                            roll.innerHTML=response[i][1];
                            name.innerHTML=response[i][0];

                            each_card.appendChild(back_img);
                            each_card.appendChild(roll);
                            each_card.appendChild(name);
                            search_result.appendChild(each_card);
                        }
                    search_container.appendChild(result_status);
                    search_container.appendChild(search_result);
                    document.body.appendChild(search_container);
                    
                    main_home=false;
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

// Remove enclosing container and put content of the enclose div outside
function unwrap(wrapper) {
    var docFrag = document.createDocumentFragment();
    while (wrapper.firstChild) {
        var child = wrapper.removeChild(wrapper.firstChild);
        docFrag.appendChild(child);
    }
    wrapper.parentNode.replaceChild(docFrag, wrapper);
}