function search(){
    var searchInput = document.getElementById('searchInput');
    var suggestionsSearch = document.getElementById('suggestionsSearch');
    let searchObj = {
        search: searchInput.value
    }
    if(searchInput.value.length == 0){
        var dropdown = document.getElementById("myDropdown");
        dropdown.innerHTML = '';
    }
    if(searchInput.value.length>2){

        hiddenFunction("loaderIcon");


        let post = JSON.stringify(searchObj)
        var baseUrl = window.location.origin;
        const url = baseUrl+"/api/search";
        let xhr = new XMLHttpRequest()

        xhr.open('POST', url, true)
        xhr.setRequestHeader('Content-type', 'application/json; charset=UTF-8')
        xhr.send(post);

        xhr.onload = function () {
            if(xhr.status === 200) {
                hiddenFunction("loaderIcon");

                var dropdown = document.getElementById("myDropdown");
                dropdown.innerHTML = '';
                var obj =  JSON.parse(xhr.response);
                var events = obj.data.events;
                var users = obj.data.users;
                var organizations = obj.data.organizations;
                var teams = obj.data.teams;

                for (const e of events) {
                    const tag = document.createElement("p");
                    const text = document.createTextNode("Event "+e.title);
                    tag.appendChild(text);
                    tag.setAttribute("onclick","selectSearchRsult('events/detail',"+e.id+")");
                    dropdown.appendChild(tag);
                }
                for (const e of users) {
                    const tag = document.createElement("p");
                    const text = document.createTextNode("User "+e.name);
                    tag.appendChild(text);
                    tag.setAttribute("onclick","selectSearchRsult('users',"+e.id+")");
                    dropdown.appendChild(tag);
                }
                for (const e of organizations) {
                    const tag = document.createElement("p");
                    const text = document.createTextNode("Organization "+e.name);
                    tag.appendChild(text);
                    tag.setAttribute("onclick","selectSearchRsult('organizations',"+e.id+")");
                    dropdown.appendChild(tag);
                }
                for (const e of teams) {
                    const tag = document.createElement("p");
                    const text = document.createTextNode("Team "+e.name);
                    tag.appendChild(text);
                    tag.setAttribute("onclick","selectSearchRsult('teams',"+e.id+")");
                    dropdown.appendChild(tag);
                }
            }
        }

    }


}
function hiddenFunction(id) {
    var x = document.getElementById(id);
    if (x.style.display === "none") {
        x.style.display = "block";
    } else {
        x.style.display = "none";
    }
}
function selectSearchRsult(type,id) {
    window.location.href = "/"+type+"/"+id;

}

function filterFunction() {
    var input, filter, ul, li, a, i;
    input = document.getElementById("myInput");
    filter = input.value.toUpperCase();
    div = document.getElementById("myDropdown");
    a = div.getElementsByTagName("a");
    for (i = 0; i < a.length; i++) {
        txtValue = a[i].textContent || a[i].innerText;
        if (txtValue.toUpperCase().indexOf(filter) > -1) {
            a[i].style.display = "";
        } else {
            a[i].style.display = "none";
        }
    }
}
