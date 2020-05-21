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
                    if(main_home){
                        unwrap(document.querySelector(".home-nav>div"));
                        document.querySelector(".home-nav").className="main-search-nav";
                    } 
                    var search_container = document.createElement("div");
                        if(!main_home){
                            document.querySelector(".search-container").replaceWith(search_container);
                        } 
                        search_container.className="search-container";
                    var result_status = document.createElement("div");
                        result_status.className="result-status";
                        result_status.innerHTML = (response[0][1]==0 ? "No" : response[0][1])+ " results found";
                    var search_result = document.createElement("div");
                        search_result.className="search-result";
                        
                        for(var i=1; response[i]; i++){
                            var each_card = document.createElement("div");
                                each_card.className="each-card";
                                each_card.setAttribute("data-roll-id", response[i][1]);

                                each_card.onclick = function(e){
                                    showVisitPage(rollId=e.target.parentNode.dataset.rollId);
                                }

                            var back_img = document.createElement("div");
                                back_img.className="back-img";
                                var img_url = response[i][1].indexOf('AS076')!=-1 ? "no-pic.png" : `http://202.70.84.165/img/student/${response[i][1]}.jpg`;
                                back_img.style.backgroundImage='url('+ img_url + ')';
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

    document.getElementById("pop-close").addEventListener("click", function(){
        document.querySelector(".popup-main").style.transform = "scale(0)";
        document.querySelector(".pop-between").innerHTML = "";
        document.body.style = "";
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

function showVisitPage(rollId){
    var request = makeRequest("GET", `api/local/main.php?who=${rollId}`);
    if(!request) {
        console.log('Request not supported');
        return;
    }
    request.onreadystatechange = () => {
        if(request.readyState==4&&request.status==200){
            var response=JSON.parse(request.responseText);

            document.querySelector(".popup-main").style.transform = "scale(1)";
            document.body.style.overflow = "hidden";
            
            var visit_container = document.createElement("div");
                visit_container.className="visit-container"; 
            var jst_div = document.createElement("div");
            var name = document.createElement("div");
                name.className="name";
                name.innerHTML=response[0];
            var image = document.createElement("div");
                image.className="image";
            var img = document.createElement("img");
                img.src = response[1].indexOf('AS076')!=-1 ? "no-pic.png" : `http://202.70.84.165/img/student/${response[1]}.jpg`;
                img.alt = "Student Picture";

                image.appendChild(img);
            var roll = document.createElement("div");
                roll.className="roll";
                roll.innerHTML=`Roll: ${response[1]}`;
            var popular = document.createElement("div");
                popular.className = "popular";
                popular.innerHTML = `Popularity: ${response[2]}`;

            jst_div.appendChild(name);
            jst_div.appendChild(image);
            jst_div.appendChild(roll);
            jst_div.appendChild(popular);
            visit_container.appendChild(jst_div);
            document.querySelector(".pop-between").appendChild(visit_container);
        }
        else if(request.readyState==4&&request.status!=200){
            console.log("Error occured!!!");
        }
    };
    request.send();
}