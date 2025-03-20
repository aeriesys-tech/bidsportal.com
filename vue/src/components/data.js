// export function getData(){
//     var ul = document.getElementById("tree1");
//     var li = document.createElement("li");
//     li.appendChild(document.createTextNode("Four"));
//     ul.appendChild(li);
// }

export function getData(naics){
    var li = document.getElementById(naics.naics_id);
    var ul = document.createElement("ul");
    naics.naics_parent.map(function(element){
        var li1 = document.createElement("li");
        li1.setAttribute('id', element.naics_id);
        li1.addEventListener("click", getData(element));
        li1.appendChild(document.createTextNode(element.naics_desc));
        ul.appendChild(li1);
    })
    li.appendChild(ul)
}