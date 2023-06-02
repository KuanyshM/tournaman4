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
function searchCity(){
    var cityName = document.getElementById("cityName");
    console.log(cityName.value);
}
function selectCity(){
    var cityName = document.getElementById("cityName");
    console.log(cityName.value);
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
function redirect(url) {
    window.location.href = url;
}
function setCategories(idParentElement,idElement,data) {
    var parentSelection = document.getElementById(idParentElement);
    var selection = document.getElementById(idElement);
    selection.innerHTML = "";
    console.log(data)
    console.log(parentSelection.value)
    for (const subc of data) {
        if(subc.parent_id==parentSelection.value){
            var opt = document.createElement('option');
            opt.value = subc.id;
            opt.innerHTML = subc.name;
            selection.appendChild(opt);

            console.log(subc);

        }
    }
}
function tournamentValidation(){
    var title = document.getElementById("title");
    var organization = document.getElementById("organization");
    var parentCategory = document.getElementById("parentCategory");
    var subCategory = document.getElementById("subCategory");
    var scope = document.getElementById("scope");
    var start_date = document.getElementById("start_date");
    var end_date = document.getElementById("end_date");
    var venue = document.getElementById("venue");
    var addressName = document.getElementById("addressName");
    var city = document.getElementById("city");
    var state = document.getElementById("state");
    var links = document.getElementById("links");
    var announceInput = document.getElementById("announceInput");
    var photo = document.getElementById("photo");
    var body = document.getElementById("body");
    var schedule = document.getElementById("schedule");
    var rules = document.getElementById("rules");
    var faq = document.getElementById("faq");
    var prize = document.getElementById("prizeText");
    var reg_start_date = document.getElementById("reg_start_date");
    var reg_end_date = document.getElementById("reg_end_date");
    var price = document.getElementById("price");
    var age_from = document.getElementById("age_from");
    var age_to = document.getElementById("age_to");
    var registration_info = document.getElementById("registration_info");

    if(title.value.length==0){
        valiAlert("Title");
        return;
    }
    if(organization==null){
        valiAlert("Organization");
        return;

    }
    if(parentCategory.value==0){
        valiAlert("Faction");
        return;

    }
    if(subCategory.value==0){
        valiAlert("Category");
        return;

    }
    if(scope.value.length==0){
        valiAlert("Scope");
        return;

    }
    if(start_date.value.length==0){
        valiAlert("Event Start date");
        return;

    }
    if(end_date.value.length==0){
        valiAlert("Event end date");
        return;

    }
    if(venue.value.length==0 &&
        addressName.value.length==0 &&
        city.value.length==0 &&
        state.value.length==0 &&
        links.value.length==0 &&
        announceInput.value.length==0

    ){
        valiAlert("Location");
        return;

    }

    if(photo.value.length==0){
        valiAlert("Photo");
        return;

    }
    if(body.value.length==0){
        valiAlert("About the tournament");
        return;

    }
    if(schedule.value.length==0){
        valiAlert("Schedule");
        return;

    }
    if(rules.value.length==0){
        valiAlert("Rules");
        return;

    }
    if(faq.value.length==0){
        valiAlert("FAQ");
        return;

    }
    if(prize.value.length==0){
        valiAlert("Prize");
        return;

    }
    if(reg_start_date.value.length==0){
        valiAlert("Registration start date");
        return;

    }
    if(reg_end_date.value.length==0){
        valiAlert("Registration end date");
        return;

    }
    if(price.value.length==0){
        valiAlert("Price");
        return;

    }
    if(age_from.value.length==0){
        valiAlert("Age");
        return;

    }
    if(age_to.value.length==0){
        valiAlert("Age");
        return;

    }
    if(registration_info.value.length==0){
        valiAlert("Registration info");
        return;

    }
    valiAlertClose();
    var form = document.getElementById("trnmForm");
    form.submit();





}
function videoValidation(){
    var title = document.getElementById("title");
    var body = document.getElementById("body");
    var parentCategory = document.getElementById("parentCategory");
    var subCategory = document.getElementById("subCategory");
    var link = document.getElementById("link");

    if(title.value.length==0){
        valiAlert("Название");
        return;
    }

    if(parentCategory.value==0){
        valiAlert("Жанр");
        return;

    }
    if(subCategory.value==0){
        valiAlert("Категория");
        return;

    }

    if(body.value.length==0){
        valiAlert("Описание");
        return;

    }
    if(link.value.length==0){
        valiAlert("Ссылка");
        return;

    }
    valiAlertClose();
    var form = document.getElementById("videoForm");
    console.log(form)
    form.submit();
}
function valiAlert(str){
    window.scrollTo(0, 0);
    var valiAlert = document.getElementById("valiAlert");
    valiAlert.style.display = "block";
    valiAlert.innerHTML = "Please check input parameters of <strong>"+str+"</strong> <br> Click to close";
}
function valiAlertClose(){
    var valiAlert = document.getElementById("valiAlert");
    valiAlert.style.display = "none";
}

function getYouTubeVideoId() {
    urlVideo = document.getElementById("linkTemp").value;
    videoImage = document.getElementById("videoImage");
    videoIDInput = document.getElementById("link");


    videoID = "";
    var regExp = /^.*((youtu.be\/)|(v\/)|(\/u\/\w\/)|(embed\/)|(watch\?))\??v?=?([^#&?]*).*/;
    var match = urlVideo.match(regExp);
    videoID = (match&&match[7].length==11)? match[7] : false;

    if (videoID) {

        if(checkResponseStatus(videoID)){
            photoURL = 'https://i.ytimg.com/vi/'+videoID+'/hqdefault.jpg'
            videoImage.setAttribute("src",photoURL)
            videoIDInput.value = videoID
            valiAlertClose();


            return videoID;
        }
    }
    videoImage.setAttribute("src","")
    videoIDInput.value = ""

    valiAlert("Неправильная ссылка")

   return videoID;
}

async function checkResponseStatus(videoID) {
    var baseUrl = window.location.origin;
    const url = baseUrl+"/api/checkVideo";
    try {
        var myHeaders = new Headers();
        myHeaders.append("Content-Type", "application/json");

        var raw = JSON.stringify({
            "videoID": videoID
        });

        var requestOptions = {
            method: 'POST',
            headers: myHeaders,
            body: raw,
            redirect: 'follow'
        };

        fetch(url, requestOptions)
            .then(response => response.text())
         //   .then(result => console.log(result))
            .catch(error => console.log('error', error));




    } catch (error) {
        console.error('Error checking video availability:', error.message);
        console.log('The URL is invalid or the video is not available.');
        return false

    }
    return false

}

