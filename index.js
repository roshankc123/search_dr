window.onload = ()=>{
    var main_home=true;
    var randomAnchor = document.querySelector(".home-search-items form > a");
    randomAnchor.replaceWith(randomAnchor.lastChild);
    var srch_inpt = document.querySelector("input[type=search]");

    document.querySelector("button.btn").addEventListener("click", function(e){
        showVisitPage();
    });

    document.getElementById("search-btn").addEventListener("click", function(e){
        e.preventDefault();
        if(srch_inpt.value.length>0){
            var srch_inpt_value = srch_inpt.value;
            var offset=0;
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
                        
                        loopForEachCard(response, search_result);
                    search_container.appendChild(result_status);
                    search_container.appendChild(search_result);

                    if(response[0][1]>19){
                        var more_div = document.createElement("div");
                            more_div.className="more-div";
                        var more = document.createElement("button");
                            more.innerHTML="More";
                            more.id="more";
                            more_div.appendChild(more);

                            more.onclick=function(e){
                                addMoreContent(srch_inpt_value, offset+=20, response[0][1]);
                            }
                        search_container.appendChild(more_div);
                    }
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

function showVisitPage(rollId=null,offset=-1){
    if(!rollId){
        rollId="random";
    }
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
                jst_div.setAttribute("data-count", offset);                        ////here
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
            next();
        }
        else if(request.readyState==4&&request.status!=200){
            console.log("Error occured!!!");
        }
    };
    request.send();
}

function addMoreContent(search_query, offset, total_results){
    var request = makeRequest("GET", `api/local/main.php?search=${search_query}&offset=${offset}`);
    
    if(!request) {
        console.log('Request not supported');
        return;
    }
    request.onreadystatechange = () => {
        if(request.readyState==4&&request.status==200){
            var response=JSON.parse(request.responseText);
            loopForEachCard(response, document.querySelector('.search-container .search-result'))

            if(total_results<=(offset+19)){
                document.querySelector(".search-container .more-div").remove();
            }
        }
        else if(request.readyState==4&&request.status!=200){
            console.log("Error occured!!!");
        }
    };
    request.send();
}

function loopForEachCard(response, appending_parent){
    var i=0;
    try{parseInt(response[0][1]);i=1;} catch{}
    for(i; response[i]; i++){
        var each_card = document.createElement("div");
            each_card.className="each-card";
            each_card.setAttribute("data-roll-id", response[i][1]);
            each_card.setAttribute("data-count", i);                           ///to count the data see line 119
            each_card.onclick = function(e){
                showVisitPage(rollId=e.target.parentNode.dataset.rollId,this.dataset.count);
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
        appending_parent.appendChild(each_card);
    }
}
function next(){
    var this_count=document.getElementsByClassName('visit-container')[0].childNodes[0].dataset.count;
    var nextid=document.getElementsByClassName('search-result')[0].childNodes[this_count].dataset.rollId;
    console.log(nextid);
    //document.getElementsByClassName('search-result')[0].childNodes[8].dataset.rollId;
}
