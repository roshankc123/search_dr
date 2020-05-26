var each_card_count;
var total_results;
var srch_inpt_value;
window.onload = ()=>{
    var main_home=true;
    var randomAnchor = document.querySelector(".home-search-items form > a");
    randomAnchor.replaceWith(randomAnchor.lastChild);
    var srch_inpt = document.querySelector("input[type=search]");

    var data_inform_close = document.createElement("span");
        data_inform_close.innerHTML="&times;";
    document.querySelector(".foot").appendChild(data_inform_close);
    data_inform_close.onclick=function(){
        this.parentNode.style.display="none";
    }

    document.querySelector("button.btn").addEventListener("click", function(e){
        randomVisitPage();
    });

    document.getElementById("search-btn").addEventListener("click", function(e){
        e.preventDefault();
        each_card_count=0;
        total_results=0;
        if(srch_inpt.value.length>0){
            srch_inpt_value = srch_inpt.value;
            var offset=0;
            this.innerHTML="<div class='small-loader'></div>";
            this.setAttribute("disabled", "");
            var request = makeRequest("GET", `api/local/main.php?search=${srch_inpt_value}`);
            if(!request) {
                console.log('Request not supported');
                return;
            }
            request.onreadystatechange = () => {
                if(request.readyState==4&&request.status==200){
                    var response=JSON.parse(request.responseText);
                    total_results = response[0][1];
                    this.innerHTML="Search";
                    this.removeAttribute("disabled");
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
                                this.innerHTML="<div class='small-loader' style='border: 2px solid #000; border-top: 2px solid #fff;'></div>";
                                this.setAttribute("disabled", "");
                                addMoreContent(offset+=20);
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

function showVisitForOffline(offset){
    var div = document.querySelector(`.search-container>.search-result>.each-card[data-count=\"${offset}\"]`);
    var datas = [
        div.childNodes[2].innerHTML,
        div.dataset.rollId,
        div.childNodes[3].value
    ];
    visitContentBuilder(datas, offset);

    document.querySelector(".popup-main").style.transform = "scale(1)";
    document.body.style.overflow = "hidden";
}

function randomVisitPage(){
    var request = makeRequest("GET", "api/local/main.php?who=random");
    document.querySelector(".popup-main").style.transform = "scale(1)";
    document.body.style.overflow = "hidden";
    var loader_=document.querySelector(".loader");
    try{document.querySelector(".visit-container").replaceWith(loader_);} catch {}
    loader_.style.display="inline-block";

    if(!request) {
        console.log('Request not supported');
        return;
    }
    request.onreadystatechange = () => {
        if(request.readyState==4&&request.status==200){
            var response=JSON.parse(request.responseText);
            
            document.getElementById("loader-div").appendChild(loader_);
            loader_.style.display="none";

            visitContentBuilder(response, offset=1, for_="random");
        }
        else if(request.readyState==4&&request.status!=200){
            console.log("Error occured!!!");
        }
    };
    request.send();
}

function addMoreContent(offset, for_=null){
    var request = makeRequest("GET", `api/local/main.php?search=${srch_inpt_value}&offset=${offset}`);
    
    if(!request) {
        console.log('Request not supported');
        return;
    }
    request.onreadystatechange = () => {
        if(request.readyState==4&&request.status==200){
            var response=JSON.parse(request.responseText);
            document.getElementById("more").innerHTML="More";
            document.getElementById("more").removeAttribute("disabled");
            loopForEachCard(response, document.querySelector('.search-container .search-result'))

            if(total_results<=(offset+20)){
                document.querySelector(".search-container .more-div").remove();
            }
            if(for_){
                var loader_=document.querySelector(".loader");
                document.getElementById("loader-div").appendChild(loader_);
                loader_.style.display="none";
                visitContentBuilder(response[0], offset);
            }
        }
        else if(request.readyState==4&&request.status!=200){
            console.log("Error occured!!!");
        }
    };
    request.send();
}

function loopForEachCard(response, appending_parent){
    var i = isNaN(response[0][1]-0) ? 0 : 1;
    for(i; response[i]; i++){
        var each_card = document.createElement("div");
            each_card.className="each-card";
            each_card.setAttribute("data-roll-id", response[i][1]);
            each_card.setAttribute("data-count", each_card_count+=1);                           
            each_card.onclick = function(e){
                showVisitForOffline(parseInt(this.dataset.count));
            }

        var back_img = document.createElement("div");
            back_img.className="back-img";
            var img_url = response[i][1].indexOf('AS076')!=-1 ? "no-pic.png" : `http://202.70.84.165/img/student/${response[i][1]}.jpg`;
            back_img.style.backgroundImage='url('+ img_url + ')';
        var roll = document.createElement("div");
            roll.className="roll";
        var name = document.createElement("div");
            name.className="name";
        var popular = document.createElement("input");
            popular.type="hidden";

        roll.innerHTML=response[i][1];
        name.innerHTML=response[i][0];
        popular.value=response[i][2];

        each_card.appendChild(back_img);
        each_card.appendChild(roll);
        each_card.appendChild(name);
        each_card.appendChild(popular);
        appending_parent.appendChild(each_card);
    }
}

function prevOrNextVisit(offset, for_="prev"){
    offset = for_=="prev" ? offset-1 : offset+1;
    var next_div = document.querySelector(`.search-container>.search-result>.each-card[data-count=\"${offset}\"]`);
    if(!next_div){
        addMoreContent(offset, for_);
        var loader_=document.querySelector(".loader");
        document.querySelector(".visit-container").replaceWith(loader_);
        loader_.style.display="inline-block";
    } else {
        var datas = [
            next_div.childNodes[2].innerHTML,
            next_div.dataset.rollId,
            next_div.childNodes[3].value
        ];
        visitContentBuilder(datas, offset, for_);
    }    
}

function visitContentBuilder(response, offset, for_=null){
    var img_src = response[1].indexOf('AS076')!=-1 ? "no-pic.png" : `http://202.70.84.165/img/student/${response[1]}.jpg`;
    console.log(for_);
    if(for_ && for_!="random"){
        document.querySelector(".visit-container div:first-child div.name").innerHTML=response[0];
        document.querySelector(".visit-container div:first-child div.image img").src=img_src;
        document.querySelector(".visit-container div:first-child div.roll").innerHTML=`Roll: ${response[1]}`;
        document.querySelector(".visit-container div:first-child div.popular").innerHTML=`Popularity: ${response[2]}`;

        var prev = document.getElementById("prev");
        var next = document.getElementById("next");
    }
    else {
        var visit_container = document.createElement("div");
            visit_container.className="visit-container"; 
        var jst_div = document.createElement("div");
            jst_div.setAttribute("data-count", offset);                        
        var name = document.createElement("div");
            name.className="name";
            name.innerHTML=response[0];
        var image = document.createElement("div");
            image.className="image";
        var img = document.createElement("img");
            img.src = img_src;
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
        var next_prev_div = document.createElement("div");
            next_prev_div.className="next-prev-div";
        var prev = document.createElement("button");
            prev.id="prev";
            next_prev_div.appendChild(prev);                
        var next = document.createElement("button");
            next.id="next";
            next_prev_div.appendChild(next);

        visit_container.appendChild(next_prev_div);
        document.querySelector(".pop-between").appendChild(visit_container);
    }
    prev.className= offset==1?"hidden":"";
    next.className= offset==total_results?"hidden":"";

    prev.onclick=function(e){
        prevOrNextVisit(offset);
    };
    next.onclick=function(e){
        if(for_=="random"){
            randomVisitPage();
        } else {
            prevOrNextVisit(offset, "next");
        }
    };
}